<?php

namespace App\Controller\Module;

use App\Entity\Module;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;use Symfony\Component\HttpFoundation\Request;


class ModuleImageController extends AbstractController
{
    #[Route('/api/modules/{id}/images', name: 'module_images_create' ,methods: ['POST'])]
    public function moduleImagesCreate(
        Module $module,
        Request $request
    ): JsonResponse
    {
        $data = $request->request->all();

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ModuleController.php',
        ]);
    }
}
