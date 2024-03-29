<?php

namespace App\Controller;

use App\Entity\Departement;
use App\Entity\MailsDepartement;
use App\Form\DepartementType;
use App\Form\MailsDepartementType;
use App\Repository\DepartementRepository;
use App\Repository\MailsDepartementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/departement')]
class DepartementController extends AbstractController
{
    #[Route('/', name: 'app_departement_index', methods: ['GET'])]
    public function index(DepartementRepository $departementRepository): Response
    {
        return $this->render('departement/index.html.twig', [
            'departements' => $departementRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_departement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DepartementRepository $departementRepository): Response
    {
        $departement = new Departement();
        $form = $this->createForm(DepartementType::class, $departement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $departementRepository->add($departement, true);

            return $this->redirectToRoute('app_departement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('departement/new.html.twig', [
            'departement' => $departement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_departement_show', methods: ['GET', 'POST'])]
    public function show(Request $request, Departement $departement,MailsDepartementRepository $mailsDepartementRepository): Response
    {
        $mailsDepartement = new MailsDepartement();
        $mailsDepartement->setDepartement($departement);
        $form = $this->createForm(MailsDepartementType::class, $mailsDepartement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dd('aa');
            $mailsDepartementRepository->add($mailsDepartement, true);
            return $this->redirectToRoute('app_departement_show', ['id'=>$departement->getId()]);
        }

        return $this->renderForm('departement/membre.html.twig', [
            'departement' => $departement,
            'mails_departement' => $mailsDepartement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_departement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Departement $departement, DepartementRepository $departementRepository): Response
    {
        $form = $this->createForm(DepartementType::class, $departement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $departementRepository->add($departement, true);

            return $this->redirectToRoute('app_departement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('departement/edit.html.twig', [
            'departement' => $departement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_departement_delete', methods: ['POST'])]
    public function delete(Request $request, Departement $departement, DepartementRepository $departementRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$departement->getId(), $request->request->get('_token'))) {
            $departementRepository->remove($departement, true);
        }

        return $this->redirectToRoute('app_departement_index', [], Response::HTTP_SEE_OTHER);
    }
}
