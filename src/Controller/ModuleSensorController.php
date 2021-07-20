<?php

namespace App\Controller;

use App\Services\ModuleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ModuleSensorController extends AbstractController
{
    public function __construct(private ModuleService $moduleService)
    {
    }

    #[Route('/api/modules/{id}/sensors', name: 'module_sensors', methods: ['GET'])]
    public function index(int $id): JsonResponse|array
    {
        return $this->moduleService->getInformations($id);
    }
}
