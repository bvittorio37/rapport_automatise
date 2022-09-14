<?php

namespace App\Controller;

use App\Entity\Rapport;
use App\Service\RapportService;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class TestController extends AbstractController
{
    #[Route('/testpdf', name: 'pdf.acceuil')]
    public function index(RapportService $rapServe): Response
    {
        $html=$this->generateUrl('app_depart_index',[],UrlGeneratorInterface::ABSOLUTE_URL);
        $nom="yaya.pdf";
        $rapServe->genererPdf($html,$nom)->send();
        return $this->render('acceuil/template.html.twig');
    }
}
