<?php

namespace App\Entity;

use App\Repository\SensorTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

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
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
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
     * @ORM\OneToMany(targetEntity=Spec::class, mappedBy="sensorType", orphanRemoval=true)
     */
    private $specs;

    public function __construct()
    {
        $this->sensors = new ArrayCollection();
        $this->specs = new ArrayCollection();
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
            $sensor->setSensorType($this);
        }

        return $this;
    }

    public function removeSensor(Sensor $sensor): self
    {
        if ($this->sensors->removeElement($sensor)) {
            // set the owning side to null (unless already changed)
            if ($sensor->getSensorType() === $this) {
                $sensor->setSensorType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Spec[]
     */
    public function getSpecs(): Collection
    {
        return $this->specs;
    }

    public function addSpec(Spec $spec): self
    {
        if (!$this->specs->contains($spec)) {
            $this->specs[] = $spec;
            $spec->setSensorType($this);
        }

        return $this;
    }

    public function removeSpec(Spec $spec): self
    {
        if ($this->specs->removeElement($spec)) {
            // set the owning side to null (unless already changed)
            if ($spec->getSensorType() === $this) {
                $spec->setSensorType(null);
            }
        }

        return $this;
    }
}
