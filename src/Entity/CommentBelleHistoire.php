<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Trait\DateCreationTrait;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Repository\CommentBelleHistoireRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CommentBelleHistoireRepository::class)]
class CommentBelleHistoire
{

    use DateCreationTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank()]
    private ?string $texte = null;

    #[ORM\ManyToOne(inversedBy: 'commentaires')]
    #[ORM\JoinColumn(nullable: true, onDelete:"SET NULL")]
    private ?User $auteur = null;

    #[ORM\ManyToOne(inversedBy: 'commentaires')]
    #[ORM\JoinColumn(nullable: false)]
    private ?BelleHistoire $belleHistoire = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'likedComments')]
    #[ORM\JoinTable(name: 'comment_likes')]
    private Collection $likes;

    #[ORM\OneToMany(mappedBy: 'commentaire', targetEntity: ReportComment::class, orphanRemoval: true)]
    private Collection $reports;

    public function __construct()
    {
        $this->dateCreation = new \DateTimeImmutable();
        $this->likes = new ArrayCollection();
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

    public function getBelleHistoire(): ?BelleHistoire
    {
        return $this->belleHistoire;
    }

    public function setBelleHistoire(?BelleHistoire $belleHistoire): self
    {
        $this->belleHistoire = $belleHistoire;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(User $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes->add($like);
        }

        return $this;
    }

    public function removeLike(User $like): self
    {
        $this->likes->removeElement($like);

        return $this;
    }

    public function isLikedByUser(User $user):  bool{
        return $this->likes->contains($user);
    }

    public function howManyLikes():  int{
        return count($this->likes);
    }

    /**
     * @return Collection<int, ReportComment>
     */
    public function getReports(): Collection
    {
        return $this->reports;
    }

    public function addReport(ReportComment $report): self
    {
        if (!$this->reports->contains($report)) {
            $this->reports->add($report);
            $report->setCommentaire($this);
        }

        return $this;
    }

    public function removeReport(ReportComment $report): self
    {
        if ($this->reports->removeElement($report)) {
            // set the owning side to null (unless already changed)
            if ($report->getCommentaire() === $this) {
                $report->setCommentaire(null);
            }
        }

        return $this;
    }

}
