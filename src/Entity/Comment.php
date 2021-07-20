<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\Module\ModuleCommentController;
use App\Enums\CommentKeys;
use App\Repository\CommentRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 */
#[
    ApiResource(
        collectionOperations: [
        'POST' => [
            'normalization_context' => ['groups' => ['Comment:read']],
            'denormalization_context' => ['groups' => ['Comments:write']],
            'openapi_context' => ['security' => [['bearerAuth' => []]]]
        ]
    ],
        itemOperations: ['GET' => [
            'normalization_context' => ['groups' => ['Module:read']],
            'openapi_context' => ['security' => [['bearerAuth' => []]]]
        ],
            'add_comments' => [
                'normalization_context' => ['groups' => ['Comment:read']],
                'openapi_context' => [
                    'security' => [['bearerAuth' => []]],
                    'requestBody' => [
                        'content' => [
                            'multipart/form-data' => [
                                'schema' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'files[]' => [
                                            'type' => 'string',
                                            'format' => 'binary',
                                        ],
                                        CommentKeys::text => [
                                            'type' => 'string',
                                            'format' => 'text',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
                'method' => 'POST',
                'controller' => ModuleCommentController::class,
                'path' => 'modules/{module}/comment',
                'read' => false,
                'write' => false
            ],
            'add_image_to_comment' => [
                'normalization_context' => ['groups' => ['Comment:read']],
                'openapi_context' => [
                    'security' => [['bearerAuth' => []]],
                    'requestBody' => [
                        'content' => [
                            'multipart/form-data' => [
                                'schema' => [
                                    'type' => 'object',
                                    'properties' => [
                                        CommentKeys::commentImage => [
                                            'type' => 'string',
                                            'format' => 'binary',
                                        ]
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
                'method' => 'POST',
                'controller' => ModuleCommentController::class,
                'path' => 'comments/{comment}/image',
                'read' => false,
                'write' => false
            ],
            'remove_image_to_comment' => [
                'normalization_context' => ['groups' => ['Comment:read']],
                'openapi_context' => [
                    'security' => [['bearerAuth' => []]]
                ],
                'method' => 'DELETE',
                'controller' => ModuleCommentController::class,
                'path' => 'comments/image/{image}',
                'read' => false,
                'write' => false
            ]
        ]
    )
]
class Comment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['Module:read', 'Comment:read'])]
    private int $id;

    /**
     * @ORM\Column(type="text")
     */
    #[Groups(['Module:read', 'Comments:write', 'Comment:read'])]
    private string $text;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    #[Groups(['Module:read', 'Comment:read'])]
    private DateTimeImmutable $created_at;

    /**
     * @ORM\ManyToOne(targetEntity=Module::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    #[Groups(['Comments:write'])]
    private ?Module $module;

    /**
     * @ORM\OneToMany(targetEntity=Image::class, mappedBy="comment")
     */
    #[Groups(['Module:read', 'Comment:read'])]
    private Collection $images;

    public function __construct()
    {
        $this->created_at = new DateTimeImmutable();
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getModule(): ?Module
    {
        return $this->module;
    }

    public function setModule(?Module $module): self
    {
        $this->module = $module;

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
            $image->setComment($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getComment() === $this) {
                $image->setComment(null);
            }
        }

        return $this;
    }
}
