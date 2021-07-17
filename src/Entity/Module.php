<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ModuleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotNull;

/**
 * @ORM\Entity(repositoryClass=ModuleRepository::class)
 */
#[
    ApiResource(
        collectionOperations: [
        'GET' => [
            'normalization_context' => ['groups' => ['Modules:read']],
            'openapi_context' => ['security' => [['bearerAuth' => []]]]
        ]
    ],
        itemOperations: ['GET' => [
//        'normalization_context' => ['groups' => ['Familly:read']],
        'openapi_context' => ['security' => [['bearerAuth' => []]]]
    ]],
        paginationEnabled: false,
    )
]
class Module
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['Familly:read', 'Modules:read'])]
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['Modules:read'])]
    private ?string $name;

    /**
     * @ORM\OneToMany(targetEntity=Sensor::class, mappedBy="module", orphanRemoval=true)
     */
    private ArrayCollection $sensors;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="modules")
     * @ORM\JoinColumn(nullable=false)
     */
    #[NotNull(message: 'Un utilisateur doir être choisi')]
    private ?User $user;

    /**
     * @ORM\ManyToOne(targetEntity=Familly::class, inversedBy="modules")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Familly $familly;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="module", orphanRemoval=true)
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity=Image::class, mappedBy="module", orphanRemoval=true)
     */
    private $images;

    public function __construct()
    {
        $this->sensors = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->images = new ArrayCollection();
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

    /**
     * @return Collection|Sensor[]
     */
    public function getSensors(): Collection
    {
        return $this->sensors;
    }

    public function addSensor(Sensor $sensor): self
    {
        if (!$this->sensors->contains($sensor)) {
            $this->sensors[] = $sensor;
            $sensor->setModule($this);
        }

        return $this;
    }

    public function removeSensor(Sensor $sensor): self
    {
        if ($this->sensors->removeElement($sensor)) {
            // set the owning side to null (unless already changed)
            if ($sensor->getModule() === $this) {
                $sensor->setModule(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getFamilly(): ?Familly
    {
        return $this->familly;
    }

    public function setFamilly(?Familly $familly): self
    {
        $this->familly = $familly;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setModule($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getModule() === $this) {
                $comment->setModule(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setModule($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getModule() === $this) {
                $image->setModule(null);
            }
        }

        return $this;
    }
}
