<?php

namespace App\Entity;

use App\Repository\ProgrammeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use DateTimeZone;

/**
 * @ORM\Entity(repositoryClass=ProgrammeRepository::class)
 * normalizationContext={"groups"={"programme","photoprogramme"}},
 * denormalizationContext={"groups"={"programme","photoprogramme"}}
 */
class Programme
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"programme"})
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     * @Groups({"programme"})
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"programme"})
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"programme"})
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"programme"})
     */
    private $categorie;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"programme"})
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="programmes")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"programme"})
     */
    private $admin;

    /**
     * @ORM\Column(type="text")
     * @Groups({"photoprogramme"})
     */
    private $data;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"programme"})
     */
    private $adressear;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"programme"})
     */
    private $titlear;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"programme"})
     */
    private $descriptionar;


    public function getId(): ?int
    {
        return $this->id;
    }


    public function getDate()
    {
        return $this->date->format("d/m/Y");
    }

    public function setDate( $date): self
    {
        $this->date =  \DateTime::createFromFormat("Y-m-d",  $date,new DateTimeZone('Africa/Tunis'));
        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(?string $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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


    public function getData(): ?string
    {
        return $this->data;
    }

    public function setData(string $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getAdressear(): ?string
    {
        return $this->adressear;
    }

    public function setAdressear(?string $adressear): self
    {
        $this->adressear = $adressear;

        return $this;
    }

    public function getTitlear(): ?string
    {
        return $this->titlear;
    }

    public function setTitlear(?string $titlear): self
    {
        $this->titlear = $titlear;

        return $this;
    }

    public function getDescriptionar(): ?string
    {
        return $this->descriptionar;
    }

    public function setDescriptionar(?string $descriptionar): self
    {
        $this->descriptionar = $descriptionar;

        return $this;
    }
}
