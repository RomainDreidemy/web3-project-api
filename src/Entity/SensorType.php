<?php

namespace App\Entity;

use App\Repository\SensorTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=SensorTypeRepository::class)
 */
class SensorType
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['Actions:read'])]
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['Actions:read'])]
    private ?string $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $unit;

    /**
     * @ORM\OneToMany(targetEntity=Sensor::class, mappedBy="sensorType", orphanRemoval=true)
     */
    private Collection $sensors;

    /**
     * @ORM\OneToMany(targetEntity=ActionCondition::class, mappedBy="sensorType")
     */
    private $actionConditions;

    public function __construct()
    {
        $this->sensors = new ArrayCollection();
        $this->actionConditions = new ArrayCollection();
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

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function setUnit(string $unit): self
    {
        $this->unit = $unit;

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
            $sensor->setType($this);
        }

        return $this;
    }

    /**
     * @return Collection|ActionCondition[]
     */
    public function getActionConditions(): Collection
    {
        return $this->actionConditions;
    }

    public function addActionCondition(ActionCondition $actionCondition): self
    {
        if (!$this->actionConditions->contains($actionCondition)) {
            $this->actionConditions[] = $actionCondition;
            $actionCondition->setSensorType($this);
        }

        return $this;
    }

    public function removeActionCondition(ActionCondition $actionCondition): self
    {
        if ($this->actionConditions->removeElement($actionCondition)) {
            // set the owning side to null (unless already changed)
            if ($actionCondition->getSensorType() === $this) {
                $actionCondition->setSensorType(null);
            }
        }

        return $this;
    }
}
