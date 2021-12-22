<?php

namespace App\Entity;

use App\Repository\PhotoArticleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PhotoArticleRepository::class)
 * normalizationContext={"groups"={"photorticle","article"}},
 * denormalizationContext={"groups"={"photoarticle","article"}}
 */
class PhotoArticle
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"photoarticle","article"})
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Groups({"photoarticle"})
     */
    private $data;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="photoArticles")
     * @Groups({"photoarticle"})
     */
    private $article;

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

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }
}
