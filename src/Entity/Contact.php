<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ContactRepository::class)
 * normalizationContext={"groups"={"contact","user"}},
 * denormalizationContext={"groups"={"contact","user"}}
 */

class Contact
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"contact"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"contact"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"contact"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"contact"})
     */
    private $subject;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"contact"})
     */
    private $tel;

    /**
     * @ORM\Column(type="string", length=500)
     * @Groups({"contact"})
     */
    private $message;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="contacts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $admin;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"contact"})
     */
    private $vue;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"contact"})
     */
    private $moved;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(?string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getTel(): ?int
    {
        return $this->tel;
    }

    public function setTel(?int $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getAdmin(): ?User
    {
        return $this->admin;
    }

    public function setAdmin(?User $admin): self
    {
        $this->admin = $admin;

        return $this;
    }

    public function getVue(): ?bool
    {
        return $this->vue;
    }

    public function setVue(bool $vue): self
    {
        $this->vue = $vue;

        return $this;
    }

    public function getMoved(): ?bool
    {
        return $this->moved;
    }

    public function setMoved(bool $moved): self
    {
        $this->moved = $moved;

        return $this;
    }
}
