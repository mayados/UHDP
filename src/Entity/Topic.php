<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TopicRepository;
use App\Entity\Trait\DateCreationTrait;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: TopicRepository::class)]
#[UniqueEntity(fields: ['titre'], message: 'Il y a déjà un topic avec ce titre')]
class Topic
{

    use DateCreationTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique:true)]
    #[Assert\NotBlank()]
    #[Assert\Length(
        min: 2,
        max: 255,
    )]
    private ?string $titre = null;

    #[ORM\Column]
    private ?bool $verrouillage = null;

    #[ORM\ManyToOne(inversedBy: 'topics')]
    #[ORM\JoinColumn(nullable: true, onDelete:"SET NULL")]
    private ?User $auteur = null;

    #[ORM\OneToMany(mappedBy: 'topic', targetEntity: Post::class, orphanRemoval: true, cascade:['persist'])]
    private Collection $posts;

    #[ORM\Column(length: 255, unique:true)]
    private ?string $slug = null;

    #[ORM\OneToMany(mappedBy: 'topic', targetEntity: ReportTopic::class, orphanRemoval: true)]
    private Collection $reports;

    public function __construct()
    {
        $this->dateCreation = new \DateTimeImmutable();
        $this->posts = new ArrayCollection();
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

    public function isVerrouillage(): ?bool
    {
        return $this->verrouillage;
    }

    public function setVerrouillage(bool $verrouillage): self
    {
        $this->verrouillage = $verrouillage;

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
            $post->setTopic($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getTopic() === $this) {
                $post->setTopic(null);
            }
        }

        return $this;
    }

    public function howManyPosts():  int{
        return count($this->posts);
    }

    /**
     * @return Collection<int, ReportTopic>
     */
    public function getReports(): Collection
    {
        return $this->reports;
    }

    public function addReport(ReportTopic $report): self
    {
        if (!$this->reports->contains($report)) {
            $this->reports->add($report);
            $report->setTopic($this);
        }

        return $this;
    }

    public function removeReport(ReportTopic $report): self
    {
        if ($this->reports->removeElement($report)) {
            // set the owning side to null (unless already changed)
            if ($report->getTopic() === $this) {
                $report->setTopic(null);
            }
        }

        return $this;
    }

    public function howManyReports():  int{
        return count($this->reports);
    }

}
