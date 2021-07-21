<?php

namespace App\Entity;

use App\Repository\ActionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ActionRepository::class)
 */
class Action
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $text;

    /**
     * @ORM\ManyToMany(targetEntity=ActionCondition::class, inversedBy="actions")
     */
    private $actionCondition;

    public function __construct()
    {
        $this->actionCondition = new ArrayCollection();
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

    /**
     * @return Collection|ActionCondition[]
     */
    public function getActionCondition(): Collection
    {
        return $this->actionCondition;
    }

    public function addActionCondition(ActionCondition $actionCondition): self
    {
        if (!$this->actionCondition->contains($actionCondition)) {
            $this->actionCondition[] = $actionCondition;
        }

        return $this;
    }

    public function removeActionCondition(ActionCondition $actionCondition): self
    {
        $this->actionCondition->removeElement($actionCondition);

        return $this;
    }
}
