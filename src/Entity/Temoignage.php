<?php

namespace App\Entity;

use App\Repository\TemoignageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use DateTimeZone;
/**
 * @ORM\Entity(repositoryClass=TemoignageRepository::class)
 * normalizationContext={"groups"={"temoignage","phototemoignage","videotemoignage"}},
 * denormalizationContext={"groups"={"temoignage","phototemoignage","videotemoignage"}}
 */
class Temoignage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"temoignage","phototemoignage","videotemoignage"})
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     * @Groups({"temoignage","phototemoignage","videotemoignage"})
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"temoignage","phototemoignage","videotemoignage"})
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"temoignage","phototemoignage","videotemoignage"})
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=PhotoTemoignage::class, mappedBy="temoignage", orphanRemoval=true)
     * @Groups({"temoignage"})
     */
    private $photoTemoignages;


    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="temoignages")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"temoignage"})
     */
    private $admin;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"temoignage"})
     */
    private $source;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"temoignage"})
     */
    private $titrear;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"temoignage"})
     */
    private $descriptionar;

    public function __construct()
    {
        $this->photoTemoignages = new ArrayCollection();
        $this->videoTemoignages = new ArrayCollection();
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

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

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
     * @return Collection|PhotoTemoignage[]
     */
    public function getPhotoTemoignages(): Collection
    {
        return $this->photoTemoignages;
    }

    public function addPhotoTemoignage(PhotoTemoignage $photoTemoignage): self
    {
        if (!$this->photoTemoignages->contains($photoTemoignage)) {
            $this->photoTemoignages[] = $photoTemoignage;
            $photoTemoignage->setTemoignage($this);
        }

        return $this;
    }

    public function removePhotoTemoignage(PhotoTemoignage $photoTemoignage): self
    {
        if ($this->photoTemoignages->removeElement($photoTemoignage)) {
            // set the owning side to null (unless already changed)
            if ($photoTemoignage->getTemoignage() === $this) {
                $photoTemoignage->setTemoignage(null);
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

    public function setSource(?string $source): self
    {
        $this->source = $source;

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
