<?php

namespace App\Controller;

use App\Entity\Rapport;
use App\Form\Rapport1Type;
use App\Repository\RapportRepository;
use App\Service\TypeRapportService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/depart')]
class DepartController extends AbstractController
{
    #[Route('/', name: 'app_depart_index', methods: ['GET'])]
    public function index(RapportRepository $rapportRepository): Response
    {
        return $this->render('depart/index.html.twig', [
            'rapports' => $rapportRepository->findAll(),
        ]);
    }

    #[Route('/nouveau', name: 'app_depart_nouveau', methods: ['GET', 'POST'])]
    public function new(Request $request, RapportRepository $rapportRepository, TypeRapportService $typeService): Response
    {
        $rapport = new Rapport();
        $form = $this->createForm(Rapport1Type::class, $rapport);
        $form->handleRequest($request);
        //dd($typeService->getDepartType());

        if ($form->isSubmitted() && $form->isValid()) {
            $rapport->setUtilisateur($this->getUser());
            $rapport->setTypeRapport($typeService->getDepartType());
            $rapport->setDateRapport(date_create(date("H:i:s")));
            $rapportRepository->add($rapport, true);
            return $this->redirectToRoute('app_depart_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('depart/new.html.twig', [
            'rapport' => $rapport,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_depart_show', methods: ['GET'])]
    public function show(Rapport $rapport): Response
    {
        return $this->render('depart/show.html.twig', [
            'rapport' => $rapport,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_depart_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Rapport $rapport, RapportRepository $rapportRepository): Response
    {
        $form = $this->createForm(Rapport1Type::class, $rapport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $rapportRepository->add($rapport, true);

            return $this->redirectToRoute('app_depart_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('depart/edit.html.twig', [
            'rapport' => $rapport,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_depart_delete', methods: ['POST'])]
    public function delete(Request $request, Rapport $rapport, RapportRepository $rapportRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rapport->getId(), $request->request->get('_token'))) {
            $rapportRepository->remove($rapport, true);
        }

        return $this->redirectToRoute('app_depart_index', [], Response::HTTP_SEE_OTHER);
    }
}
