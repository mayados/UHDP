<?php

namespace App\Entity;

use App\Repository\ReportCommentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReportCommentRepository::class)]
class ReportComment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $dateCreation = null;

    #[ORM\ManyToOne(inversedBy: 'reports')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CommentBelleHistoire $commentaire = null;

    #[ORM\ManyToOne(inversedBy: 'reportedComments')]
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

    public function getCommentaire(): ?CommentBelleHistoire
    {
        return $this->commentaire;
    }

    public function setCommentaire(?CommentBelleHistoire $commentaire): self
    {
        $this->commentaire = $commentaire;

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
