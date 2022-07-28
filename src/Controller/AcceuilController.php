<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AcceuilController extends AbstractController
{
    #[Route('/acceuil', name: 'acceuil')]
    public function index(): Response
    {
       // dd( hash('sha256', 1234));
       return $this->render('acceuil/template.html.twig');
    }

    
    /*
    #[Route(path: '/test', name: 'test')]
    public function test(): Response
    {
        return $this->render('acceuil/template.html.twig');
    }*/
}
