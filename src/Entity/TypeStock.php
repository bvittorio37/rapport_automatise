<?php

namespace App\Entity;

use App\Repository\TypeStockRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeStockRepository::class)]
class TypeStock
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 7)]
    private $typeStock;

    #[ORM\OneToMany(mappedBy: 'typeStock', targetEntity: StockSite::class)]
    private $stockSites;

    public function __construct()
    {
        $this->stockSites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeStock(): ?string
    {
        return $this->typeStock;
    }

    public function setTypeStock(string $typeStock): self
    {
        $this->typeStock = $typeStock;

        return $this;
    }
    public function __toString()
    {
        return $this->typeStock;
    }

    /**
     * @return Collection<int, StockSite>
     */
    public function getStockSites(): Collection
    {
        return $this->stockSites;
    }

   /*  public function addStockSite(StockSite $stockSite): self
    {
        if (!$this->stockSites->contains($stockSite)) {
            $this->stockSites[] = $stockSite;
            $stockSite->setStockSite($this);
        }

        return $this;
    }

    public function removeStockSite(StockSite $stockSite): self
    {
        if ($this->stockSites->removeElement($stockSite)) {
            // set the owning side to null (unless already changed)
            if ($stockSite->getTypeStock() === $this) {
                $stockSite->setTypeStock(null);
            }
        }

        return $this;
    } */
}
