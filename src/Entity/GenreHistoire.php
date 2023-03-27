<?php

namespace App\Entity;

use App\Repository\GenreHistoireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GenreHistoireRepository::class)]
class GenreHistoire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'genre', targetEntity: BelleHistoire::class, orphanRemoval: true)]
    private Collection $belleHistoires;

    public function __construct()
    {
        $this->belleHistoires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, BelleHistoire>
     */
    public function getBelleHistoires(): Collection
    {
        return $this->belleHistoires;
    }

    public function addBelleHistoire(BelleHistoire $belleHistoire): self
    {
        if (!$this->belleHistoires->contains($belleHistoire)) {
            $this->belleHistoires->add($belleHistoire);
            $belleHistoire->setGenre($this);
        }

        return $this;
    }

    public function removeBelleHistoire(BelleHistoire $belleHistoire): self
    {
        if ($this->belleHistoires->removeElement($belleHistoire)) {
            // set the owning side to null (unless already changed)
            if ($belleHistoire->getGenre() === $this) {
                $belleHistoire->setGenre(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->nom;
    }
}
