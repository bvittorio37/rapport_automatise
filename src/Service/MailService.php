<?php
namespace App\Service;

use App\Entity\Departement;
use App\Entity\MailsDepartement;
use App\Entity\Rapport;
use App\Repository\MailsDepartementRepository;
use Symfony\Component\Mime\Address;

class MailService
{
    private $mailsDepRepos;
    public function __construct(MailsDepartementRepository $mailsDepRepos)
    {
        $this->mailsDepRepos= $mailsDepRepos;
    }
    public function  getMailsTo(Departement $departement){
       // $mails = $departement->getMailsDepartements();
        
        $mailsDeps = $this->mailsDepRepos->findBy(['Departement'=>$departement]);
        foreach ($mailsDeps as $key ) {
           $email[] = new Address($key->getEmail());
        }
        return $email;
    }

    public function getMailsCc(String $cc=null, Departement $departement){
        if($cc){
            $mailsCc = explode(",",$cc);
            foreach ($mailsCc as $key ) {
                $email[] = new Address($key);
            }    
        }
        $mailsDeps = $this->mailsDepRepos->findBy(['Departement'=>$departement]);
        foreach ($mailsDeps as $key ) {
           $email[] = new Address($key->getEmail());
        }
        return $email;
       
  
    }

}
?>