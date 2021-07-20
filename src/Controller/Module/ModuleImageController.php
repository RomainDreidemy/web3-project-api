<?php

namespace App\Controller\Module;

use App\Repository\ModuleRepository;
use App\Services\UploadService;
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
        Request $request
    ): JsonResponse
    {
        try {
            $module = $moduleRepository->find($id);

            $files = $request->files;

            foreach ($files as $file) {
                return $this->json([
                    '$data' => $uploadService->upload($file, $this->moduleImagesOptions),
                ]);
            }

            return $this->json([
                '$data' => '$uploadService->upload($file)',
            ]);

        } catch (Exception $e) {
            return $this->json($e, 400);
        }
    }
}
