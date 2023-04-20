<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Trait\DateCreationTrait;
use App\Repository\MotCommemorationRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MotCommemorationRepository::class)]
class MotCommemoration
{

    use DateCreationTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank()]
    #[Assert\Length(
        min: 4,
        max: 500,
    )]
    private ?string $mot = null;

    #[ORM\ManyToOne(inversedBy: 'motsCommemoration')]
    #[ORM\JoinColumn(nullable: true, onDelete:"SET NULL")]
    private ?User $auteur = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'reportedMots')]
    #[ORM\JoinTable(name: 'mots_reports')]
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

    public function getMot(): ?string
    {
        return $this->mot;
    }

    public function setMot(string $mot): self
    {
        $this->mot = $mot;

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
