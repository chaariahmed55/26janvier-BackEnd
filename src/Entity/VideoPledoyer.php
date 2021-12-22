<?php

namespace App\Entity;

use App\Repository\VideoPledoyerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use DateTimeZone;


/**
 * @ORM\Entity(repositoryClass=VideoPledoyerRepository::class)
 * ormalizationContext={"groups"={"videopledoyer","videopledoyer1"}},
 * denormalizationContext={"groups"={"videopledoyer","videopledoyer1"}}
 */
class VideoPledoyer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"videopledoyer"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"videopledoyer"})
     */
    private $path;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"videopledoyer"})
     */
    private $titre;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"videopledoyer"})
     */
    private $date;
    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"videopledoyer1"})
     */
    private $photo;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *  @Groups({"videopledoyer"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"videopledoyer"})
     */
    private $titrear;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"videopledoyer"})
     */
    private $descriptionar;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

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
    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

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
