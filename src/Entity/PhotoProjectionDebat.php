<?php

namespace App\Entity;

use App\Repository\PhotoProjectionDebatRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PhotoProjectionDebatRepository::class)
 * normalizationContext={"groups"={"photoprojectiondebat","projectiondebat"}},
 * denormalizationContext={"groups"={"photoprojectiondebat","projectiondebat"}}
 */
class PhotoProjectionDebat
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"photoprojectiondebat","projectiondebat"})
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Groups({"photoprojectiondebat"})
     */
    private $data;

    /**
     * @ORM\ManyToOne(targetEntity=ProjectionDebat::class, inversedBy="photoProjectionDebats")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"photoprojectiondebat"})
     */
    private $projectiondebat;

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

    public function getProjectiondebat(): ?ProjectionDebat
    {
        return $this->projectiondebat;
    }

    public function setProjectiondebat(?ProjectionDebat $projectiondebat): self
    {
        $this->projectiondebat = $projectiondebat;

        return $this;
    }
}
