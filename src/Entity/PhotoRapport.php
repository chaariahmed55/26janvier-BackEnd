<?php

namespace App\Entity;

use App\Repository\PhotoRapportRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass=PhotoRapportRepository::class)
 * normalizationContext={"groups"={"photorapport","rapport"}},
 * denormalizationContext={"groups"={"photorapport","rapport"}}
 */
class PhotoRapport
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"photorapport","rapport"})
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"photorapport"})
     */
    private $data;

    /**
     * @ORM\ManyToOne(targetEntity=Rapport::class, inversedBy="photoRapports")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"photorapport"})
     */
    private $rapport;

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

    public function getRapport(): ?Rapport
    {
        return $this->rapport;
    }

    public function setRapport(?Rapport $rapport): self
    {
        $this->rapport = $rapport;

        return $this;
    }
}
