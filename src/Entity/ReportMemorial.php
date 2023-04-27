<?php

namespace App\Entity;

use App\Repository\ReportMemorialRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReportMemorialRepository::class)]
class ReportMemorial
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $dateCreation = null;

    #[ORM\ManyToOne(inversedBy: 'reports')]
    #[ORM\JoinColumn(nullable: false)]
    private ?AnimalMemorial $memorial = null;

    #[ORM\ManyToOne(inversedBy: 'reportedMemorials')]
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

    public function getMemorial(): ?AnimalMemorial
    {
        return $this->memorial;
    }

    public function setmemorial(?AnimalMemorial $histoire): self
    {
        $this->memorial = $histoire;

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
