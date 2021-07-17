<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 */
#[
    ApiResource(
        collectionOperations: [
            'POST' => [
                'normalization_context' => ['groups' => ['Comments:read']],
                'denormalization_context' => ['groups' => ['Comments:write']],
                'openapi_context' => ['security' => [['bearerAuth' => []]]]
            ]
        ],
        itemOperations: ['GET' => [
            'normalization_context' => ['groups' => ['Module:read']],
            'openapi_context' => ['security' => [['bearerAuth' => []]]]
        ]]
    )
]
class Comment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['Module:read'])]
    private int $id;

    /**
     * @ORM\Column(type="text")
     */
    #[Groups(['Module:read', 'Comments:write'])]
    private string $text;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    #[Groups(['Module:read'])]
    private \DateTimeImmutable $created_at;

    /**
     * @ORM\ManyToOne(targetEntity=Module::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    #[Groups(['Comments:write'])]
    private ?Module $module;

    public function __construct()
    {
        $this->created_at = new \DateTimeImmutable();
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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
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
}
