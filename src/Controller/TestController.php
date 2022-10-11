<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\EtatStockService;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/etat/stock', name: 'etat_stock')]
    public function index(Request $request, EtatStockService $etatServe): Response
    {
        $user=$this->getUser();
        $etatStock= null;
        if( $user instanceof User){
            if(!$user->getSite()) {
                throw new AccessDeniedException("Vous n'êtes pas encore attribué dans un site !! ");
              }
            $etatStock= $etatServe->getEtatStockParSite(
                $user->getSite()->getId()
            );
        
        }
       
        return $this->render('acceuil/template.html.twig',[
            'etatStock'=>$etatStock,
        ]
    
    );
    }
}
