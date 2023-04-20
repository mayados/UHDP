<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'Il y a déjà un compte avec cette adresse mail')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank()]
    #[Assert\Email()]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank()]
    #[Assert\Length(
        min: 2,
        max: 50,
    )]
    private ?string $pseudo = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo = null;

    #[ORM\Column]
    private ?bool $bannir = null;

    #[ORM\OneToMany(mappedBy: 'auteur', targetEntity: AnimalMemorial::class)]
    private Collection $memoriaux;

    #[ORM\OneToMany(mappedBy: 'auteur', targetEntity: MotCommemoration::class)]
    private Collection $motsCommemoration;

    #[ORM\OneToMany(mappedBy: 'auteur', targetEntity: Topic::class)]
    private Collection $topics;

    #[ORM\OneToMany(mappedBy: 'auteur', targetEntity: Post::class)]
    private Collection $posts;

    #[ORM\OneToMany(mappedBy: 'auteur', targetEntity: CommentBelleHistoire::class)]
    private Collection $commentaires;

    #[ORM\OneToMany(mappedBy: 'auteur', targetEntity: BelleHistoire::class)]
    private Collection $bellesHistoires;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    #[ORM\Column(type:'datetime_immutable',options: ['default' => 'CURRENT_TIMESTAMP'])]
    private $dateInscription;

    #[ORM\OneToMany(mappedBy: 'expediteur', targetEntity: Message::class, orphanRemoval: true)]
    private Collection $messagesEnvoyes;

    #[ORM\OneToMany(mappedBy: 'destinataire', targetEntity: Message::class, orphanRemoval: true)]
    private Collection $messagesRecus;

    #[ORM\ManyToMany(targetEntity: BelleHistoire::class, mappedBy: 'likes')]
    private Collection $bellesHistoiresLiked;

    #[ORM\ManyToMany(targetEntity: CommentBelleHistoire::class, mappedBy: 'likes')]
    private Collection $likedComments;

    #[ORM\ManyToMany(targetEntity: AnimalMemorial::class, mappedBy: 'soutients')]
    private Collection $memoriauxSoutenus;

    #[ORM\ManyToMany(targetEntity: BelleHistoire::class, mappedBy: 'favoris')]
    private Collection $histoiresFavorites;

    #[ORM\OneToMany(mappedBy: 'auteur', targetEntity: Condoleance::class)]
    private Collection $condoleances;

    #[ORM\ManyToMany(targetEntity: BelleHistoire::class, mappedBy: 'reports')]
    private Collection $bellesHistoiresReported;

    #[ORM\ManyToMany(targetEntity: CommentBelleHistoire::class, mappedBy: 'reports')]
    private Collection $reportedComments;

    #[ORM\ManyToMany(targetEntity: AnimalMemorial::class, mappedBy: 'reports')]
    private Collection $reportedMemoriaux;

    #[ORM\ManyToMany(targetEntity: Condoleance::class, mappedBy: 'reports')]
    private Collection $reportedCondoleances;

    #[ORM\ManyToMany(targetEntity: MotCommemoration::class, mappedBy: 'reports')]
    private Collection $reportedMots;

    #[ORM\ManyToMany(targetEntity: Post::class, mappedBy: 'reports')]
    private Collection $reportedPosts;

    #[ORM\ManyToMany(targetEntity: Topic::class, mappedBy: 'reports')]
    private Collection $reportedTopics;

    public function __construct()
    {
        $this->memoriaux = new ArrayCollection();
        $this->motsCommemoration = new ArrayCollection();
        $this->topics = new ArrayCollection();
        $this->posts = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
        $this->bellesHistoires = new ArrayCollection();
        $this->dateInscription = new \DateTimeImmutable();
        $this->messagesEnvoyes = new ArrayCollection();
        $this->messagesRecus = new ArrayCollection();
        $this->bellesHistoiresLiked = new ArrayCollection();
        $this->likedComments = new ArrayCollection();
        $this->memoriauxSoutenus = new ArrayCollection();
        $this->histoiresFavorites = new ArrayCollection();
        $this->condoleances = new ArrayCollection();
        $this->bellesHistoiresReported = new ArrayCollection();
        $this->reportedComments = new ArrayCollection();
        $this->reportedMemoriaux = new ArrayCollection();
        $this->reportedCondoleances = new ArrayCollection();
        $this->reportedMots = new ArrayCollection();
        $this->reportedPosts = new ArrayCollection();
        $this->reportedTopics = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

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

    public function isBannir(): ?bool
    {
        return $this->bannir;
    }

    public function setBannir(bool $bannir): self
    {
        $this->bannir = $bannir;

        return $this;
    }

    /**
     * @return Collection<int, AnimalMemorial>
     */
    public function getMemoriaux(): Collection
    {
        return $this->memoriaux;
    }

    public function addMemoriaux(AnimalMemorial $memoriaux): self
    {
        if (!$this->memoriaux->contains($memoriaux)) {
            $this->memoriaux->add($memoriaux);
            $memoriaux->setAuteur($this);
        }

        return $this;
    }

    public function removeMemoriaux(AnimalMemorial $memoriaux): self
    {
        if ($this->memoriaux->removeElement($memoriaux)) {
            // set the owning side to null (unless already changed)
            if ($memoriaux->getAuteur() === $this) {
                $memoriaux->setAuteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MotCommemoration>
     */
    public function getMotsCommemoration(): Collection
    {
        return $this->motsCommemoration;
    }

    public function addMotsCommemoration(MotCommemoration $motsCommemoration): self
    {
        if (!$this->motsCommemoration->contains($motsCommemoration)) {
            $this->motsCommemoration->add($motsCommemoration);
            $motsCommemoration->setAuteur($this);
        }

        return $this;
    }

    public function removeMotsCommemoration(MotCommemoration $motsCommemoration): self
    {
        if ($this->motsCommemoration->removeElement($motsCommemoration)) {
            // set the owning side to null (unless already changed)
            if ($motsCommemoration->getAuteur() === $this) {
                $motsCommemoration->setAuteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Topic>
     */
    public function getTopics(): Collection
    {
        return $this->topics;
    }

    public function addTopic(Topic $topic): self
    {
        if (!$this->topics->contains($topic)) {
            $this->topics->add($topic);
            $topic->setAuteur($this);
        }

        return $this;
    }

    public function removeTopic(Topic $topic): self
    {
        if ($this->topics->removeElement($topic)) {
            // set the owning side to null (unless already changed)
            if ($topic->getAuteur() === $this) {
                $topic->setAuteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Post>
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts->add($post);
            $post->setAuteur($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getAuteur() === $this) {
                $post->setAuteur(null);
            }
        }

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
            $commentaire->setAuteur($this);
        }

        return $this;
    }

    public function removeCommentaire(CommentBelleHistoire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getAuteur() === $this) {
                $commentaire->setAuteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BelleHistoire>
     */
    public function getBellesHistoires(): Collection
    {
        return $this->bellesHistoires;
    }

    public function addBellesHistoire(BelleHistoire $bellesHistoire): self
    {
        if (!$this->bellesHistoires->contains($bellesHistoire)) {
            $this->bellesHistoires->add($bellesHistoire);
            $bellesHistoire->setAuteur($this);
        }

        return $this;
    }

    public function removeBellesHistoire(BelleHistoire $bellesHistoire): self
    {
        if ($this->bellesHistoires->removeElement($bellesHistoire)) {
            // set the owning side to null (unless already changed)
            if ($bellesHistoire->getAuteur() === $this) {
                $bellesHistoire->setAuteur(null);
            }
        }

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getDateInscription(): ?\DateTimeImmutable
    {
        return $this->dateInscription;
    }

    public function setDateInscription(\DateTimeImmutable $dateInscription): self
    {
        $this->dateInscription = $dateInscription;

        return $this;
    }    
    /**
     * @return Collection<int, Message>
     */
    public function getMessagesEnvoyes(): Collection
    {
        return $this->messagesEnvoyes;
    }

    public function addMessagesEnvoye(Message $messagesEnvoye): self
    {
        if (!$this->messagesEnvoyes->contains($messagesEnvoye)) {
            $this->messagesEnvoyes->add($messagesEnvoye);
            $messagesEnvoye->setExpediteur($this);
        }

        return $this;
    }

    public function removeMessagesEnvoye(Message $messagesEnvoye): self
    {
        if ($this->messagesEnvoyes->removeElement($messagesEnvoye)) {
            // set the owning side to null (unless already changed)
            if ($messagesEnvoye->getExpediteur() === $this) {
                $messagesEnvoye->setExpediteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessagesRecus(): Collection
    {
        return $this->messagesRecus;
    }

    public function addMessagesRecu(Message $messagesRecu): self
    {
        if (!$this->messagesRecus->contains($messagesRecu)) {
            $this->messagesRecus->add($messagesRecu);
            $messagesRecu->setDestinataire($this);
        }

        return $this;
    }

    public function removeMessagesRecu(Message $messagesRecu): self
    {
        if ($this->messagesRecus->removeElement($messagesRecu)) {
            // set the owning side to null (unless already changed)
            if ($messagesRecu->getDestinataire() === $this) {
                $messagesRecu->setDestinataire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BelleHistoire>
     */
    public function getBellesHistoiresLiked(): Collection
    {
        return $this->bellesHistoiresLiked;
    }

    public function addBellesHistoiresLiked(BelleHistoire $bellesHistoiresLiked): self
    {
        if (!$this->bellesHistoiresLiked->contains($bellesHistoiresLiked)) {
            $this->bellesHistoiresLiked->add($bellesHistoiresLiked);
            $bellesHistoiresLiked->addLike($this);
        }

        return $this;
    }

    public function removeBellesHistoiresLiked(BelleHistoire $bellesHistoiresLiked): self
    {
        if ($this->bellesHistoiresLiked->removeElement($bellesHistoiresLiked)) {
            $bellesHistoiresLiked->removeLike($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, CommentBelleHistoire>
     */
    public function getLikedComments(): Collection
    {
        return $this->likedComments;
    }

    public function addLikedComment(CommentBelleHistoire $likedComment): self
    {
        if (!$this->likedComments->contains($likedComment)) {
            $this->likedComments->add($likedComment);
            $likedComment->addLike($this);
        }

        return $this;
    }

    public function removeLikedComment(CommentBelleHistoire $likedComment): self
    {
        if ($this->likedComments->removeElement($likedComment)) {
            $likedComment->removeLike($this);
        }

        return $this;
    }    

    /**
     * @return Collection<int, AnimalMemorial>
     */
    public function getMemoriauxSoutenus(): Collection
    {
        return $this->memoriauxSoutenus;
    }

    public function addMemoriauxSoutenu(AnimalMemorial $memoriauxSoutenu): self
    {
        if (!$this->memoriauxSoutenus->contains($memoriauxSoutenu)) {
            $this->memoriauxSoutenus->add($memoriauxSoutenu);
            $memoriauxSoutenu->addSoutient($this);
        }

        return $this;
    }

    public function removeMemoriauxSoutenu(AnimalMemorial $memoriauxSoutenu): self
    {
        if ($this->memoriauxSoutenus->removeElement($memoriauxSoutenu)) {
            $memoriauxSoutenu->removeSoutient($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, BelleHistoire>
     */
    public function getHistoiresFavorites(): Collection
    {
        return $this->histoiresFavorites;
    }

    public function addHistoiresFavorite(BelleHistoire $histoiresFavorite): self
    {
        if (!$this->histoiresFavorites->contains($histoiresFavorite)) {
            $this->histoiresFavorites->add($histoiresFavorite);
            $histoiresFavorite->addFavori($this);
        }

        return $this;
    }

    public function removeHistoiresFavorite(BelleHistoire $histoiresFavorite): self
    {
        if ($this->histoiresFavorites->removeElement($histoiresFavorite)) {
            $histoiresFavorite->removeFavori($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Condoleance>
     */
    public function getCondoleances(): Collection
    {
        return $this->condoleances;
    }

    public function addCondoleance(Condoleance $condoleance): self
    {
        if (!$this->condoleances->contains($condoleance)) {
            $this->condoleances->add($condoleance);
            $condoleance->setAuteur($this);
        }

        return $this;
    }

    public function removeCondoleance(Condoleance $condoleance): self
    {
        if ($this->condoleances->removeElement($condoleance)) {
            // set the owning side to null (unless already changed)
            if ($condoleance->getAuteur() === $this) {
                $condoleance->setAuteur(null);
            }
        }

        return $this;
    }

        /**
     * @return Collection<int, BelleHistoire>
     */
    public function getBellesHistoiresReported(): Collection
    {
        return $this->bellesHistoiresReported;
    }

    public function addBellesHistoiresReported(BelleHistoire $bellesHistoiresReported): self
    {
        if (!$this->bellesHistoiresReported->contains($bellesHistoiresReported)) {
            $this->bellesHistoiresReported->add($bellesHistoiresReported);
            $bellesHistoiresReported->addReport($this);
        }

        return $this;
    }

    public function removeBellesHistoiresReported(BelleHistoire $bellesHistoiresReported): self
    {
        if ($this->bellesHistoiresReported->removeElement($bellesHistoiresReported)) {
            $bellesHistoiresReported->removeReport($this);
        }

        return $this;
    }


    /**
     * @return Collection<int, CommentBelleHistoire>
     */
    public function getReportedComments(): Collection
    {
        return $this->reportedComments;
    }

    public function addReportedComment(CommentBelleHistoire $reportedComment): self
    {
        if (!$this->reportedComments->contains($reportedComment)) {
            $this->reportedComments->add($reportedComment);
            $reportedComment->addReport($this);
        }

        return $this;
    }

    public function removeReportedComment(CommentBelleHistoire $reportedComment): self
    {
        if ($this->reportedComments->removeElement($reportedComment)) {
            $reportedComment->removeReport($this);
        }

        return $this;
    }    

    /**
     * @return Collection<int, AnimalMemorial>
     */
    public function getReportedMemoriaux(): Collection
    {
        return $this->reportedMemoriaux;
    }

    public function addReportedMemorial(AnimalMemorial $reportedMemorial): self
    {
        if (!$this->reportedMemoriaux->contains($reportedMemorial)) {
            $this->reportedMemoriaux->add($reportedMemorial);
            $reportedMemorial->addReport($this);
        }

        return $this;
    }

    public function removeReportedMemorial(AnimalMemorial $reportedMemorial): self
    {
        if ($this->reportedMemoriaux->removeElement($reportedMemorial)) {
            $reportedMemorial->removeReport($this);
        }

        return $this;
    }    

    /**
     * @return Collection<int, Condoleance>
     */
    public function getReportedCondoleances(): Collection
    {
        return $this->reportedCondoleances;
    }

    public function addReportedCondoleance(Condoleance $reportedCondoleance): self
    {
        if (!$this->reportedCondoleances->contains($reportedCondoleance)) {
            $this->reportedCondoleances->add($reportedCondoleance);
            $reportedCondoleance->addReport($this);
        }

        return $this;
    }

    public function removeReporteCondoleance(Condoleance $reportedCondoleance): self
    {
        if ($this->reportedCondoleances->removeElement($reportedCondoleance)) {
            $reportedCondoleance->removeReport($this);
        }

        return $this;
    }    

    /**
     * @return Collection<int, MotCommemoration>
     */
    public function getReportedMots(): Collection
    {
        return $this->reportedMots;
    }

    public function addReportedMot(MotCommemoration $reportedMot): self
    {
        if (!$this->reportedMots->contains($reportedMot)) {
            $this->reportedMots->add($reportedMot);
            $reportedMot->addReport($this);
        }

        return $this;
    }

    public function removeReportedMot(MotCommemoration $reportedMot): self
    {
        if ($this->reportedMots->removeElement($reportedMot)) {
            $reportedMot->removeReport($this);
        }

        return $this;
    }    

    /**
     * @return Collection<int, Post>
     */
    public function getReportedPosts(): Collection
    {
        return $this->reportedPosts;
    }

    public function addReportedPost(Post $reportedPost): self
    {
        if (!$this->reportedPosts->contains($reportedPost)) {
            $this->reportedPosts->add($reportedPost);
            $reportedPost->addReport($this);
        }

        return $this;
    }

    public function removeReportedPost(Post $reportedPost): self
    {
        if ($this->reportedPosts->removeElement($reportedPost)) {
            $reportedPost->removeReport($this);
        }

        return $this;
    }    

    /**
     * @return Collection<int, Topic>
     */
    public function getReportedTopics(): Collection
    {
        return $this->reportedTopics;
    }

    public function addReportedTopic(Topic $reportedTopic): self
    {
        if (!$this->reportedTopics->contains($reportedTopic)) {
            $this->reportedTopics->add($reportedTopic);
            $reportedTopic->addReport($this);
        }

        return $this;
    }

    public function removeReportedTopic(Topic $reportedTopic): self
    {
        if ($this->reportedTopics->removeElement($reportedTopic)) {
            $reportedTopic->removeReport($this);
        }

        return $this;
    }    



    public function __toString(){
        return $this->pseudo;
    }   

}
