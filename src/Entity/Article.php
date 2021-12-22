<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use DateTimeZone;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 * normalizationContext={"groups"={"article","photoarticle"}},
 * denormalizationContext={"groups"={"article","photoarticle"}}
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"article","photoarticle"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"article"})
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"article"})
     */
    private $admin;

    /**
     * @Groups({"article"})
     * @ORM\OneToMany(targetEntity=PhotoArticle::class, mappedBy="article",orphanRemoval=true)
     */
    private $photoArticles;

    /**
     * @ORM\Column(type="date")
     * @Groups({"article"})
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=Presse::class, inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"article"})
     */
    private $autor;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"article"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"article"})
     */
    private $titlear;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"article"})
     */
    private $descriptionar;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"article"})
     */
    private $source;






    public function __construct()
    {
        $this->photoArticles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
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

    /**
     * @return Collection|PhotoArticle[]
     */
    public function getPhotoArticles(): Collection
    {
        return $this->photoArticles;
    }

    public function addPhotoArticle(PhotoArticle $photoArticle): self
    {
        if (!$this->photoArticles->contains($photoArticle)) {
            $this->photoArticles[] = $photoArticle;
            $photoArticle->setArticle($this);
        }

        return $this;
    }

    public function removePhotoArticle(PhotoArticle $photoArticle): self
    {
        if ($this->photoArticles->removeElement($photoArticle)) {
            // set the owning side to null (unless already changed)
            if ($photoArticle->getArticle() === $this) {
                $photoArticle->setArticle(null);
            }
        }

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

    public function getAutor(): ?Presse
    {
        return $this->autor;
    }

    public function setAutor(?Presse $autor): self
    {
        $this->autor = $autor;

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

    public function getTitlear(): ?string
    {
        return $this->titlear;
    }

    public function setTitlear(?string $titlear): self
    {
        $this->titlear = $titlear;

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

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(?string $source): self
    {
        $this->source = $source;

        return $this;
    }







}
