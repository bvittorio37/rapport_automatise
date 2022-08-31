<?php

namespace App\Controller;

use App\Entity\TypeRapport;
use App\Form\TypeRapportType;
use App\Repository\TypeRapportRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/type/rapport')]
class TypeRapportController extends AbstractController
{
    #[Route('/', name: 'app_type_rapport_index', methods: ['GET'])]
    public function index(TypeRapportRepository $typeRapportRepository): Response
    {
        return $this->render('type_rapport/index.html.twig', [
            'type_rapports' => $typeRapportRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_type_rapport_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TypeRapportRepository $typeRapportRepository): Response
    {
        $typeRapport = new TypeRapport();
        $form = $this->createForm(TypeRapportType::class, $typeRapport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeRapportRepository->add($typeRapport, true);

            return $this->redirectToRoute('app_type_rapport_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_rapport/new.html.twig', [
            'type_rapport' => $typeRapport,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_type_rapport_show', methods: ['GET'])]
    public function show(TypeRapport $typeRapport): Response
    {
        return $this->render('type_rapport/show.html.twig', [
            'type_rapport' => $typeRapport,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_type_rapport_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeRapport $typeRapport, TypeRapportRepository $typeRapportRepository): Response
    {
        $form = $this->createForm(TypeRapportType::class, $typeRapport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeRapportRepository->add($typeRapport, true);

            return $this->redirectToRoute('app_type_rapport_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_rapport/edit.html.twig', [
            'type_rapport' => $typeRapport,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_type_rapport_delete', methods: ['POST'])]
    public function delete(Request $request, TypeRapport $typeRapport, TypeRapportRepository $typeRapportRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeRapport->getId(), $request->request->get('_token'))) {
            $typeRapportRepository->remove($typeRapport, true);
        }

        return $this->redirectToRoute('app_type_rapport_index', [], Response::HTTP_SEE_OTHER);
    }
}
