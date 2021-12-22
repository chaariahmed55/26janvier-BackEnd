<?php

namespace App\Entity;

use App\Repository\PhotoTemoignageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PhotoTemoignageRepository::class)
 * normalizationContext={"groups"={"phototemoignage","temoignage"}},
 * denormalizationContext={"groups"={"phototemoignage","temoignage"}}
 */
class PhotoTemoignage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"phototemoignage","temoignage"})
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Groups({"phototemoignage"})
     */
    private $data;

    /**
     * @ORM\ManyToOne(targetEntity=Temoignage::class, inversedBy="photoTemoignages")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"phototemoignage"})
     */
    private $temoignage;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getData(): ?string
    {
        return $this->data;
    }

    public function setData(?string $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getTemoignage(): ?Temoignage
    {
        return $this->temoignage;
    }

    public function setTemoignage(?Temoignage $temoignage): self
    {
        $this->temoignage = $temoignage;

        return $this;
    }
}
