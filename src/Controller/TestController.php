<?php

namespace App\Controller;

use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/testpdf', name: 'acceuil')]
    public function index(Pdf $pdf): Response
    {
        $html=$this->generateUrl('app_depart_show',['id'=>2],true);
        $pageUrl=$pdf->getOutputFromHtml($html);
        return new PdfResponse(
            $pdf->getOutput($pageUrl),
            'file.pdf'
        );
    }

   
}
