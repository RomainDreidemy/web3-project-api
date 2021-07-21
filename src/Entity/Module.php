<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\Module\ModuleImageController;
use App\Controller\ModuleSensorController;
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
        itemOperations: [
            'GET' => [
                'normalization_context' => ['groups' => ['Module:read']],
                'openapi_context' => ['security' => [['bearerAuth' => []]]]
            ],
            'sensors_informations' => [
                'normalization_context' => ['groups' => ['Actions:read']],
                'openapi_context' => [
                    'security' => [['bearerAuth' => []]],
                    'summary' => 'Retrieves the list of actions for a module',
                    'description' => 'Retrieves the list of actions for a module'
                ],
                'method' => 'GET',
                'controller' => ModuleSensorController::class,
                'path' => '/modules/{id}/actions',
                'read' => false,
                'write' => false
            ]
    ],
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
    #[Groups(['Familly:read', 'Modules:read', 'Module:read'])]
    private int $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    #[Groups(['Modules:read', 'Module:read'])]
    private ?string $name;

    /**
     * @ORM\OneToMany(targetEntity=Sensor::class, mappedBy="module", orphanRemoval=true)
     */
    #[Groups(['Modules:read', 'Module:read'])]
    private Collection $sensors;

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
    #[Groups(['Module:read'])]
    private Collection $comments;

    /**
     * @ORM\OneToMany(targetEntity=Image::class, mappedBy="module", orphanRemoval=true)
     */
    #[Groups(['Module:read'])]
    private Collection $images;

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

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection
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
}
