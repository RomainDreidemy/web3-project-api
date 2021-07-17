<?php

namespace App\Entity;

use App\Repository\SheetRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SheetRepository::class)
 */
class Sheet
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $content;

    /**
     * @ORM\ManyToOne(targetEntity=Familly::class, inversedBy="sheets")
     * @ORM\JoinColumn(nullable=false)
     */
    private Familly $familly;

    /**
     * @ORM\OneToOne(targetEntity=Spec::class, mappedBy="min_sheet")
     */
    private ?Spec $min_spec;

    /**
     * @ORM\OneToOne(targetEntity=Spec::class, mappedBy="max_sheet")
     */
    private ?Spec $max_spec;

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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getFamilly(): ?Familly
    {
        return $this->familly;
    }

    public function setFamilly(Familly $familly): self
    {
        $this->familly = $familly;

        return $this;
    }

    public function getMinSpec(): ?Spec
    {
        return $this->min_spec;
    }

    public function setMinSpec(?Spec $min_spec): self
    {
        // unset the owning side of the relation if necessary
        if ($min_spec === null && $this->min_spec !== null) {
            $this->min_spec->setMinSheet(null);
        }

        // set the owning side of the relation if necessary
        if ($min_spec !== null && $min_spec->getMinSheet() !== $this) {
            $min_spec->setMinSheet($this);
        }

        $this->min_spec = $min_spec;

        return $this;
    }

    public function getMaxSpec(): ?Spec
    {
        return $this->max_spec;
    }

    public function setMaxSpec(?Spec $max_spec): self
    {
        // unset the owning side of the relation if necessary
        if ($max_spec === null && $this->max_spec !== null) {
            $this->max_spec->setMinSheet(null);
        }

        // set the owning side of the relation if necessary
        if ($max_spec !== null && $max_spec->getMinSheet() !== $this) {
            $max_spec->setMinSheet($this);
        }

        $this->min_spec = $max_spec;

        return $this;
    }
}
