<?php
namespace App\Service;

use App\Controller\CategorieMaterielController;
use App\Entity\Rapport;
use App\Entity\StockSite;
use App\Entity\VisaParRapport;
use App\Repository\CategorieMaterielRepository;
use App\Repository\MaterielRepository;
use App\Repository\PafRepository;
use App\Repository\VisaRepository;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Pdf;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class RapportService
{
    private $pdf;
    private $visaRepo;
    private $matRepo;
    private $catRepo;
    private $pafRepo;
    public function __construct(Pdf $pdf,VisaRepository $visaRepo,
      MaterielRepository $matRepo,CategorieMaterielRepository $catRepo
      ,PafRepository $pafRepo
    )
    {
      $this->matRepo=$matRepo;
      $this->pdf =$pdf;
      $this->visaRepo=$visaRepo;
      $this->catRepo = $catRepo;
      $this->pafRepo= $pafRepo;
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
    public function AjouterLesVisas(Rapport $rapport, string $type){
          $listeVisa=$this->visaRepo->findBy(['type'=>$type]);
          foreach ($listeVisa as  $visa) {
            $visaRapport = new VisaParRapport();
            $visaRapport->setVisa($visa);
            $visaRapport->setNombre(0);
            $rapport->addVisaParRapport($visaRapport);
          }
    }


    public function ajouterDesStocks(Rapport $rapport){
      // Prendre tous les materiels de categorie Site
        $cat = $this->catRepo->findOneBy(['categorie'=>'Matériel site']);
        $listeMateriels = $this->matRepo->findBy(['categorie'=>$cat]);
      foreach ($listeMateriels as $materiel ) {

        if($materiel->getMateriel()=='Etiquette'){
          // Prendre tous les pafs dans le Site Choisi
            $pafs= $this->pafRepo->findBy(['site'=>$rapport->getSite()]);
          // Iterer les pafs et inser chaque paf dans un nouvel stock
            foreach ($pafs as $paf) {
                $stockSite = new StockSite();
                $stockSite->setmateriel($materiel);
                $stockSite->setPaf($paf);
                $stockSite->setSite($rapport->getSite());
                $stockSite->setDateStock(date_create(date("Y-m-d h:m:s")));
                $rapport->addStockSite($stockSite);
                
            } 
        }
        else{
          $stockSite = new StockSite();
          $stockSite->setmateriel($materiel);
          $stockSite->setSite($rapport->getSite());
          $stockSite->setDateStock(date_create(date("Y-m-d h:m:s")));
          $rapport->addStockSite($stockSite);
          
        }
        
      }
    }
    
   /*  $rapportRepository->findBy(['utilisateur' => $this->getUser(),'typeRapport'=>$typeService->getDepartType()]) */
}
?>