<?php

namespace App\Controller\Module;

use App\Entity\Comment;
use App\Entity\Image;
use App\Enums\CommentKeys;
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
            $newComment = (new Comment())
                ->setModule($module)
                ->setText($request->get(CommentKeys::text, ''));

            $files = $request->files;
            foreach ($files as $file) {
                $fileUploaded = $uploadService->upload($file, $this->moduleCommentsImagesOptions);
                $newImage = (new Image())
                    ->setComment($newComment)
                    ->setCreatedAt(new DateTimeImmutable($fileUploaded['created_at']))
                    ->setFormat($fileUploaded['format'])
                    ->setPublicId($fileUploaded['public_id'])
                    ->setSecureUrl($fileUploaded['secure_url']);
                $newComment->addImage($newImage);
                $manager->persist($newImage);
            }

            $manager->persist($newComment);
            $manager->flush();

            return $this->json($normalizer->normalize($newComment, 'json', ['groups' => 'Comment:read']));
        } catch (Exception | ExceptionInterface $e) {
            return $this->json($e, 400);
        }
    }
}
