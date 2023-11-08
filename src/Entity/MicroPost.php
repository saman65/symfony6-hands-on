<?php

namespace App\Entity;

use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MicroPostRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
# how do you say to symphony, what validation constraints do you need? So this is actually pretty simple.
#There are some PHP eight attributes that you can add on your class fields to tell the validator component 
#how a specific field should be validated. We first add the use below:
use Symfony\Component\Validator\Constraints as Assert;
#The validation constraints are classes that you use as PHP eight attributes and you add them on top of the fields in objects that need to be validated.

#[ORM\Entity(repositoryClass: MicroPostRepository::class)]
class MicroPost
{
    public const EDIT = 'POST_EDIT'; //cut and pasted from MicroPostVoter
    public const VIEW = 'POST_VIEW'; //cut and pasted from MicroPostVoter
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank()] #After adding the use for Assert, this is added manually as a simple validation to check if it is not empty
    #[Assert\Length(min: 5, max: 255, minMessage: 'Title is too short. 5 characters minimum')]
    #[ORM\Column(length: 255)]

    private ?string $title = null;

    #[Assert\NotBlank()] #After adding the use for Assert, this is added as a simple validation to check if it is not empty
    #[Assert\Length(min: 5, max: 255, minMessage: 'Title is too short. 5 characters minimum')]
    #[ORM\Column(length: 500)]

    private ?string $text = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created = null;

    #[ORM\OneToMany(mappedBy: 'post', targetEntity: Comment::class, orphanRemoval: true, /*fetch: 'EAGER',*//*, cascade: ['persist']*/)]
    /* cascade: ['persist'] was added manually as an argument because there would be an error if we try to save 
    post and comment at the same time. But in reallity the posts are always made before comments so we dont need cascading here.
    But in OneByOne relation the cascade: ['persist', 'remove'] was added automatically for User entity*/
    /* orphan removal property is true means every time the post would be deleted, 
    all the comments would be gone together with the post. */
    /* We can add fetch: 'EAGER' as an argument to the ORM\OneToMany attribute to load comments using dd($post) otherwise it is by default LAZY*/
    private Collection $comments;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'liked')]
    private Collection $likedBy;

    #[ORM\ManyToOne(inversedBy: 'posts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $author = null;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->likedBy = new ArrayCollection();
        $this->created =new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setPost($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getPost() === $this) {
                $comment->setPost(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getLikedBy(): Collection
    {
        return $this->likedBy;
    }

    public function addLikeBy(User $likedBy): static
    {
        if (!$this->likedBy->contains($likedBy)) {
            $this->likedBy->add($likedBy);
        }

        return $this;
    }

    public function removeLikeBy(User $likedBy): static
    {
        $this->likedBy->removeElement($likedBy);

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): static
    {
        $this->author = $author;

        return $this;
    }
}
