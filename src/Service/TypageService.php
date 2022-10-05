<?php
namespace App\Service;

use App\Entity\TypeRapport;
use App\Entity\TypeStock;
use App\Entity\TypeUnite;
use App\Entity\Unite;
use App\Form\StockType;
use App\Repository\TypeRapportRepository;
use App\Repository\TypeStockRepository;
use App\Repository\TypeUniteRepository;
use App\Repository\UniteRepository;

class TypageService
{
    private $typeRipo;
    private $typeStockRepo;
    private $typeUniteRepo;
    private $uniteRepo;
  
    public function __construct(TypeRapportRepository $typeRipo,TypeUniteRepository $typeUniteRepo, UniteRepository $uniteRepo,TypeStockRepository $typeStock)
    {
       $this->typeRipo = $typeRipo;
       $this->typeUniteRepo = $typeUniteRepo;
       $this->uniteRepo= $uniteRepo;
       $this->typeStockRepo= $typeStock;

    }

    public function getArriveType() : TypeRapport
    {
       return $this->typeRipo->findOneBy(['typeRapport' => 'Arrivé']);
    }

    public function getDepartType() : TypeRapport
    {
       return $this->typeRipo->findOneBy(['typeRapport' => 'Départ']);
    }


    public function getEmballageType(): TypeUnite
    {
            return $this->typeUniteRepo->findOneBy(['type'=>'Emballage']);
     
    }
    public function getUnitePrimaireType(): TypeUnite
    {
            return $this->typeUniteRepo->findOneBy(['type'=>'Unite primaire']);
     
    }
    public function getUniteSecondaireType(): TypeUnite
    {
            return $this->typeUniteRepo->findOneBy(['type'=>'Unite secondaire']);
     
    }
    public function getUniteCarton(): Unite
    {
            $nomCarton='Carton';  
           $retour= $this->uniteRepo->findOneBy(['unite'=>$nomCarton]);
           if(!$retour){
            $retour= new Unite();
            $retour->setUnite($nomCarton);
            $this->uniteRepo->add($retour,true);
           }
           return $retour;
     
    }

    /*
     * 
     * Avoir le type de stock (0 sy Entrée et 1 sy Sortie) 
     * return TypeStock
     */
   
}


?>