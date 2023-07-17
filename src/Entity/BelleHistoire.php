<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Trait\DateCreationTrait;
use App\Repository\BelleHistoireRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: BelleHistoireRepository::class)]
#[UniqueEntity(fields: ['titre'], message: 'Il y a déjà une histoire avec ce titre')]
class BelleHistoire
{

    const STATES = ['STATE_DRAFT', 'STATE_WAITING', 'STATE_APPROUVED', 'STATE_DISAPPROUVED'];

    use DateCreationTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique:true)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $texte = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo = null;

    #[ORM\ManyToOne(inversedBy: 'bellesHistoires')]
    #[ORM\JoinColumn(nullable: true, onDelete:"SET NULL")]
    private ?User $auteur = null;

    #[ORM\OneToMany(mappedBy: 'belleHistoire', targetEntity: CommentBelleHistoire::class, orphanRemoval: true)]
    private Collection $commentaires;

    #[ORM\Column(length: 255, unique:true)]
    private ?string $slug = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'bellesHistoiresLiked')]
    #[ORM\JoinTable(name: 'histoire_likes')]
    private Collection $likes;

    #[ORM\Column(length: 30)]
    private ?string $etat = BelleHistoire::STATES[0];

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'histoiresFavorites')]
    #[ORM\JoinTable(name: 'favoris_user')]
    private Collection $favoris;

    #[ORM\ManyToOne(inversedBy: 'belleHistoires')]
    #[ORM\JoinColumn(nullable: false)]
    private ?GenreHistoire $genre = null;

    #[ORM\OneToMany(mappedBy: 'histoire', targetEntity: ReportHistoire::class, orphanRemoval: true)]
    private Collection $reports;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $datePublication = null;

    public function __construct()
    {
        $this->dateCreation = new \DateTimeImmutable();
        $this->commentaires = new ArrayCollection();
        $this->likes = new ArrayCollection();
        $this->favoris = new ArrayCollection();
        $this->reports = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
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

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

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

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * @return Collection<int, CommentBelleHistoire>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(CommentBelleHistoire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires->add($commentaire);
            $commentaire->setBelleHistoire($this);
        }

        return $this;
    }

    public function removeCommentaire(CommentBelleHistoire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getBelleHistoire() === $this) {
                $commentaire->setBelleHistoire(null);
            }
        }

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
     * @return Collection<int, User>
     */
    public function getFavoris(): Collection
    {
        return $this->favoris;
    }

    public function addFavori(User $favori): self
    {
        if (!$this->favoris->contains($favori)) {
            $this->favoris->add($favori);
        }

        return $this;
    }

    public function removeFavori(User $favori): self
    {
        $this->favoris->removeElement($favori);

        return $this;
    }

    public function isFavoritedByUser(User $user):  bool{
        return $this->favoris->contains($user);
    }

    public function getGenre(): ?GenreHistoire
    {
        return $this->genre;
    }

    public function setGenre(?GenreHistoire $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function __toString()
    {
        return $this->titre;
    }

    /**
     * @return Collection<int, ReportHistoire>
     */
    public function getReports(): Collection
    {
        return $this->reports;
    }

    public function addReport(ReportHistoire $report): self
    {
        if (!$this->reports->contains($report)) {
            $this->reports->add($report);
            $report->setHistoire($this);
        }

        return $this;
    }

    public function removeReport(ReportHistoire $report): self
    {
        if ($this->reports->removeElement($report)) {
            // set the owning side to null (unless already changed)
            if ($report->getHistoire() === $this) {
                $report->setHistoire(null);
            }
        }

        return $this;
    }

    public function howManyReports():  int{
        return count($this->reports);
    }

    public function getDatePublication(): ?\DateTimeImmutable
    {
        return $this->datePublication;
    }

    public function setDatePublication(?\DateTimeImmutable $datePublication): self
    {
        $this->datePublication = $datePublication;

        return $this;
    }

}
