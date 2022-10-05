<?php

namespace App\Entity;

use App\Repository\MaterielRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MaterielRepository::class)]
class Materiel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 30)]
    private $materiel;

    /* #[ORM\ManyToOne(targetEntity: Unite::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $unite; */

    #[ORM\ManyToOne(targetEntity: CategorieMateriel::class, inversedBy: 'materiels')]
    #[ORM\JoinColumn(nullable: false)]
    private $categorie;

    /* #[ORM\OneToMany(mappedBy: 'materiel', targetEntity: Emballage::class, cascade: ['persist'])]
    private $emballages; */

    #[ORM\OneToMany(mappedBy: 'materiel', targetEntity: UniteMateriel::class, cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private $uniteMateriels;

    public function __construct()
    {
        $this->emballages = new ArrayCollection();
        $this->uniteMateriels = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMateriel(): ?string
    {
        return $this->materiel;
    }

    public function setMateriel(string $materiel): self
    {
        $this->materiel = $materiel;

        return $this;
    }

   /*  public function getUnite(): ?Unite
    {
        return $this->unite;
    }

    public function setUnite(?Unite $unite): self
    {
        $this->unite = $unite;

        return $this;
    } */

    public function getCategorie(): ?CategorieMateriel
    {
        return $this->categorie;
    }

    public function setCategorie(?CategorieMateriel $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }
    public function __toString()
    {
        return $this->materiel;
    }

    /*
      @return Collection<int, Emballage>
     */
   /*  public function getEmballages(): Collection
    {
        return $this->emballages;
    }

    public function addEmballage(Emballage $emballage): self
    {
        if (!$this->emballages->contains($emballage)) {
            $emballage->setMateriel($this);
            $this->emballages->add( $emballage);
        }
        
        return $this;
    }

    public function removeEmballage(Emballage $emballage): self
    {
        if ($this->emballages->removeElement($emballage)) {
            // set the owning side to null (unless already changed)
            if ($emballage->getMateriel() === $this) {
                $emballage->setMateriel(null);
            }
        }
        return $this;
    } */

    /**
     * @return Collection<int, UniteMateriel>
     */
    public function getUniteMateriels(): Collection
    {
        return $this->uniteMateriels;
    }

    public function addUniteMateriel(UniteMateriel $uniteMateriel): self
    {
        if (!$this->uniteMateriels->contains($uniteMateriel)) {
            $uniteMateriel->setMateriel($this);
            $this->uniteMateriels->add( $uniteMateriel);
        }

        return $this;
    }

    public function removeUniteMateriel(UniteMateriel $uniteMateriel): self
    {
        if ($this->uniteMateriels->removeElement($uniteMateriel)) {
            // set the owning side to null (unless already changed)
            if ($uniteMateriel->getMateriel() === $this) {
                $uniteMateriel->setMateriel(null);
            }
        }

        return $this;
    }
}
