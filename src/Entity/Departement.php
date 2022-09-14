<?php

namespace App\Entity;

use App\Repository\DepartementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DepartementRepository::class)]
class Departement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 150)]
    private $nomDepart;

    #[ORM\Column(type: 'string', length: 150, nullable: true)]
    private $remarque;

    #[ORM\OneToMany(mappedBy: 'Departement', targetEntity: MailsDepartement::class)]
    private $mailsDepartements;

    public function __construct()
    {
        $this->mailsDepartements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomDepart(): ?string
    {
        return $this->nomDepart;
    }

    public function setNomDepart(string $nomDepart): self
    {
        $this->nomDepart = $nomDepart;

        return $this;
    }

    public function getRemarque(): ?string
    {
        return $this->remarque;
    }

    public function setRemarque(?string $remarque): self
    {
        $this->remarque = $remarque;

        return $this;
    }

    /**
     * @return Collection<int, MailsDepartement>
     */
    public function getMailsDepartements(): Collection
    {
        return $this->mailsDepartements;
    }

    public function addMailsDepartement(MailsDepartement $mailsDepartement): self
    {
        if (!$this->mailsDepartements->contains($mailsDepartement)) {
            $this->mailsDepartements[] = $mailsDepartement;
            $mailsDepartement->setDepartement($this);
        }

        return $this;
    }

    public function removeMailsDepartement(MailsDepartement $mailsDepartement): self
    {
        if ($this->mailsDepartements->removeElement($mailsDepartement)) {
            // set the owning side to null (unless already changed)
            if ($mailsDepartement->getDepartement() === $this) {
                $mailsDepartement->setDepartement(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return "DEPARTEMENT ".$this->nomDepart;
    }
}
