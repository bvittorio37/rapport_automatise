<?php
namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;

class UtilisateurService
{
    private $utiRepo;
    public function __construct(UserRepository $utiRepo)
    {
        $this->utiRepo= $utiRepo;
    }

    public function activation(User $user) :bool
    {
        $retour = true;
        if($user->isEtat()){
            $retour= false;
        }
        $user->setEtat($retour);
        $this->utiRepo->add($user, true);
        return $retour;
    }
    public function utilisateurChecker(String $no_mat){
        dd($this->utiRepo->isActif($no_mat));
    }

}

?>