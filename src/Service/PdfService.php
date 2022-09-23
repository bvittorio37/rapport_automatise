<?php
namespace App\Service;

use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Pdf;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Dompdf\Dompdf;
use Dompdf\Options;

class PdfService
{
    private $pdf;
    public function __construct()
    {
      $this->pdf= new Dompdf();
      $pdfOptions= new Options();
      $pdfOptions->set('defaultFont','Garamound');
      $this->pdf->setOptions($pdfOptions);
    }
    public function showPdf(String $html)
    {
      $this->pdf->loadHtml($html);
      $this->pdf->setPaper('A4', 'portrait');
      $this->pdf->render();
      $this->pdf->stream("mypdf.pdf", [
        "Attachment" => false
    ]);     
    }
    public function genererPdf(String $html)
    {
      $this->pdf->loadHtml($html);
      $this->pdf->render();
      return $this->pdf->output();        
    }
    

}
?>