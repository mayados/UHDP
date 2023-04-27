<?php

namespace App\Entity;

use App\Repository\ReportCondoleanceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReportCondoleanceRepository::class)]
class ReportCondoleance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $dateCreation = null;

    #[ORM\ManyToOne(inversedBy: 'reports')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Condoleance $condoleance = null;

    #[ORM\ManyToOne(inversedBy: 'reportedCondoleances')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $signaleur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCreation(): ?\DateTimeImmutable
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeImmutable $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getCondoleance(): ?Condoleance
    {
        return $this->condoleance;
    }

    public function setCondoleance(?Condoleance $condoleance): self
    {
        $this->condoleance = $condoleance;

        return $this;
    }

    public function getSignaleur(): ?User
    {
        return $this->signaleur;
    }

    public function setSignaleur(?User $signaleur): self
    {
        $this->signaleur = $signaleur;

        return $this;
    }
}
