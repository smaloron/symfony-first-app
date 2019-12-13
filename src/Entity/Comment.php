<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
Use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 */
class Comment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="L'auteur ne peut être vide")
     * @Assert\Email(message="Vous devez saisir un email pour l'auteur")
     * @ORM\Column(type="string", length=50)
     */
    private $author;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @Assert\Length(max="500", min="20",
     *     minMessage="Votre message doit comporter au moins {{ limit }} caractères",
     *     maxMessage="Votre message ne peut comporter plus de {{ limit }} caractères")
     * @ORM\Column(type="text")
     */
    private $commentText;

    /**
     * @ORM\ManyToOne(targetEntity="Article", inversedBy="comments")
     * @var Article
     */
    private $article;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCommentText(): ?string
    {
        return $this->commentText;
    }

    public function setCommentText(string $commentText): self
    {
        $this->commentText = $commentText;

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
