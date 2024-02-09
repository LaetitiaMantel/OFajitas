<?php

namespace App\Entity;

use App\Repository\CartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CartRepository::class)]
class Cart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\OneToMany(mappedBy: 'cart_id', targetEntity: Product::class)]
    private Collection $ProductId;

    #[ORM\OneToOne(inversedBy: 'cartId', cascade: ['persist', 'remove'])]
    private ?User $userId = null;

    public function __construct()
    {
        $this->ProductId = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProductId(): Collection
    {
        return $this->ProductId;
    }

    public function addProductId(Product $productId): static
    {
        if (!$this->ProductId->contains($productId)) {
            $this->ProductId->add($productId);
            $productId->setCartId($this);
        }

        return $this;
    }

    public function removeProductId(Product $productId): static
    {
        if ($this->ProductId->removeElement($productId)) {
            // set the owning side to null (unless already changed)
            if ($productId->getCartId() === $this) {
                $productId->setCartId(null);
            }
        }

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->userId;
    }

    public function setUserId(?User $userId): static
    {
        $this->userId = $userId;

        return $this;
    }

    
}


