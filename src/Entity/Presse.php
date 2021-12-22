<?php

namespace App\Entity;

use App\Repository\PresseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PresseRepository::class)
 * normalizationContext={"groups"={"presse","article"}},
 * denormalizationContext={"groups"={"presse","article"}}
 */
class Presse
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"presse","article"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"presse","article"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"presse","article"})
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="autor")
     *
     */
    private $articles;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setAutor($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getAutor() === $this) {
                $article->setAutor(null);
            }
        }

        return $this;
    }
}
