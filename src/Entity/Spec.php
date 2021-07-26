<?php

namespace App\Entity;

use App\Repository\SpecRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SpecRepository::class)
 */
class Spec
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $min;

    /**
     * @ORM\Column(type="float")
     */
    private $max;

    /**
     * @ORM\ManyToOne(targetEntity=Familly::class, inversedBy="specs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $family;

    /**
     * @ORM\ManyToOne(targetEntity=SensorType::class, inversedBy="specs")
     */
    private $sensorType;

    public function getId(): ?float
    {
        return $this->id;
    }

    public function getMin(): ?float
    {
        return $this->min;
    }

    public function setMin(float $min): self
    {
        $this->min = $min;

        return $this;
    }

    public function getMax(): ?float
    {
        return $this->max;
    }

    public function setMax(float $max): self
    {
        $this->max = $max;

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

    public function getSensorType(): ?SensorType
    {
        return $this->sensorType;
    }

    public function setSensorType(?SensorType $sensorType): self
    {
        $this->sensorType = $sensorType;

        return $this;
    }
}
