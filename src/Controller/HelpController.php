<?php

namespace App\Controller;

use App\Entity\Site;
use App\Entity\User;
use App\Repository\HistoriqueAffectationRepository;
use App\Repository\RapportRepository;
use App\Service\EtatStockService;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelpController extends AbstractController
{
    #[Route('/etat/stock', name: 'etat_stock', methods: ['GET', 'POST'])]
    public function index(Request $request, EtatStockService $etatServe): Response
    {
        $user=$this->getUser();
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
        ]
    );
    
    }
    #[Route('/affectation/historique', name: 'affectation_historique', methods: ['GET', 'POST'])]
    public function affectaions(Request $request,HistoriqueAffectationRepository $hitsoriRepo): Response
    {
        $historiques = $hitsoriRepo->findAll();
        //dd($historiques);
        return $this->render('acceuil/historique.html.twig',[
            'historiques'=>$historiques,
        ]
    );
    }
    #[Route('/test', name: 'test.rapport', methods: ['GET', 'POST'])]
    public function rapport(RapportRepository $rapportRepository): Response
    {
       dd($rapportRepository->find(26));
        return $this->render('acceuil/historique.html.twig',[
           
        ]
    );
    }
      
}
