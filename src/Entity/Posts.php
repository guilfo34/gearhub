<?php

namespace App\Entity;

use App\Repository\PostsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: PostsRepository::class)]
class Posts
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['posts.index'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['posts.index'])]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 1000, nullable: true)]
    #[Groups(['posts.index'])]
    private ?string $text = null;

    #[ORM\Column(length: 500, nullable: true)]
    #[Groups(['posts.index'])]
    private ?string $image = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['posts.index'])]
    private ?int $vote = null;

    #[ORM\ManyToOne(inversedBy: 'posts')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['posts.index'])]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'posts')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['posts.index'])]
    private ?Cars $car = null;

    #[ORM\Column]
    private ?bool $published = null;

    #[ORM\Column]
    private ?bool $moderated = null;

    #[ORM\Column]
    private ?bool $signaled = null;

    public function __construct()
    {
        $this->date = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }



    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getVote(): ?int
    {
        return $this->vote;
    }

    public function setVote(int $vote): static
    {
        $this->vote = $vote;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getCar(): ?Cars
    {
        return $this->car;
    }

    public function setCar(?Cars $car): static
    {
        $this->car = $car;

        return $this;
    }

    public function isPublished(): ?bool
    {
        return $this->published;
    }

    public function setPublished(bool $published): static
    {
        $this->published = $published;

        return $this;
    }

    public function isModerated(): ?bool
    {
        return $this->moderated;
    }

    public function setModerated(bool $moderated): static
    {
        $this->moderated = $moderated;

        return $this;
    }

    public function isSignaled(): ?bool
    {
        return $this->signaled;
    }

    public function setSignaled(bool $signaled): static
    {
        $this->signaled = $signaled;

        return $this;
    }
}
