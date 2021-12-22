<?php

namespace App\Entity;

use App\Repository\OtherResouceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use DateTimeZone;


/**
 * @ORM\Entity(repositoryClass=OtherResouceRepository::class)
 * normalizationContext={"groups"={"user","otherresource","otherresource1"}},
 * denormalizationContext={"groups"={"user","otherresource","otherresource1"}}
 */
class OtherResouce
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"user","otherresource"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user","otherresource"})
     */
    private $link;

    /**
     * @ORM\Column(type="text")
     * @Groups({"otherresource1"})
     */
    private $data;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="otherResouces")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"user","otherresource"})
     */
    private $admin;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user","otherresource"})
     */
    private $titre;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user","otherresource"})
     */
    private $titrear;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user","otherresource"})
     */
    private $description;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user","otherresource"})
     */
    private $descriptionar;

    /**
     * @ORM\Column(type="date")
     * @Groups({"user","otherresource"})
     */
    private $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

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

    public function getAdmin(): ?User
    {
        return $this->admin;
    }

    public function setAdmin(?User $admin): self
    {
        $this->admin = $admin;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getTitrear(): ?string
    {
        return $this->titrear;
    }

    public function setTitrear(?string $titrear): self
    {
        $this->titrear = $titrear;

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
    public function getDescriptionar(): ?string
    {
        return $this->descriptionar;
    }

    public function setDescriptionar(?string $descriptionar): self
    {
        $this->descriptionar = $descriptionar;

        return $this;
    }


    public function getDate()
    {
        return $this->date->format("d/m/Y");
    }

    public function setDate($date): self
    {
        $this->date =  \DateTime::createFromFormat("Y-m-d",  $date,new DateTimeZone('Africa/Tunis'));
        return $this;
    }



}
