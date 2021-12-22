<?php

namespace App\Entity;

use App\Repository\PhotoArchiveRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use DateTimeZone;


/**
 * @ORM\Entity(repositoryClass=PhotoArchiveRepository::class)
 * normalizationContext={"groups"={"photoarchive","photoarchive1"}},
 * denormalizationContext={"groups"={"photoarchive",photoarchive1}}
 */
class PhotoArchive
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"photoarchive"})
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Groups({"photoarchive1"})
     */
    private $data;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"photoarchive"})
     */

    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"photoarchive"})
     */
    private $name;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"photoarchive"})
     */
    private $namear;

    /**
     * @ORM\Column(type="date")
     * @Groups({"photoarchive"})
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"photoarchive"})
     */
    private $source;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"photoarchive"})
     */
    private $descriptionar;




    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }
    public function getNamear(): ?string
    {
        return $this->namear;
    }

    public function setNamear(?string $namear): self
    {
        $this->namear = $namear;

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

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(?string $source): self
    {
        $this->source = $source;

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
