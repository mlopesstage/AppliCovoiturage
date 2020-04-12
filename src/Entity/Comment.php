<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(type="datetime")
     */
    private $dateComment;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $textComment;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Path", inversedBy="rideComment")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ride;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="authorComment")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateComment(): ?\DateTimeInterface
    {
        return $this->dateComment;
    }

    public function setDateComment(\DateTimeInterface $dateComment): self
    {
        $this->dateComment = $dateComment;

        return $this;
    }

    public function getTextComment(): ?string
    {
        return $this->textComment;
    }

    public function setTextComment(string $textComment): self
    {
        $this->textComment = $textComment;

        return $this;
    }

    public function getRide(): ?Path
    {
        return $this->ride;
    }

    public function setRide(?Path $ride): self
    {
        $this->ride = $ride;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }
}
