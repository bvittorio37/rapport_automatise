<?php

namespace App\Entity;

use App\Repository\UniteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UniteRepository::class)]
class Unite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 10)]
    private $unite;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private $remarque;

    #[ORM\OneToMany(mappedBy: 'unite', targetEntity: UniteMateriel::class)]
    private $uniteMateriels;

    public function __construct()
    {
        $this->uniteMateriels = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUnite(): ?string
    {
        return $this->unite;
    }

    public function setUnite(string $unite): self
    {
        $this->unite = $unite;

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
    public function __toString()
    {
        return $this->unite;
    }

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
            $this->uniteMateriels[] = $uniteMateriel;
            $uniteMateriel->setUnite($this);
        }

        return $this;
    }

    public function removeUniteMateriel(UniteMateriel $uniteMateriel): self
    {
        if ($this->uniteMateriels->removeElement($uniteMateriel)) {
            // set the owning side to null (unless already changed)
            if ($uniteMateriel->getUnite() === $this) {
                $uniteMateriel->setUnite(null);
            }
        }

        return $this;
    }
}
