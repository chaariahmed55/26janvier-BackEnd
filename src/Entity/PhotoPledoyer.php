<?php

namespace App\Entity;

use App\Repository\PhotoPledoyerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PhotoPledoyerRepository::class)
 * normalizationContext={"groups"={"photopledoyer","pledoyer"}},
 * denormalizationContext={"groups"={"photopledoyer"}}
 */
class PhotoPledoyer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"photopledoyer","pledoyer"})
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Groups({"photopledoyer"})
     */
    private $data;

    /**
     * @ORM\ManyToOne(targetEntity=Pledoyer::class, inversedBy="photoPledoyers")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"photopledoyer"})
     */
    private $pledoyer;

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


    public function getPledoyer(): ?Pledoyer
    {
        return $this->pledoyer;
    }

    public function setPledoyer(?Pledoyer $pledoyer): self
    {
        $this->pledoyer = $pledoyer;

        return $this;
    }
}
