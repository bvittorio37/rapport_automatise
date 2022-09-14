<?php
namespace App\Service;

use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Pdf;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PdfService
{
    private $pdf;
    public function __construct(Pdf $pdf)
    {
      $this->pdf =$pdf;
    }
    public function genererPdf(String $html, String $nomFichier)
    {
      $this->pdf->getOutputFromHtml($html);
              
    }
    

}
?>