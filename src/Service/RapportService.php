<?php
namespace App\Service;

use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Pdf;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class RapportService
{
    private $pdf;
    public function __construct(Pdf $pdf)
    {
      $this->pdf =$pdf;
    }
    public function genererPdf(String $html, String $nomFichier)
    {
     // dd($nomFichier);
     /* $this->pdf->generate($html,$nomFichier);
     dd("eto"); */
    dd($this->pdf->getOutput($html)); 
       return new PdfResponse(
              $this->pdf->getOutputFromHtml($html), 
              $nomFichier.'.pdf' 
          );
    }
    

}
?>