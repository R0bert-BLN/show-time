<?php

namespace App\Entity;

use App\Repository\TicketTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TicketTypeRepository::class)]
#[ORM\HasLifecycleCallbacks]
class TicketType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'ticketTypes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Festival $festival = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: 'The name must be at least {{ limit }} characters long.',
        maxMessage: 'The name cannot be longer than {{ limit }} characters.',
    )]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $totalTickets = null;

    #[ORM\Column]
    private ?\DateTime $startSaleDate = null;

    #[ORM\Column]
    #[Assert\GreaterThan(
        propertyPath: 'startSaleDate',
        message: 'End date must be after the start date.'
    )]
    private ?\DateTime $endSaleDate = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $price = null;

    #[ORM\Column(length: 3)]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 3,
        max: 3,
        minMessage: 'The name must be {{ limit }} characters long.',
        maxMessage: 'The name must be {{ limit }} characters long.',
    )]
    private ?string $currency = null;

    /**
     * @var Collection<int, IssuedTicket>
     */
    #[ORM\OneToMany(targetEntity: IssuedTicket::class, mappedBy: 'ticketType')]
    private Collection $issuedTickets;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $updatedAt = null;

    public function getSoldTickets(): int
    {
        return $this->issuedTickets->count();
    }

    #[ORM\PrePersist]
    public function onCreate(): void
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    #[ORM\PreUpdate]
    public function onUpdate(): void
    {
        $this->updatedAt = new \DateTime();
    }

    public function __construct()
    {
        $this->issuedTickets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFestival(): ?Festival
    {
        return $this->festival;
    }

    public function setFestival(?Festival $festival): static
    {
        $this->festival = $festival;

        return $this;
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

    public function getTotalTickets(): ?int
    {
        return $this->totalTickets;
    }

    public function setTotalTickets(int $totalTickets): static
    {
        $this->totalTickets = $totalTickets;

        return $this;
    }

    public function getStartSaleDate(): ?\DateTime
    {
        return $this->startSaleDate;
    }

    public function setStartSaleDate(\DateTime $startSaleDate): static
    {
        $this->startSaleDate = $startSaleDate;

        return $this;
    }

    public function getEndSaleDate(): ?\DateTime
    {
        return $this->endSaleDate;
    }

    public function setEndSaleDate(\DateTime $endSaleDate): static
    {
        $this->endSaleDate = $endSaleDate;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): static
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @return Collection<int, IssuedTicket>
     */
    public function getIssuedTickets(): Collection
    {
        return $this->issuedTickets;
    }

    public function addIssuedTicket(IssuedTicket $issuedTicket): static
    {
        if (!$this->issuedTickets->contains($issuedTicket)) {
            $this->issuedTickets->add($issuedTicket);
            $issuedTicket->setTicketType($this);
        }

        return $this;
    }

    public function removeIssuedTicket(IssuedTicket $issuedTicket): static
    {
        if ($this->issuedTickets->removeElement($issuedTicket)) {
            // set the owning side to null (unless already changed)
            if ($issuedTicket->getTicketType() === $this) {
                $issuedTicket->setTicketType(null);
            }
        }

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

    public function setUpdatedAt(\DateTime $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
