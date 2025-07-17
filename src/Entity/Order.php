<?php
namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: 'orders')]  // Define the table name

class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Users::class, inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Users $user = null;

    #[ORM\Column(type: 'json')]
    private array $items = [];

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    #[Assert\NotBlank]
    private ?float $subtotal = null;

    #[Assert\NotBlank]
    private ?float $status = null;

    #[Assert\NotBlank]
    private ?float $date_validation = null;


    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    #[Assert\NotBlank]
    private ?float $total = null;

    #[ORM\Column(type: 'json')]
    #[Assert\NotBlank]
    private array $customer = [];

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $createdAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getCustomer(): array
    {
        return $this->customer;
    }

    public function setCustomer(array $customer): void
    {
        $this->customer = $customer;
    }




    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): void
    {
        $this->user = $user;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function setItems(array $items): void
    {
        $this->items = $items;
    }

    public function getSubtotal(): ?float
    {
        return $this->subtotal;
    }

    public function setSubtotal(?float $subtotal): void
    {
        $this->subtotal = $subtotal;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(?float $total): void
    {
        $this->total = $total;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getStatus(): ?float
    {
        return $this->status;
    }

    public function setStatus(?float $status): void
    {
        $this->status = $status;
    }

    public function getDateValidation(): ?float
    {
        return $this->date_validation;
    }

    public function setDateValidation(?float $date_validation): void
    {
        $this->date_validation = $date_validation;
    }

}