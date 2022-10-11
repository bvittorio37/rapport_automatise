<?php

namespace App\Controller;

use App\Entity\Rapport;
use App\Form\Rapport1Type;
use App\Form\RapportStockType;
use App\Form\RapportType;
use App\Repository\RapportRepository;
use App\Service\RapportService;
use App\Service\TypeRapportService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[Route('/arrive')]
class ArriveController extends AbstractController
{
    #[Route('/', name: 'arrive_index', methods: ['GET'])]
    public function index(RapportRepository $rapportRepository,TypeRapportService $typeService): Response
    {
        return $this->render('arrive/index.html.twig', [
            'rapports' => $rapportRepository->findBy(['utilisateur' => $this->getUser(),'typeRapport'=>$typeService->getArriveType()]),
        ]);
    }

    #[Route('/nouveau', name: 'app_arrive_nouveau', methods: ['GET', 'POST'])]
    public function new(Request $request, RapportRepository $rapportRepository, TypeRapportService $typeService,RapportService $rapportServe): Response
    {

        $rapport = new Rapport();
        /// Ajoute les visas spécifiques au rapport de vol arrivé
        $rapportServe->AjouterLesVisas($rapport,'A');


        $form = $this->createForm(RapportType::class, $rapport);
        $form->handleRequest($request);
        //dd($typeService->getDepartType());

        if ($form->isSubmitted() && $form->isValid() && $this->getUser()) {
            dd($rapport);
            $rapport->setUtilisateur($this->getUser());
            $rapport->setTypeRapport($typeService->getArriveType());
            
            $nompdf=("rapport-de-vol-arrive-".date("Y-m-d"));
            $rapport->setNomPdf($nompdf);
            $rapportRepository->add($rapport, true);
            return $this->redirectToRoute('app_arrive_stock', 
                ['id'=>$rapport->getId()],
                 Response::HTTP_SEE_OTHER
            );
        }
        //dd($form);
        return $this->renderForm('arrive/new.html.twig', [
            'rapport' => $rapport,
            'form' => $form,
        ]);
    }

    #[Route('/stock/{id}', name: 'app_arrive_stock', methods: ['GET', 'POST'])]
    public function stock(Request $request,Rapport $rapport, RapportRepository $rapportRepository, TypeRapportService $typeService,RapportService $rapportServe): Response
    {

        //dd($rapport);
        $rapportServe->ajouterDesStocks($rapport);
    
        $form = $this->createForm(RapportStockType::class, $rapport);
        $form->handleRequest($request);
        //dd($typeService->getDepartType());

        if ($form->isSubmitted() && $form->isValid() && $this->getUser()) {
            $rapportRepository->add($rapport, true);
            dd('eto');
            return $this->redirectToRoute('app_mail_new', ['id'=>$rapport->getId(),'nompdf'=>$rapport->getNomPdf()], Response::HTTP_SEE_OTHER);
        }
        //dd($form);
        return $this->renderForm('arrive/edit.html.twig', [
            'rapport' => $rapport,
            'form' => $form,
        ]);
    }




}
