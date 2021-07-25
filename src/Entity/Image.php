<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ImageRepository::class)
 */
class Image
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['Comment:read'])]
    private int $id;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    #[Groups(['Module:read', 'Comment:read'])]
    private \DateTimeImmutable $created_at;

    /**
     * @ORM\Column(type="text")
     */
    #[Groups(['Module:read', 'Comment:read'])]
    private ?string $secureUrl;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private ?string $format;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private ?string $publicId;

    /**
     * @ORM\ManyToOne(targetEntity=Comment::class, inversedBy="images")
     */
    private ?Comment $comment;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSecureUrl(): ?string
    {
        return $this->secureUrl;
    }

    public function setSecureUrl(string $secureUrl): self
    {
        $this->secureUrl = $secureUrl;

        return $this;
    }

    public function getFormat(): ?string
    {
        return $this->format;
    }

    public function setFormat(string $format): self
    {
        $this->format = $format;

        return $this;
    }

    public function getPublicId(): ?string
    {
        return $this->publicId;
    }

    public function setPublicId(string $publicId): self
    {
        $this->publicId = $publicId;

        return $this;
    }

    public function getComment(): ?Comment
    {
        return $this->comment;
    }

    public function setComment(?Comment $comment): self
    {
        $this->comment = $comment;

        return $this;
    }
}
