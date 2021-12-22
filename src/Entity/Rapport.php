<?php

namespace App\Entity;

use App\Repository\RapportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use DateTimeZone;

/**
 * @ORM\Entity(repositoryClass=RapportRepository::class)
 * denormalizationContext={"groups"={"rapport","photorapport"}}
 */
class Rapport
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"rapport","photorapport"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"rapport"})
     */
    private $source;


    /**
     * @Groups({"rapport"})
     * @ORM\OneToMany(targetEntity=PhotoRapport::class, mappedBy="rapport", orphanRemoval=true)
     */
    private $photoRapports;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"rapport"})
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"rapport"})
     */
    private $description;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"rapport"})
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"rapport"})
     */
    private $titrear;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"rapport"})
     */
    private $descriptionar;

    public function __construct()
    {
        $this->photoRapports = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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


    /**
     * @return Collection|PhotoRapport[]
     */
    public function getPhotoRapports(): Collection
    {
        return $this->photoRapports;
    }

    public function addPhotoRapport(PhotoRapport $photoRapport): self
    {
        if (!$this->photoRapports->contains($photoRapport)) {
            $this->photoRapports[] = $photoRapport;
            $photoRapport->setRapport($this);
        }

        return $this;
    }

    public function removePhotoRapport(PhotoRapport $photoRapport): self
    {
        if ($this->photoRapports->removeElement($photoRapport)) {
            // set the owning side to null (unless already changed)
            if ($photoRapport->getRapport() === $this) {
                $photoRapport->setRapport(null);
            }
        }

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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
