<?php

namespace App\Controller;

use App\Repository\RapportRepository;
use App\Service\PdfService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AcceuilController extends AbstractController
{
    #[Route('/acceuil', name: 'acceuil')]
    public function index(Request $request, RapportRepository $rapRepos,PdfService $pdfServe): Response
    {
        if($this->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('app_utilisateur');
        }
        elseif($this->isGranted('ROLE_MAGASINIER')){
            return $this->redirectToRoute('app_stock_historique');  
        }
        else{
            return $this->redirectToRoute('etat_stock');  
        }
       return $this->render('acceuil/template.html.twig');
    }

    
    /*
    #[Route(path: '/test', name: 'test')]
    public function test(): Response
    {
        return $this->render('acceuil/template.html.twig');
    }*/
}
