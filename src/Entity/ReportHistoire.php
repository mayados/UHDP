<?php

namespace App\Entity;

use App\Repository\ReportHistoireRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReportHistoireRepository::class)]
class ReportHistoire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $dateCreation = null;

    #[ORM\ManyToOne(inversedBy: 'reports')]
    #[ORM\JoinColumn(nullable: false)]
    private ?BelleHistoire $histoire = null;

    #[ORM\ManyToOne(inversedBy: 'reportedHistoires')]
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

    public function getHistoire(): ?BelleHistoire
    {
        return $this->histoire;
    }

    public function setHistoire(?BelleHistoire $histoire): self
    {
        $this->histoire = $histoire;

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
