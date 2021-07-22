<?php

namespace App\Controller;

use App\Entity\Module;
use App\Repository\ModuleRepository;
use App\Services\ModuleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ModuleSensorController extends AbstractController
{
    public function __construct(private ModuleService $moduleService, private ModuleRepository $moduleRepository)
    {
    }

    public function __invoke(int $id): array
    {
        return $this->moduleService->getActions($id);
    }
}
