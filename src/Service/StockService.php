<?php
namespace App\Service;

use App\Controller\MaterielController;
use App\Entity\Stock;
use App\Entity\TypeStock;
use App\Entity\Unite;
use App\Repository\MaterielRepository;
use App\Repository\TypeRapportRepository;
use App\Repository\TypeStockRepository;

class StockService
{
    private $typeRipo;
    private $matRepo;
    private $typage;
  
    public function __construct(TypeStockRepository $typeRipo,MaterielRepository $matRepo,TypageService $typage)
    {
       $this->typeRipo = $typeRipo;
       $this->matRepo=$matRepo;
       $this->typage=$typage;
    }
    /*
     * Traiter le stock par rapport au matière
     * Car le stockage d'etiquette est différent
     * aux autre types
     */

    public function traiterStock(Stock $stock=null,array $data, bool $autre, int $typeStock): array
   {
         $listesStock = array(); 
        //dd($data);
        
        // si le materiel n'est pas un étiquette
        if($autre){
            //traitement général
            /// si le type de stock est une entree en etant 0
            // mettre sur 0 la la valeur du sortie
            if($typeStock==0){
                
                //dd($this->matRepo->findQuantiteParCarton(38) );
                $unite=$data["unite"]->getNormData();
                $quantite=$data["quantite"]->getViewData();
                if($unite instanceof Unite){
                    if($unite->getUnite()=="Carton"){
                        $quantite= $quantite*$this->matRepo->
                            findQuantiteParCarton($stock->getMateriel()
                                                ->getId());
                    }
                   
                   // dd($stock);
                }
                //Inspeter si c'est un carton ou unite
                //Si carton

                    // augmenter la va
                    // Si c'est unite

                //$stock->setTypeStock($typage->get);
                $stock->setEntree($quantite);
                $stock->setSortie(0);
                $listesStock[]=$stock;
            }
            // sinon
            // mettre sur 0 la la valeur de l'entree
            else{
                $stock->setEntree(0);
                $stock->setSortie($data["quantite"]->getViewData());
                $stock->setDateStock(date_create(date("Y-m-d h:m:s")));
                $listesStock[]=$stock;
             
            }
            
        }
        //si oui
        else{
        //traitement étiquette
        
        /// si le type de stock est une entree en etant 0
            // mettre sur 0 la la valeur du sortie
            //dd($stock);
            if($typeStock==0){
                $debut=$data["debutSerie"]->getViewData();
                $fin=$data['finSerie']->getViewData();
                $nombreBobine= ($fin-$debut+1)/500;
                    $debutSerie=$debut;
                    
                    for ($i=0; $i < $nombreBobine; $i++) { 
                        $stockNouveau= new Stock();
                        $finSerie=$debutSerie+499;
                        $stockNouveau->setDebutSerie($debutSerie);
                        $stockNouveau->setFinSerie( $finSerie);
                        $stockNouveau->setReference($data["reference"]->getViewData());
                        $stockNouveau->setDispo(true);
                        $stockNouveau->setMateriel($stock->getMateriel());
                        $listesStock[]=$stockNouveau;
                        $debutSerie= $finSerie+1;
                    }
                //$fin=$data["finSerie"]->getViewData();
                //$ref=$data["reference"]->getViewData();
   
                //$stock->setNumBobine($data["numBobine"]->getViewData());
                
                //dd($stock);
                //dd($fin);
            }
            // sinon
            // mettre sur 0 la la valeur de l'entree
            else{
               $stockE= $data["numeroBobine"]->getNormData();
               if($stockE instanceof Stock){
                $stockE->setDateIndispo(date_create(date("Y-m-d h:m:s")));
                $stockE->setDispo(false);
                $listesStock[]=$stockE;
               }
            }

        }
    return $listesStock;
   }

   public function arrondir($nombre)
    {
        $entier = (int) $nombre;
            if($entier<$nombre){

                return $entier+1;
            }
            return $entier;
    }

    public function getTypeStock(int $type): TypeStock
    {
        if($type==0){ $libelle = "Entrée"; }

        else{  $libelle="Sortie";  }
        
        $retour= $this->typeRipo->findOneBy(['typeStock'=>$libelle]);
        if(!$retour){
                $retour= new TypeStock();
                $retour->setTypeStock($libelle);
                $this->typeRipo->add($retour,true);
        }
        return $retour;
    }

}

 
?>