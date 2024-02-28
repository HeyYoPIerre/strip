<?php

namespace App\Controller;

use App\Entity\Strip;
use App\Form\StripType;
use App\Repository\StripRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/strips')]
class StripsController extends AbstractController
{
    #[Route('/', name: 'app_strips_index', methods: ['GET'])]
    public function index(StripRepository $stripRepository): Response
    {
        return $this->render('strips/index.html.twig', [
            'strips' => $stripRepository->findAll(),
        ]);
    }

    #[Route('/admin/new', name: 'app_strips_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $strip = new Strip();
        $form = $this->createForm(StripType::class, $strip);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($strip);
            $entityManager->flush();

            return $this->redirectToRoute('app_strips_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('strips/new.html.twig', [
            'strip' => $strip,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_strips_show', methods: ['GET'])]
    public function show(Strip $strip): Response
    {
        return $this->render('strips/show.html.twig', [
            'strip' => $strip,
        ]);
    }

    #[Route('/admin/{id}/edit', name: 'app_strips_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Strip $strip, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(StripType::class, $strip);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_strips_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('strips/edit.html.twig', [
            'strip' => $strip,
            'form' => $form,
        ]);
    }

    #[Route('/admin/{id}', name: 'app_strips_delete', methods: ['POST'])]
    public function delete(Request $request, Strip $strip, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$strip->getId(), $request->request->get('_token'))) {
            $entityManager->remove($strip);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_strips_index', [], Response::HTTP_SEE_OTHER);
    }
}

