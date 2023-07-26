<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $contact_name = null;

    #[ORM\Column(length: 255)]
    private ?string $contact_email = null;

    #[ORM\Column(length: 255)]
    private ?string $contact_title = null;

    #[ORM\Column(length: 255)]
    private ?string $contact_message = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContactName(): ?string
    {
        return $this->contact_name;
    }

    public function setContactName(string $contact_name): self
    {
        $this->contact_name = $contact_name;

        return $this;
    }

    public function getContactEmail(): ?string
    {
        return $this->contact_email;
    }

    public function setContactEmail(string $contact_email): self
    {
        $this->contact_email = $contact_email;

        return $this;
    }

    public function getContactTitle(): ?string
    {
        return $this->contact_title;
    }

    public function setContactTitle(string $contact_title): self
    {
        $this->contact_title = $contact_title;

        return $this;
    }

    public function getContactMessage(): ?string
    {
        return $this->contact_message;
    }

    public function setContactMessage(string $contact_message): self
    {
        $this->contact_message = $contact_message;

        return $this;
    }
}
