<?php

namespace App\Controller\Module;

use App\Entity\Image;
use App\Repository\ModuleRepository;
use App\Services\UploadService;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class ModuleImageController extends AbstractController
{
    protected array $moduleImagesOptions = [
        'folder' => 'modules',
    ];

    #[Route('/modules/{id}/images', name: 'module_images_create', methods: ['POST'])]
    public function moduleImagesCreate(
        string $id,
        ModuleRepository $moduleRepository,
        UploadService $uploadService,
        EntityManagerInterface $manager,
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

            return $this->json([
                '$data' => '$uploadService->upload($file)',
            ]);

        } catch (Exception $e) {
            return $this->json($e, 400);
        }
    }
}