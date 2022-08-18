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

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->pafs = new ArrayCollection();
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
}
