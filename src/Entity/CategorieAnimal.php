<?php

namespace App\Entity;

use App\Repository\CategorieAnimalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CategorieAnimalRepository::class)]
class CategorieAnimal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank()]
    #[Assert\Length(
        min: 1,
        max: 50,
    )]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'categorieAnimal', targetEntity: AnimalMemorial::class)]
    private Collection $animaux;

    public function __construct()
    {
        $this->animaux = new ArrayCollection();
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
     * @return Collection<int, AnimalMemorial>
     */
    public function getAnimaux(): Collection
    {
        return $this->animaux;
    }

    public function addAnimaux(AnimalMemorial $animaux): self
    {
        if (!$this->animaux->contains($animaux)) {
            $this->animaux->add($animaux);
            $animaux->setCategorieAnimal($this);
        }

        return $this;
    }

    public function removeAnimaux(AnimalMemorial $animaux): self
    {
        if ($this->animaux->removeElement($animaux)) {
            // set the owning side to null (unless already changed)
            if ($animaux->getCategorieAnimal() === $this) {
                $animaux->setCategorieAnimal(null);
            }
        }

        return $this;
    }

    public function __toString(){
        return $this->nom;
    }
}
