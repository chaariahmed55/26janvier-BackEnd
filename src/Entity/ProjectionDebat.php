<?php

namespace App\Entity;

use App\Repository\ProjectionDebatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use DateTimeZone;

/**
 * @ORM\Entity(repositoryClass=ProjectionDebatRepository::class)
 * normalizationContext={"groups"={"projectiondebat","photoprojectiondebat"}},
 * denormalizationContext={"groups"={"projectiondebat","photoprojectiondebat"}}
 */
class ProjectionDebat
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"projectiondebat","photoprojectiondebat"})
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     * @Groups({"projectiondebat"})
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"projectiondebat"})
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"projectiondebat"})
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=PhotoProjectionDebat::class, mappedBy="projectiondebat",orphanRemoval=true)
     * @Groups({"projectiondebat"})
     */
    private $photoProjectionDebats;


    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="projectionDebats")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"projectiondebat"})
     */
    private $admin;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"projectiondebat"})
     */
    private $source;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"projectiondebat"})
     */
    private $titlear;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"projectiondebat"})
     */
    private $descriptionar;

    public function __construct()
    {
        $this->photoProjectionDebats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

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

    /**
     * @return Collection|PhotoProjectionDebat[]
     */
    public function getPhotoProjectionDebats(): Collection
    {
        return $this->photoProjectionDebats;
    }

    public function addPhotoProjectionDebat(PhotoProjectionDebat $photoProjectionDebat): self
    {
        if (!$this->photoProjectionDebats->contains($photoProjectionDebat)) {
            $this->photoProjectionDebats[] = $photoProjectionDebat;
            $photoProjectionDebat->setProjectiondebat($this);
        }

        return $this;
    }

    public function removePhotoProjectionDebat(PhotoProjectionDebat $photoProjectionDebat): self
    {
        if ($this->photoProjectionDebats->removeElement($photoProjectionDebat)) {
            // set the owning side to null (unless already changed)
            if ($photoProjectionDebat->getProjectiondebat() === $this) {
                $photoProjectionDebat->setProjectiondebat(null);
            }
        }

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

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(string $source): self
    {
        $this->source = $source;

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
