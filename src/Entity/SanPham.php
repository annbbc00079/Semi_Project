<?php

namespace App\Entity;

use App\Repository\SanPhamRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SanPhamRepository::class)]
class SanPham
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 200)]
    private ?string $name = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo = null;

    #[ORM\ManyToOne(inversedBy: 'sanPhams')]
    private ?Category $cate = null;

    #[ORM\Column(length: 255)]
    private ?string $product_description = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getCate(): ?Category
    {
        return $this->cate;
    }

    public function setCate(?Category $cate): self
    {
        $this->cate = $cate;

        return $this;
    }

    public function getProductDescription(): ?string
    {
        return $this->product_description;
    }

    public function setProductDescription(string $product_description): self
    {
        $this->product_description = $product_description;

        return $this;
    }
}
