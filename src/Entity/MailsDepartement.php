<?php

namespace App\Entity;

use App\Repository\MailsDepartementRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MailsDepartementRepository::class)]
class MailsDepartement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Departement::class, inversedBy: 'mailsDepartements')]
    private $Departement;

    #[ORM\Column(type: 'string', length: 150, nullable: true)]
    private $nomEmp;

    #[Assert\Email( message:'Inserer un email valide') ]
    #[ORM\Column(type: 'string', length: 50)]
    private $email;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDepartement(): ?Departement
    {
        return $this->Departement;
    }

    public function setDepartement(?Departement $Departement): self
    {
        $this->Departement = $Departement;

        return $this;
    }

    public function getNomEmp(): ?string
    {
        return $this->nomEmp;
    }

    public function setNomEmp(?string $nomEmp): self
    {
        $this->nomEmp = $nomEmp;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
}
