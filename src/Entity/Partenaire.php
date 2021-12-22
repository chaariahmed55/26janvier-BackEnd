<?php

namespace App\Entity;

use App\Repository\PartenaireRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PartenaireRepository::class)
 * normalizationContext={"groups"={"partenaire"}},
 * denormalizationContext={"groups"={"partenaire"}}
 */
class Partenaire
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"partenaire"})
     */
    private $id;



    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"partenaire"})
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="partenaires")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"partenaire"})
     */
    private $admin;

    /**
     * @ORM\Column(type="text")
     * @Groups({"partenaire"})
     */
    private $logo;


    public function getId(): ?int
    {
        return $this->id;
    }


    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }
}
