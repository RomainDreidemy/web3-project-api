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
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ModuleCommentController extends AbstractController
{
    protected array $moduleCommentsImagesOptions = [
        'folder' => 'comments',
    ];

    #[Route('/api/modules/{id}/comment', name: 'module_comment_create', methods: ['POST'])]
    public function moduleCommentCreate(
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
                $fileUploaded = $uploadService->upload($file, $this->moduleCommentsImagesOptions);

                $newImage = (new Image())
                    ->setModule($module)
                    ->setCreatedAt(new DateTimeImmutable($fileUploaded['created_at']))
                    ->setFormat($fileUploaded['format'])
                    ->setPublicId($fileUploaded['public_id'])
                    ->setSecureUrl($fileUploaded['secure_url']);

                $manager->persist($newImage);
            }

            $manager->flush();

//            return $this->json($normalizer->normalize($module->getImages(), 'json', ['groups' => 'Module:read']));

        } catch (Exception | ExceptionInterface $e) {
            return $this->json($e, 400);
        }
    }
}
