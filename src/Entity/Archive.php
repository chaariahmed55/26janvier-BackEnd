<?php

namespace App\Entity;

use App\Repository\ArchiveRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass=ArchiveRepository::class)
 * normalizationContext={"groups"={"archive"}},
 * denormalizationContext={"groups"={"archive"}}
 */
class Archive
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"archive"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="archives")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"archive"})
     */
    private $admin;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"archive"})
     */
    private $data;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdmin(): ?User
    {
        return $this->admin;
    }

    public function setAdmin(?User $admin): self
    {
        $this->admin = $admin;

        return $this;
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

    

    

    

    

    

    
}
