<?php

namespace App\Controller\Crud;

use App\Entity\Vegetable;
use App\Form\VegetableType;
use App\Repository\VegetableRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/vegetable')]
class VegetableController extends AbstractController
{
    #[Route('/', name: 'vegetable_index', methods: ['GET'])]
    public function index(VegetableRepository $vegetableRepository): Response
    {
        return $this->render('vegetable/index.html.twig', [
            'vegetables' => $vegetableRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'vegetable_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $vegetable = new Vegetable();
        $form = $this->createForm(VegetableType::class, $vegetable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($vegetable);
            $entityManager->flush();

            return $this->redirectToRoute('vegetable_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vegetable/new.html.twig', [
            'vegetable' => $vegetable,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'vegetable_show', methods: ['GET'])]
    public function show(Vegetable $vegetable): Response
    {
        return $this->render('vegetable/show.html.twig', [
            'vegetable' => $vegetable,
        ]);
    }

    #[Route('/{id}/edit', name: 'vegetable_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Vegetable $vegetable): Response
    {
        $form = $this->createForm(VegetableType::class, $vegetable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vegetable_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vegetable/edit.html.twig', [
            'vegetable' => $vegetable,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'vegetable_delete', methods: ['POST'])]
    public function delete(Request $request, Vegetable $vegetable): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vegetable->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($vegetable);
            $entityManager->flush();
        }

        return $this->redirectToRoute('vegetable_index', [], Response::HTTP_SEE_OTHER);
    }
}
