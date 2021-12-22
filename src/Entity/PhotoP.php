<?php

namespace App\Entity;

use App\Repository\PhotoPRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use DateTimeZone;
/**
 * @ORM\Entity(repositoryClass=PhotoPRepository::class)
 * normalizationContext={"groups"={"photop"}},
 * denormalizationContext={"groups"={"photop"}}
 */
class PhotoP
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"photop"})
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     * @Groups({"photop"})
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"photop"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"photop"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"photop"})
     */
    private $data;

    /**
     * @ORM\ManyToOne(targetEntity=Programme::class, inversedBy="photoPs")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"photop"})
     */
    private $programme;

    /**
     * @ORM\OneToMany(targetEntity=ForumPhotoP::class, mappedBy="photop")
     */
    private $forumPhotoPs;

    public function __construct()
    {
        $this->forumPhotoPs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate()
    {
        return $this->date->format("Y-m-d");
    }

    public function setDate( $date): self
    {
        $this->date =  \DateTime::createFromFormat("d/m/Y",  $date,new DateTimeZone('Africa/Tunis'));
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
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
     * @return Collection|ForumPhotoP[]
     */
    public function getForumPhotoPs(): Collection
    {
        return $this->forumPhotoPs;
    }

    public function addForumPhotoP(ForumPhotoP $forumPhotoP): self
    {
        if (!$this->forumPhotoPs->contains($forumPhotoP)) {
            $this->forumPhotoPs[] = $forumPhotoP;
            $forumPhotoP->setPhotop($this);
        }

        return $this;
    }

    public function removeForumPhotoP(ForumPhotoP $forumPhotoP): self
    {
        if ($this->forumPhotoPs->removeElement($forumPhotoP)) {
            // set the owning side to null (unless already changed)
            if ($forumPhotoP->getPhotop() === $this) {
                $forumPhotoP->setPhotop(null);
            }
        }

        return $this;
    }
}
