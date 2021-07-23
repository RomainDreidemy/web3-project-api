<?php

namespace App\Controller;

use App\Services\InfluxService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    #[Route('/api/login', name: 'api_login', methods: ['POST'])]
    public function apiLogin(): Response
    {
        return $this->json([]);
    }

    #[Route('/test', name: 'test', methods: ['GET'])]
    public function test(InfluxService $service): Response
    {
        $start = new \DateTime('-12 hours');
        $stop = new \DateTime();

        $timeRange = [
            'start' => $start->format('U'),
            'stop' => $stop->format('U')
        ];

        dd($service->getMeasurementForTimeRange('12345678', 'Air temperature', $timeRange));
    }
}
