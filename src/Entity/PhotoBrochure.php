<?php

namespace App\Entity;

use App\Repository\PhotoBrochureRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass=PhotoBrochureRepository::class)
 * normalizationContext={"groups"={"photobrochure","brochure"}},
 * denormalizationContext={"groups"={"photobrochure","brochure"}}
 */
class PhotoBrochure
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"photobrochure","brochure"})
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"photobrochure"})
     */
    private $data;

    /**
     * @ORM\ManyToOne(targetEntity=Brochure::class, inversedBy="photoBrochures")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"photobrochure"})
     */
    private $brochure;

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

    public function getBrochure(): ?Brochure
    {
        return $this->brochure;
    }

    public function setBrochure(?Brochure $brochure): self
    {
        $this->brochure = $brochure;

        return $this;
    }
}
