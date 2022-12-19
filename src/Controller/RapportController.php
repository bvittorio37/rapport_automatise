<?php

namespace App\Controller;

use App\Entity\Rapport;
use App\Form\RapportType;
use App\Form\RecherheRapportType;
use App\Repository\RapportRepository;
use App\Repository\TypeRapportRepository;
use App\Repository\UserRepository;
use App\Repository\VisaParRapportRepository;
use App\Service\EtatStockService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/rapport')]
class RapportController extends AbstractController
{
    
    #[Route('/', name: 'rapport_index', methods: ['GET', 'POST'])]
    public function index(Request $request, RapportRepository $rapportRepository): Response
    {   $rapport = new Rapport();
        $rapports = $rapportRepository->findAll();
        $form = $this->createForm(RecherheRapportType::class,$rapport);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $rapportRepository->add($rapport, true);
            return $this->redirectToRoute('app_rapport_index', [], Response::HTTP_SEE_OTHER);
        }
        /* $user=$this->getUser();
        $etatStock= null;
        if( $user instanceof User){
            if(!$user->getSite()) {
                throw new AccessDeniedException("Vous n'êtes pas encore attribué dans un site !! ");
              }
              $site =  $user->getSite();
        }
        $form = $this->createFormBuilder(null,[
            'attr' => [ 'class' => 'input-group input-group-sm',],
        ])
                    ->add('site', EntityType::class, [
                        'required'=>false, 'class' => Site::class,
                        'placeholder' => 'Sélectionnez un site',
                        'attr' => [ 'class' => 'form-control float-right',],
                        'label' => false,
                    ])
                    ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if($form->get('site')->getData()){
            $site = $form->get('site')->getData();
            }
        }
        
        $etatStock= $etatServe->getEtatStockParSite($site->getId());
       //dd($etatStock);
        return $this->render('acceuil/template.html.twig',[
            'etatStock'=>$etatStock,
            'lieu'=> $site->getLieu(),
            'form'=>$form->createView(),
        ]  );*/
        return $this->render('rapport/index.html.twig', [
            'rapports' => $rapports,
            'rapport'=> $rapport,
            'form'=>$form,
        ]);
   
    
    }

    #[Route('/liste', name: 'app_rapport_liste', methods: ['GET', 'POST'])]
    public function liste(Request $request, RapportRepository $rapportRepository): Response
    {
        $rapport = new Rapport();
        $rapports = $rapportRepository->findAll();
        $form = $this->createForm(RecherheRapportType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $typeRapport=$form->get('typeRapport')->getData();
            $site=$form->get('site')->getData();
            $dateDebut=$form->get('dateDebut')->getData();
            $dateFin=$form->get('dateFin')->getData();
            $rapports = $rapportRepository->rechercher($site,$typeRapport,$dateDebut,$dateFin);
        }
         
        return $this->renderForm('rapport/index.html.twig', [
            'rapport' => $rapport,
            'form' => $form,
            'rapports' => $rapports,  
        ]);
    }
    
    #[Route('/{id}', name: 'app_rapport_show', methods: ['GET'])]
    public function montrer( Rapport $rapport): Response
    {
       // dd($rapportRepository->find($request->get('id')));
        return $this->render('rapport/show.html.twig', [
            'rapport' => $rapport,
        ]);
    }

    #[Route('/etat/consommable/{id}', name: 'app_etat_consommable', methods: ['GET'])]
    public function etatconsommable( Rapport $rapport, EtatStockService $etatService): Response
    {
        
        return $this->render('rapport/etats.html.twig', [
            'rapport' => $rapport,
            'etats'=>$etatService->getEtatConsommbale($rapport->getId()),
        ]);
    }
    
    #[Route('/{id}/annuler', name: 'app_rapport_annuler', methods: ['GET'])]
    public function annule(Rapport $rapport,RapportRepository $rapportRepository): Response
    {
        if(!$rapport->isAnnule()){
            $rapport->setAnnule(false);
        }
       
        $rapportRepository->add($rapport,true);
        return $this->render('rapport/show.html.twig', [
            'rapport' => $rapport,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_rapport_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Rapport $rapport, RapportRepository $rapportRepository): Response
    {
        $form = $this->createForm(RapportType::class, $rapport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $rapportRepository->add($rapport, true);
            return $this->redirectToRoute('app_rapport_index', [], Response::HTTP_SEE_OTHER);
        }
        
        return $this->renderForm('rapport/edit.html.twig', [
            'rapport' => $rapport,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_rapport_delete', methods: ['POST'])]
    public function delete(Request $request, Rapport $rapport, RapportRepository $rapportRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rapport->getId(), $request->request->get('_token'))) {
            $rapportRepository->remove($rapport, true);
        }
        return $this->redirectToRoute('app_rapport_index', [], Response::HTTP_SEE_OTHER);
    }
}
