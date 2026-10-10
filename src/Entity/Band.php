<?php

namespace App\Entity;

use App\Enum\MusicGenre;
use App\Repository\BandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BandRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Band
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Please enter a name.')]
    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: 'The name must be at least {{ limit }} characters long.',
        maxMessage: 'The name cannot be longer than {{ limit }} characters.',
    )]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'Please enter a description.')]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Url(message: 'Please enter a valid URL.')]
    private ?string $picture = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $updatedAt = null;

    #[ORM\Column(enumType: MusicGenre::class)]
    private ?MusicGenre $genre = null;

    /**
     * @var Collection<int, FestivalBand>
     */
    #[ORM\OneToMany(targetEntity: FestivalBand::class, mappedBy: 'band', orphanRemoval: true)]
    private Collection $festivals;

    #[ORM\PrePersist]
    public function onCreate(): void
    {
        $this->createdAt = new \DateTimeImmutable();

        $slugger = new AsciiSlugger();
        $this->slug = $slugger->slug($this->name);
    }

    #[ORM\PreUpdate]
    public function onUpdate(): void
    {
        $this->updatedAt = new \DateTime();

        $slugger = new AsciiSlugger();
        $this->slug = $slugger->slug($this->name);
    }

    public function __construct()
    {
        $this->festivals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): static
    {
        $this->picture = $picture;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTime $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getGenre(): ?MusicGenre
    {
        return $this->genre;
    }

    public function setGenre(MusicGenre $genre): static
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * @return Collection<int, FestivalBand>
     */
    public function getFestivals(): Collection
    {
        return $this->festivals;
    }

    public function addFestival(FestivalBand $festival): static
    {
        if (!$this->festivals->contains($festival)) {
            $this->festivals->add($festival);
            $festival->setBand($this);
        }

        return $this;
    }

    public function removeFestival(FestivalBand $festival): static
    {
        if ($this->festivals->removeElement($festival)) {
            // set the owning side to null (unless already changed)
            if ($festival->getBand() === $this) {
                $festival->setBand(null);
            }
        }

        return $this;
    }
}
