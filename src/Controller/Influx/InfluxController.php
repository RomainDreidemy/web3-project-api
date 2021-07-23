<?php

namespace App\Controller\Influx;

use App\Entity\Module;
use App\Entity\Sensor;
use App\Entity\SensorType;
use App\Repository\ModuleRepository;
use App\Services\InfluxService;
use App\Services\ModuleService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class InfluxController extends AbstractController
{
    public function __construct(private InfluxService $service, private EntityManagerInterface $manager)
    {
    }

    public function __invoke(int $moduleId, int $sensorId, Request $request): array|JsonResponse
    {
        $requestStart = $request->get('start') ?? null;

        if(is_null($requestStart)){
            return $this->json(['message' => 'undefined start query parameter.'], 400);
        }

        $start = (new \DateTime)->setTimestamp($requestStart)->format('U');
        $end = (new \DateTime)->format('U');

        $module = $this->manager->getRepository(Module::class)->find($moduleId);
        $sensorType = $this->manager->getRepository(SensorType::class)->find($sensorId);

        $timeRange = [
            'start' => $start,
            'stop' => $end
        ];

        return $this->service->getMeasurementForTimeRange($module->getInfluxId(), $sensorType->getInflexId(), $timeRange);
    }
}
