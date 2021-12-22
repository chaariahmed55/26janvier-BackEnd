<?php

namespace App\Entity;

use App\Repository\PledoyerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use DateTimeZone;

/**
 * @ORM\Entity(repositoryClass=PledoyerRepository::class)
 * normalizationContext={"groups"={"pledoyer","photopledoyer"}},
 * denormalizationContext={"groups"={"pledoyer","photopledoyer"}}
 * use DateTimeZone;
 */
class Pledoyer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"pledoyer","photopledoyer"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="pledoyers")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"pledoyer"})
     */
    private $admin;

    /**
     * @ORM\OneToMany(targetEntity=PhotoPledoyer::class, mappedBy="pledoyer",orphanRemoval=true)
     * @Groups({"pledoyer"})
     */
    private $photoPledoyers;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"pledoyer"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"pledoyer"})
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"pledoyer"})
     */
    private $source;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"pledoyer"})
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"pledoyer"})
     */
    private $descriptionar;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"pledoyer"})
     */
    private $titrear;

    public function __construct()
    {
        $this->photoPledoyers = new ArrayCollection();
        $this->videoPledoyers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection|PhotoPledoyer[]
     */
    public function getPhotoPledoyers(): Collection
    {
        return $this->photoPledoyers;
    }

    public function addPhotoPledoyer(PhotoPledoyer $photoPledoyer): self
    {
        if (!$this->photoPledoyers->contains($photoPledoyer)) {
            $this->photoPledoyers[] = $photoPledoyer;
            $photoPledoyer->setPledoyer($this);
        }

        return $this;
    }

    public function removePhotoPledoyer(PhotoPledoyer $photoPledoyer): self
    {
        if ($this->photoPledoyers->removeElement($photoPledoyer)) {
            // set the owning side to null (unless already changed)
            if ($photoPledoyer->getPledoyer() === $this) {
                $photoPledoyer->setPledoyer(null);
            }
        }

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

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): self
    {
        $this->titre = $titre;

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

    public function getDate()
    {
        return $this->date->format("d/m/Y");
    }

    public function setDate($date): self
    {
        $this->date =  \DateTime::createFromFormat("Y-m-d",  $date,new DateTimeZone('Africa/Tunis'));
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

    public function getTitrear(): ?string
    {
        return $this->titrear;
    }

    public function setTitrear(?string $titrear): self
    {
        $this->titrear = $titrear;

        return $this;
    }
}
