<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Trait\DateCreationTrait;
use App\Repository\CondoleanceRepository;

#[ORM\Entity(repositoryClass: CondoleanceRepository::class)]
class Condoleance
{

    use DateCreationTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $texte = null;

    #[ORM\ManyToOne(inversedBy: 'condoleances')]
    #[ORM\JoinColumn(nullable: true, onDelete:"SET NULL")]
    private ?User $auteur = null;

    #[ORM\ManyToOne(inversedBy: 'condoleances')]
    #[ORM\JoinColumn(nullable: false)]
    private ?AnimalMemorial $memorial = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'reportedCondoleances')]
    #[ORM\JoinTable(name: 'condoleances_reports')]
    private Collection $reports;

    public function __construct()
    {
        $this->dateCreation = new \DateTimeImmutable();
        $this->reports = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTexte(): ?string
    {
        return $this->texte;
    }

    public function setTexte(string $texte): self
    {
        $this->texte = $texte;

        return $this;
    }

    public function getAuteur(): ?User
    {
        return $this->auteur;
    }

    public function setAuteur(?User $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getMemorial(): ?AnimalMemorial
    {
        return $this->memorial;
    }

    public function setMemorial(?AnimalMemorial $memorial): self
    {
        $this->memorial = $memorial;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getReports(): Collection
    {
        return $this->reports;
    }

    public function addReport(User $report): self
    {
        if (!$this->reports->contains($report)) {
            $this->reports->add($report);
        }

        return $this;
    }

    public function removeReport(User $report): self
    {
        $this->reports->removeElement($report);

        return $this;
    }
    
}
