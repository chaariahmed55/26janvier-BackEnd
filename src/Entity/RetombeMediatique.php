<?php

namespace App\Entity;

use App\Repository\RetombeMediatiqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use DateTimeZone;
/**
 * @ORM\Entity(repositoryClass=RetombeMediatiqueRepository::class)
 * normalizationContext={"groups"={"retombemediatique","photorm","videorm"}},
 * denormalizationContext={"groups"={"retombemediatique","photorm","videorm"}}
 */
class RetombeMediatique
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"retombemediatique","photorm","videorm"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"retombemediatique","photorm","videorm"})
     */
    private $legende;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"retombemediatique","photorm","videorm"})
     */
    private $title;

    /**
     * @ORM\Column(type="date")
     * @Groups({"retombemediatique","photorm","videorm"})
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"retombemediatique","photorm","videorm"})
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="retombeMediatiques")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"retombemediatique"})
     */
    private $admin;

    /**
     * @ORM\OneToMany(targetEntity=PhotoRM::class, mappedBy="retombeMediatique", orphanRemoval=true)
     * @Groups({"retombemediatique"})
     */
    private $photoRM;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"retombemediatique"})
     */
    private $source;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"retombemediatique"})
     */
    private $legendear;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"retombemediatique"})
     */
    private $titlear;

    public function __construct()
    {
        $this->photoRM = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLegende(): ?string
    {
        return $this->legende;
    }

    public function setLegende(?string $legende): self
    {
        $this->legende = $legende;

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

    public function getDate()
    {
        return $this->date->format("d/m/Y");
    }

    public function setDate( $date): self
    {
        $this->date =  \DateTime::createFromFormat("Y-m-d",  $date,new DateTimeZone('Africa/Tunis'));
        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(?string $author): self
    {
        $this->author = $author;

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

    /**
     * @return Collection|PhotoRM[]
     */
    public function getPhotoRMs(): Collection
    {
        return $this->photoRMs;
    }

    /**
     * @return Collection|PhotoRM[]
     */
    public function getPhotoRM(): Collection
    {
        return $this->photoRM;
    }

    public function addPhotoRM(PhotoRM $photoRM): self
    {
        if (!$this->photoRM->contains($photoRM)) {
            $this->photoRM[] = $photoRM;
            $photoRM->setRetombeMediatique($this);
        }

        return $this;
    }

    public function removePhotoRM(PhotoRM $photoRM): self
    {
        if ($this->photoRM->removeElement($photoRM)) {
            // set the owning side to null (unless already changed)
            if ($photoRM->getRetombeMediatique() === $this) {
                $photoRM->setRetombeMediatique(null);
            }
        }

        return $this;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(?string $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function getLegendear(): ?string
    {
        return $this->legendear;
    }

    public function setLegendear(?string $legendear): self
    {
        $this->legendear = $legendear;

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

}
