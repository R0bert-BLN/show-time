<?php

namespace App\Entity;

use App\Enum\BookingStatus;
use App\Repository\BookingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(enumType: BookingStatus::class)]
    private ?BookingStatus $status = null;

    #[ORM\Column(nullable: false)]
    private string $transactionId;

    #[ORM\ManyToOne(inversedBy: 'bookings')]
    #[ORM\JoinColumn()]
    private ?User $user = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $updatedAt = null;

    /**
     * @var Collection<int, IssuedTicket>
     */
    #[ORM\OneToMany(targetEntity: IssuedTicket::class, mappedBy: 'booking')]
    private Collection $issuedTickets;

    #[ORM\OneToOne(inversedBy: 'booking', cascade: ['persist', 'remove'])]
    private ?CartHistory $cart = null;

    #[ORM\PrePersist]
    public function onCreate(): void
    {
        $this->createdAt = new \DateTime();
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

    public function getTransactionId(): string
    {
        return $this->transactionId;
    }

    public function setTransactionId(string $transactionId): void
    {
        $this->transactionId = $transactionId;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getStatus(): ?BookingStatus
    {
        return $this->status;
    }

    public function setStatus(BookingStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

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
            $issuedTicket->setBooking($this);
        }

        return $this;
    }

    public function removeIssuedTicket(IssuedTicket $issuedTicket): static
    {
        if ($this->issuedTickets->removeElement($issuedTicket)) {
            // set the owning side to null (unless already changed)
            if ($issuedTicket->getBooking() === $this) {
                $issuedTicket->setBooking(null);
            }
        }

        return $this;
    }

    public function getCart(): ?CartHistory
    {
        return $this->cart;
    }

    public function setCart(?CartHistory $cart): static
    {
        $this->cart = $cart;

        return $this;
    }
}
