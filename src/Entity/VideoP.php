<?php

namespace App\Entity;

use App\Repository\VideoPRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use DateTimeZone;
/**
 * @ORM\Entity(repositoryClass=VideoPRepository::class)
 * normalizationContext={"groups"={"videop"}},
 * denormalizationContext={"groups"={"videop"}}
 */
class VideoP
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"videop"})
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     * @Groups({"videop"})
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"videop"})
     */
    private $path;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"videop"})
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Programme::class, inversedBy="videoPs")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"videop"})
     */
    private $programme;

    /**
     * @ORM\OneToMany(targetEntity=ForumVideoP::class, mappedBy="videoprogramme")
     */
    private $forumVideoPs;

    public function __construct()
    {
        $this->forumVideoPs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate()
    {
        return $this->date->format("d/m/Y");
    }

    public function setDate( $date): self
    {
        $this->date =  \DateTime::createFromFormat("d/m/Y",  $date,new DateTimeZone('Africa/Tunis'));
        return $this;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getProgramme(): ?Programme
    {
        return $this->programme;
    }

    public function setProgramme(?Programme $programme): self
    {
        $this->programme = $programme;

        return $this;
    }

    /**
     * @return Collection|ForumVideoP[]
     */
    public function getForumVideoPs(): Collection
    {
        return $this->forumVideoPs;
    }

    public function addForumVideoP(ForumVideoP $forumVideoP): self
    {
        if (!$this->forumVideoPs->contains($forumVideoP)) {
            $this->forumVideoPs[] = $forumVideoP;
            $forumVideoP->setVideoprogramme($this);
        }

        return $this;
    }

    public function removeForumVideoP(ForumVideoP $forumVideoP): self
    {
        if ($this->forumVideoPs->removeElement($forumVideoP)) {
            // set the owning side to null (unless already changed)
            if ($forumVideoP->getVideoprogramme() === $this) {
                $forumVideoP->setVideoprogramme(null);
            }
        }

        return $this;
    }
}
