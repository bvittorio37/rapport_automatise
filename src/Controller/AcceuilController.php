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
        /* $idRapport = 2;
        $rapport=$rapRepos->find($idRapport);
        $html= '<link href="'.$request->server->get('SYMFONY_DEFAULT_ROUTE_URL').'assets/dist/css/bootstrap.min.css" rel="stylesheet" />'.$this->render('depart/show.html.twig', ['rapport' => $rapport]);
        $pdfServe->showPdf($html); */
       return $this->render('acceuil/template.html.twig');
    }

    
    /*
    #[Route(path: '/test', name: 'test')]
    public function test(): Response
    {
        return $this->render('acceuil/template.html.twig');
    }*/
}
