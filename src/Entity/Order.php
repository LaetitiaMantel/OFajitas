<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Table(name: "`order`")]
#[ORM\Entity(repositoryClass: OrderRepository::class)]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'order', targetEntity: LigneOrder::class, cascade: ['persist'])]
    private Collection $LigneOrder;

    #[ORM\Column(length: 20)]
    private ?string $Ref = null;

    #[Assert\NotBlank()]
    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $addressComplement = null;

    #[Assert\NotBlank()]
    #[Assert\Length(
        min: 5,
        max: 10,
        minMessage: "Le mot de passe doit contenir au moins 5 caractères.",
    )]
    #[ORM\Column]
    private ?int $zipCode = null;

    #[Assert\NotBlank()]
    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[Assert\Length(
            max: 10,
            maxMessage: "Le numéro de téléphone doit contenir maximum 10 chiffres."
    )]
    #[Assert\Regex(
        pattern: "/^\d{9}$/",
        message: "Le numéro de téléphone doit contenir exactement 10 chiffres."
    )]
     #[ORM\Column(nullable: true)]
    private ?int $phoneNumber = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $billingAddress = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $billingAddressComplement = null;

    #[ORM\Column(nullable: true)]
    private ?int $billingZipCode = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $billingCity = null;

    public function __construct()
    {
        $this->LigneOrder = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, LigneOrder>
     */
    public function getLigneOrder(): Collection
    {
        return $this->LigneOrder;
    }

    public function addLigneOrder(LigneOrder $ligneOrder): static
    {
        if (!$this->LigneOrder->contains($ligneOrder)) {
            $this->LigneOrder->add($ligneOrder);
            $ligneOrder->setOrder($this);
        }

        return $this;
    }

    public function getRef(): ?string
    {
        return $this->Ref;
    }

    public function setRef(string  $Ref): static
    {
        $this->Ref = $Ref;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getAddressComplement(): ?string
    {
        return $this->addressComplement;
    }

    public function setAddressComplement(?string $addressComplement): static
    {
        $this->addressComplement = $addressComplement;

        return $this;
    }

    public function getZipCode(): ?int
    {
        return $this->zipCode;
    }

    public function setZipCode(int $zipCode): static
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getPhoneNumber(): ?int
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?int $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getBillingAddress(): ?string
    {
        return $this->billingAddress;
    }

    public function setBillingAddress(?string $billingAddress): static
    {
        $this->billingAddress = $billingAddress;

        return $this;
    }

    public function getBillingAddressComplement(): ?string
    {
        return $this->billingAddressComplement;
    }

    public function setBillingAddressComplement(?string $billingAddressComplement): static
    {
        $this->billingAddressComplement = $billingAddressComplement;

        return $this;
    }

    public function getBillingZipCode(): ?int
    {
        return $this->billingZipCode;
    }

    public function setBillingZipCode(?int $billingZipCode): static
    {
        $this->billingZipCode = $billingZipCode;

        return $this;
    }

    public function getBillingCity(): ?string
    {
        return $this->billingCity;
    }

    public function setBillingCity(?string $billingCity): static
    {
        $this->billingCity = $billingCity;

        return $this;
    }
}
