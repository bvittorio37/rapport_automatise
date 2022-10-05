<?php

namespace App\Entity;

use App\Repository\SiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SiteRepository::class)]
class Site
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 30)]
    private $lieu;

    #[ORM\OneToMany(mappedBy: 'site', targetEntity: User::class)]
    private $users;

    #[ORM\OneToMany(mappedBy: 'site', targetEntity: Paf::class)]
    private $pafs;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private $remarque;

    #[ORM\OneToMany(mappedBy: 'site', targetEntity: StockSite::class)]
    private $stockSites;

    #[ORM\OneToMany(mappedBy: 'site', targetEntity: Rapport::class)]
    private $rapports;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->pafs = new ArrayCollection();
        $this->stockSites = new ArrayCollection();
        $this->rapports = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setSite($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getSite() === $this) {
                $user->setSite(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Paf>
     */
    public function getPafs(): Collection
    {
        return $this->pafs;
    }

    public function addPaf(Paf $paf): self
    {
        if (!$this->pafs->contains($paf)) {
            $this->pafs[] = $paf;
            $paf->setSite($this);
        }

        return $this;
    }

    public function removePaf(Paf $paf): self
    {
        if ($this->pafs->removeElement($paf)) {
            // set the owning side to null (unless already changed)
            if ($paf->getSite() === $this) {
                $paf->setSite(null);
            }
        }

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
        return $this->lieu;
    }

    /**
     * @return Collection<int, StockSite>
     */
    public function getStockSites(): Collection
    {
        return $this->stockSites;
    }

    public function addStockSite(StockSite $stockSite): self
    {
        if (!$this->stockSites->contains($stockSite)) {
            $this->stockSites[] = $stockSite;
            $stockSite->setSite($this);
        }

        return $this;
    }

    public function removeStockSite(StockSite $stockSite): self
    {
        if ($this->stockSites->removeElement($stockSite)) {
            // set the owning side to null (unless already changed)
            if ($stockSite->getSite() === $this) {
                $stockSite->setSite(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Rapport>
     */
    public function getRapports(): Collection
    {
        return $this->rapports;
    }

    public function addRapport(Rapport $rapport): self
    {
        if (!$this->rapports->contains($rapport)) {
            $this->rapports[] = $rapport;
            $rapport->setSite($this);
        }

        return $this;
    }

    public function removeRapport(Rapport $rapport): self
    {
        if ($this->rapports->removeElement($rapport)) {
            // set the owning side to null (unless already changed)
            if ($rapport->getSite() === $this) {
                $rapport->setSite(null);
            }
        }

        return $this;
    }
}
