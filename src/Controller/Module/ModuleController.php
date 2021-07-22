<?php

namespace App\Controller\Module;

use App\Entity\Api\ModuleApi;
use App\Entity\Module;
use App\Repository\ModuleRepository;
use App\Services\ModuleService;
use PhpParser\Node\Expr\AssignOp\Mod;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ModuleController extends AbstractController
{
    public function __construct(private ModuleService $moduleService)
    {
    }

    public function __invoke(int $id): ModuleApi
    {
        return $this->moduleService->getModule($id);
    }
}
