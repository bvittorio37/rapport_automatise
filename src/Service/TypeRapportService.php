<?php
namespace App\Service;

use App\Entity\TypeRapport;
use App\Repository\TypeRapportRepository;

class TypeRapportService
{
    private $typeRipo;
  
    public function __construct(TypeRapportRepository $typeRipo)
    {
       $this->typeRipo = $typeRipo;
    }

    public function getArriveType() : TypeRapport
    {
       return $this->typeRipo->findOneBy(['typeRapport' => 'Arrivé']);
    }

    public function getDepartType() : TypeRapport
    {
       return $this->typeRipo->findOneBy(['typeRapport' => 'Départ']);
    }

}

?>