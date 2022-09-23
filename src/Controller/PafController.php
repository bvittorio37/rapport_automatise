<?php

namespace App\Controller;

use App\Entity\Paf;
use App\Form\PafType;
use App\Repository\PafRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/paf')]
class PafController extends AbstractController
{
    #[Route('/', name: 'app_paf_index', methods: ['GET'])]
    public function index(PafRepository $pafRepository): Response
    {
        return $this->render('paf/index.html.twig', [
            'pafs' => $pafRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_paf_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PafRepository $pafRepository): Response
    {
        $paf = new Paf();
        $form = $this->createForm(PafType::class, $paf);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pafRepository->add($paf, true);

            return $this->redirectToRoute('app_paf_new', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('paf/new.html.twig', [
            'paf' => $paf,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_paf_show', methods: ['GET'])]
    public function show(Paf $paf): Response
    {
        return $this->render('paf/show.html.twig', [
            'paf' => $paf,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_paf_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Paf $paf, PafRepository $pafRepository): Response
    {
        $form = $this->createForm(PafType::class, $paf);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pafRepository->add($paf, true);

            return $this->redirectToRoute('app_paf_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('paf/edit.html.twig', [
            'paf' => $paf,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_paf_delete', methods: ['POST'])]
    public function delete(Request $request, Paf $paf, PafRepository $pafRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$paf->getId(), $request->request->get('_token'))) {
            $pafRepository->remove($paf, true);
        }

        return $this->redirectToRoute('app_paf_index', [], Response::HTTP_SEE_OTHER);
    }
}
