<?php

namespace App\Entity;

use App\Entity\Trait\DateCreationTrait;
use App\Repository\AnimalMemorialRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AnimalMemorialRepository::class)]
class AnimalMemorial
{

    use DateCreationTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    // Les contraintes ont déjà été définies dnas le formulaire associé, mais pour assurer un maximum de sécurié, je les réitère ici
    #[Assert\NotBlank()]
    #[Assert\Length(
        min: 2,
        max: 50,
    )]
    private ?string $nom = null;

    #[ORM\Column(length: 10, nullable: true)]
    #[Assert\Choice(['Male','Femelle'])]
    private ?string $sexe = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Assert\LessThanOrEqual('today')]
    private ?\DateTimeInterface $dateNaissance = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: false)]
    #[Assert\LessThanOrEqual('today')]
    private ?\DateTimeInterface $dateDeces = null;

    #[ORM\Column(length: 100, nullable: true)]
    #[Assert\Length(
        min: 2,
        max: 100,
    )]
    private ?string $lieu = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank()]
    private ?string $presentation = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank()]
    private ?string $chosesAimees = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank()]
    private ?string $chosesDetestees = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank()]
    private ?string $histoire = null;

    // On doit indiquer que le persist doit se faire également sur cette collection, même s'il n'y a pas de champs dans la database de AnimalMemorial pour les photos de la galerie
    #[ORM\OneToMany(mappedBy: 'memorial', targetEntity: Photo::class, orphanRemoval: true, cascade:['persist'])]
    private Collection $photos;

    #[ORM\ManyToOne(inversedBy: 'animaux')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CategorieAnimal $categorieAnimal = null;

    #[ORM\ManyToOne(inversedBy: 'memoriaux')]
    #[ORM\JoinColumn(nullable: true, onDelete:"SET NULL")]
    private ?User $auteur = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'memoriauxSoutenus')]
    private Collection $soutients;

    #[ORM\OneToMany(mappedBy: 'memorial', targetEntity: Condoleance::class)]
    private Collection $condoleances;

    #[ORM\OneToMany(mappedBy: 'memorial', targetEntity: ReportMemorial::class, orphanRemoval: true)]
    private Collection $reports;

    public function __construct()
    {
        $this->dateCreation = new \DateTimeImmutable();
        $this->photos = new ArrayCollection();
        $this->soutients = new ArrayCollection();
        $this->condoleances = new ArrayCollection();
        $this->reports = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(?string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(?\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getDateDeces(): ?\DateTimeInterface
    {
        return $this->dateDeces;
    }

    public function setDateDeces(?\DateTimeInterface $dateDeces): self
    {
        $this->dateDeces = $dateDeces;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(?string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    // Il s'agit d'une string, car on stocke le nom du fichier et non son contenu
    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(string $presentation): self
    {
        $this->presentation = $presentation;

        return $this;
    }

    public function getChosesAimees(): ?string
    {
        return $this->chosesAimees;
    }

    public function setChosesAimees(string $chosesAimees): self
    {
        $this->chosesAimees = $chosesAimees;

        return $this;
    }

    public function getChosesDetestees(): ?string
    {
        return $this->chosesDetestees;
    }

    public function setChosesDetestees(string $chosesDetestees): self
    {
        $this->chosesDetestees = $chosesDetestees;

        return $this;
    }

    public function getHistoire(): ?string
    {
        return $this->histoire;
    }

    public function setHistoire(string $histoire): self
    {
        $this->histoire = $histoire;

        return $this;
    }

    /**
     * @return Collection<int, Photo>
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photo $photo): self
    {
        if (!$this->photos->contains($photo)) {
            $this->photos->add($photo);
            $photo->setMemorial($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): self
    {
        if ($this->photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getMemorial() === $this) {
                $photo->setMemorial(null);
            }
        }

        return $this;
    }

    public function getCategorieAnimal(): ?CategorieAnimal
    {
        return $this->categorieAnimal;
    }

    public function setCategorieAnimal(?CategorieAnimal $categorieAnimal): self
    {
        $this->categorieAnimal = $categorieAnimal;

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
    public function getSoutients(): Collection
    {
        return $this->soutients;
    }

    public function addSoutient(User $soutient): self
    {
        if (!$this->soutients->contains($soutient)) {
            $this->soutients->add($soutient);
        }

        return $this;
    }

    public function removeSoutient(User $soutient): self
    {
        $this->soutients->removeElement($soutient);

        return $this;
    }

    public function isSupportedByUser(User $user):  bool{
        return $this->soutients->contains($user);
    }

    public function howManySupports():  int{
        return count($this->soutients);
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
            $condoleance->setMemorial($this);
        }

        return $this;
    }

    public function removeCondoleance(Condoleance $condoleance): self
    {
        if ($this->condoleances->removeElement($condoleance)) {
            // set the owning side to null (unless already changed)
            if ($condoleance->getMemorial() === $this) {
                $condoleance->setMemorial(null);
            }
        }

        return $this;
    }    

    public function __toString(){
        return $this->nom;
    }

    /**
     * @return Collection<int, ReportMemorial>
     */
    public function getReports(): Collection
    {
        return $this->reports;
    }

    public function addReport(ReportMemorial $report): self
    {
        if (!$this->reports->contains($report)) {
            $this->reports->add($report);
            $report->setMemorial($this);
        }

        return $this;
    }

    public function removeReport(ReportMemorial $report): self
    {
        if ($this->reports->removeElement($report)) {
            // set the owning side to null (unless already changed)
            if ($report->getMemorial() === $this) {
                $report->setMemorial(null);
            }
        }

        return $this;
    }

}
