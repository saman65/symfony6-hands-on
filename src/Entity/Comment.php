<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
#[Broadcast]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank()] #After adding the use for Assert, this is added manually as a simple validation to check if it is not empty
    #[Assert\Length(min: 5, max: 255, minMessage: 'Title is too short. 5 characters minimum')]
    #[ORM\Column(length: 500)]
    private ?string $text = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?MicroPost $post = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function getPost(): ?MicroPost
    {
        return $this->post;
    }

    public function setPost(?MicroPost $post): static
    {
        $this->post = $post;

        return $this;
    }
}
