<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

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
}
