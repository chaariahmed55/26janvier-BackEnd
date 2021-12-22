<?php

namespace App\Entity;

use App\Repository\BrochureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use DateTimeZone;


/**
 * @ORM\Entity(repositoryClass=BrochureRepository::class)
 * denormalizationContext={"groups"={"brochure","photobrochure"}}
 */
class Brochure
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"brochure","photobrochure"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"brochure"})
     */
    private $source;


    /**
     * @ORM\OneToMany(targetEntity=PhotoBrochure::class, mappedBy="brochure", orphanRemoval=true)
     * @Groups({"brochure"})
     */
    private $photoBrochures;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"brochure"})
     */
    private $titre;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"brochure"})
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"brochure"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"brochure"})
     */
    private $titrear;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"brochure"})
     */
    private $descriptionar;

    public function __construct()
    {
        $this->photoBrochures = new ArrayCollection();
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
     * @return Collection|PhotoBrochure[]
     */
    public function getPhotoBrochures(): Collection
    {
        return $this->photoBrochures;
    }

    public function addPhotoBrochure(PhotoBrochure $photoBrochure): self
    {
        if (!$this->photoBrochures->contains($photoBrochure)) {
            $this->photoBrochures[] = $photoBrochure;
            $photoBrochure->setBrochure($this);
        }

        return $this;
    }

    public function removePhotoBrochure(PhotoBrochure $photoBrochure): self
    {
        if ($this->photoBrochures->removeElement($photoBrochure)) {
            // set the owning side to null (unless already changed)
            if ($photoBrochure->getBrochure() === $this) {
                $photoBrochure->setBrochure(null);
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

    public function getDate()
    {
        return $this->date->format("d/m/Y");
    }

    public function setDate($date): self
    {
        $this->date =  \DateTime::createFromFormat("Y-m-d",  $date,new DateTimeZone('Africa/Tunis'));
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
