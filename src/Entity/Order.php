<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(length: 128)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column]
    private ?int $deliveryZipCode = null;

    #[ORM\Column(length: 255)]
    private ?string $deliveryAdress = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $deliveryAdressSupplement = null;

    #[ORM\Column(length: 45)]
    private ?string $deliveryCity = null;

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getDeliveryZipCode(): ?int
    {
        return $this->deliveryZipCode;
    }

    public function setDeliveryZipCode(int $deliveryZipCode): static
    {
        $this->deliveryZipCode = $deliveryZipCode;

        return $this;
    }

    public function getDeliveryAdress(): ?string
    {
        return $this->deliveryAdress;
    }

    public function setDeliveryAdress(string $deliveryAdress): static
    {
        $this->deliveryAdress = $deliveryAdress;

        return $this;
    }

    public function getDeliveryAdressSupplement(): ?string
    {
        return $this->deliveryAdressSupplement;
    }

    public function setDeliveryAdressSupplement(?string $deliveryAdressSupplement): static
    {
        $this->deliveryAdressSupplement = $deliveryAdressSupplement;

        return $this;
    }

    public function getDeliveryCity(): ?string
    {
        return $this->deliveryCity;
    }

    public function setDeliveryCity(string $deliveryCity): static
    {
        $this->deliveryCity = $deliveryCity;

        return $this;
    }
}
