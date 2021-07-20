<?php

namespace App\Controller\Module;

use App\Entity\Image;
use App\Repository\ModuleRepository;
use App\Services\UploadService;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;


class ModuleImageController extends AbstractController
{
    protected array $moduleImagesOptions = [
        'folder' => 'modules',
    ];

    #[Route('/api/modules/{id}/images', name: 'module_images_create', methods: ['POST'])]
    public function moduleImagesCreate(
        string $id,
        ModuleRepository $moduleRepository,
        UploadService $uploadService,
        EntityManagerInterface $manager,
        NormalizerInterface $normalizer,
        Request $request
    ): JsonResponse
    {
        try {
            if (!$module = $moduleRepository->find($id)) {
                return $this->json('Module not found', 404);
            }

            $files = $request->files;

            foreach ($files as $file) {
                $fileUploaded = $uploadService->upload($file, $this->moduleImagesOptions);

                $newImage = (new Image())
                    ->setModule($module)
                    ->setCreatedAt(new DateTimeImmutable($fileUploaded['created_at']))
                    ->setFormat($fileUploaded['format'])
                    ->setPublicId($fileUploaded['public_id'])
                    ->setSecureUrl($fileUploaded['secure_url']);

                $manager->persist($newImage);
            }

            $manager->flush();

            return $this->json($normalizer->normalize($module->getImages(), 'json', ['groups' => 'Module:read']));

        } catch (Exception | ExceptionInterface $e) {
            return $this->json($e, 400);
        }
    }
}