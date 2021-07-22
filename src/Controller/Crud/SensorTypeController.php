<?php

namespace App\Controller\Crud;

use App\Entity\SensorType;
use App\Form\SensorTypeType;
use App\Repository\SensorTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/sensorType')]
class SensorTypeController extends AbstractController
{
    #[Route('/', name: 'sensor_type_index', methods: ['GET'])]
    public function index(SensorTypeRepository $sensorTypeRepository): Response
    {
        return $this->render('sensor_type/index.html.twig', [
            'sensor_types' => $sensorTypeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'sensor_type_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $sensorType = new SensorType();
        $form = $this->createForm(SensorTypeType::class, $sensorType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sensorType);
            $entityManager->flush();

            return $this->redirectToRoute('sensor_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sensor_type/new.html.twig', [
            'sensor_type' => $sensorType,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'sensor_type_show', methods: ['GET'])]
    public function show(SensorType $sensorType): Response
    {
        return $this->render('sensor_type/show.html.twig', [
            'sensor_type' => $sensorType,
        ]);
    }

    #[Route('/{id}/edit', name: 'sensor_type_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SensorType $sensorType): Response
    {
        $form = $this->createForm(SensorTypeType::class, $sensorType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sensor_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sensor_type/edit.html.twig', [
            'sensor_type' => $sensorType,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'sensor_type_delete', methods: ['POST'])]
    public function delete(Request $request, SensorType $sensorType): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sensorType->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sensorType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('sensor_type_index', [], Response::HTTP_SEE_OTHER);
    }
}
