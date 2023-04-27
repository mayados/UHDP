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

    #[ORM\OneToMany(mappedBy: 'condoleance', targetEntity: ReportCondoleance::class, orphanRemoval: true)]
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
     * @return Collection<int, ReportCondoleance>
     */
    public function getReports(): Collection
    {
        return $this->reports;
    }

    public function addReport(ReportCondoleance $report): self
    {
        if (!$this->reports->contains($report)) {
            $this->reports->add($report);
            $report->setCondoleance($this);
        }

        return $this;
    }

    public function removeReport(ReportCondoleance $report): self
    {
        if ($this->reports->removeElement($report)) {
            // set the owning side to null (unless already changed)
            if ($report->getCondoleance() === $this) {
                $report->setCondoleance(null);
            }
        }

        return $this;
    }
    
}
