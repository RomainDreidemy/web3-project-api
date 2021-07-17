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
    private int $id;

    /**
     * @ORM\Column(type="integer")
     */
    private int $min;

    /**
     * @ORM\Column(type="integer")
     */
    private int $max;

    /**
     * @ORM\OneToOne(targetEntity=Sheet::class, inversedBy="spec", cascade={"persist", "remove"})
     */
    private ?Sheet $min_sheet;

    /**
     * @ORM\OneToOne(targetEntity=Sheet::class, cascade={"persist", "remove"})
     */
    private ?Sheet $max_sheet;

    /**
     * @ORM\ManyToOne(targetEntity=Familly::class, inversedBy="specs")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Familly $familly;

    /**
     * @ORM\ManyToOne(targetEntity=SensorType::class, inversedBy="specs")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?SensorType $sensorType;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMin(): ?int
    {
        return $this->min;
    }

    public function setMin(int $min): self
    {
        $this->min = $min;

        return $this;
    }

    public function getMax(): ?int
    {
        return $this->max;
    }

    public function setMax(int $max): self
    {
        $this->max = $max;

        return $this;
    }

    public function getMinSheet(): ?Sheet
    {
        return $this->min_sheet;
    }

    public function setMinSheet(?Sheet $min_sheet): self
    {
        $this->min_sheet = $min_sheet;

        return $this;
    }

    public function getMaxSheet(): ?Sheet
    {
        return $this->max_sheet;
    }

    public function setMaxSheet(?Sheet $max_sheet): self
    {
        $this->max_sheet = $max_sheet;

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
