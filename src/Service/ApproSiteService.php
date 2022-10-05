<?php
namespace App\Service;

use App\Entity\StockSite;

class ApproSiteService
{
   
  
    public function __construct()
    {
     
    }
    public function traitementApprovisionnement(StockSite $stockSite,array $data,bool $autre,int $type): StockSite
    {
        // Si le materiel à stocker n'est pas une étiquette
        if($autre){
            // Si c'est une entrée en stock
            if ($type==0){
                //sous-mettre l'entree à la valeur de la quatite
                $stockSite->setEntree($data["quantite"]->getViewData());
                //mettre à 0 la valeur consommé
                $stockSite->setConsommation(0);
               
            }
            // Si c'est une sortie en stock
            else{
                //sous-mettre la sortie à la valeur de la quatite
                //mettre à 0 la valeur entrée
            }
        }
        // Si le materiel à stocker est une étiquette
        else{
             // Si c'est une entrée en stock
             if ($type==0){
                //dd('eto');
                // annuler le site du stockSite
                $stockSite->setSite(null);
                // attribuer le paf de stockage
                $stockSite->setPaf($data["boxPaf"]->getNormData());
                // le numero debut du serie
                $stockSite->setDebutSerie(
                    $data["numeroBobine"]->getNormData()->getDebutSerie()
                );
                // le numero fin du bobine
                $stockSite->setFinSerie(
                    $data["numeroBobine"]->getNormData()->getFinSerie()
                );
            }
            // Si c'est une sortie en stock
            else{
               
            }
        }
        $stockSite->setDateStock(date_create(date("Y-m-d h:m:s")));
        return $stockSite;
    }

}

?>