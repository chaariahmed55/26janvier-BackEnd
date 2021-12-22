<?php

namespace App\Entity;

use App\Repository\PhotoRMRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PhotoRMRepository::class)
 * normalizationContext={"groups"={"photorm","retombemediatique"}},
 * denormalizationContext={"groups"={"photorm","retombemediatique"}}
 */
class PhotoRM
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"photorm","retombemediatique"})
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Groups({"photorm"})
     */
    private $data;

    /**
     * @ORM\ManyToOne(targetEntity=RetombeMediatique::class, inversedBy="photoRM")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"photorm"})
     */
    private $retombeMediatique;



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

    public function getRetombeMediatique(): ?RetombeMediatique
    {
        return $this->retombeMediatique;
    }

    public function setRetombeMediatique(?RetombeMediatique $retombeMediatique): self
    {
        $this->retombeMediatique = $retombeMediatique;

        return $this;
    }


}
