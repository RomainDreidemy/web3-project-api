<?php

namespace App\Entity;

use App\Repository\ActionConditionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ActionConditionRepository::class)
 */
class ActionCondition
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=SensorType::class, inversedBy="actionConditions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sensorType;

    /**
     * @ORM\ManyToOne(targetEntity=Familly::class, inversedBy="actionConditions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $family;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $operator;

    /**
     * @ORM\Column(type="float")
     */
    private float $value;

    /**
     * @ORM\ManyToMany(targetEntity=Action::class, mappedBy="actionCondition")
     */
    private $actions;

    public function __construct()
    {
        $this->actions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSensorType(): ?SensorType
    {
        return $this->sensorType;
    }

    public function setSensorType(?SensorType $sensorType): self
    {
        $this->sensorType = $sensorType;

        return $this;
    }

    public function getFamily(): ?Familly
    {
        return $this->family;
    }

    public function setFamily(?Familly $family): self
    {
        $this->family = $family;

        return $this;
    }

    public function getOperator(): ?string
    {
        return $this->operator;
    }

    public function setOperator(string $operator): self
    {
        $this->operator = $operator;

        return $this;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(float $value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return Collection|Action[]
     */
    public function getActions(): Collection
    {
        return $this->actions;
    }

    public function addAction(Action $action): self
    {
        if (!$this->actions->contains($action)) {
            $this->actions[] = $action;
            $action->addActionCondition($this);
        }

        return $this;
    }

    public function removeAction(Action $action): self
    {
        if ($this->actions->removeElement($action)) {
            $action->removeActionCondition($this);
        }

        return $this;
    }
}
