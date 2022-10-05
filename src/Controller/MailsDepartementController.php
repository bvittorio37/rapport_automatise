<?php

namespace App\Controller;

use App\Entity\MailsDepartement;
use App\Form\MailsDepartementType;
use App\Repository\MailsDepartementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/mails/departement')]
class MailsDepartementController extends AbstractController
{
    #[Route('/', name: 'app_mails_departement_index', methods: ['GET'])]
    public function index(MailsDepartementRepository $mailsDepartementRepository): Response
    {
        return $this->render('mails_departement/index.html.twig', [
            'mails_departements' => $mailsDepartementRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_mails_departement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MailsDepartementRepository $mailsDepartementRepository): Response
    {
        $mailsDepartement = new MailsDepartement();
        $form = $this->createForm(MailsDepartementType::class, $mailsDepartement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mailsDepartementRepository->add($mailsDepartement, true);

            return $this->redirectToRoute('app_mails_departement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('mails_departement/new.html.twig', [
            'mails_departement' => $mailsDepartement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_mails_departement_show', methods: ['GET'])]
    public function show(MailsDepartement $mailsDepartement): Response
    {
        return $this->render('mails_departement/show.html.twig', [
            'mails_departement' => $mailsDepartement,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_mails_departement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MailsDepartement $mailsDepartement, MailsDepartementRepository $mailsDepartementRepository): Response
    {
        $form = $this->createForm(MailsDepartementType::class, $mailsDepartement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mailsDepartementRepository->add($mailsDepartement, true);

            return $this->redirectToRoute('app_mails_departement_index', [], Response::HTTP_SEE_OTHER);
        }
 
        return $this->renderForm('mails_departement/edit.html.twig', [
            'mails_departement' => $mailsDepartement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_mails_departement_delete', methods: ['POST'])]
    public function delete(Request $request, MailsDepartement $mailsDepartement, MailsDepartementRepository $mailsDepartementRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mailsDepartement->getId(), $request->request->get('_token'))) {
            $mailsDepartementRepository->remove($mailsDepartement, true);
        }

        return $this->redirectToRoute('app_mails_departement_index', [], Response::HTTP_SEE_OTHER);
    }
}
