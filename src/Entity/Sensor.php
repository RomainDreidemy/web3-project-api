<?php

namespace App\Entity;

use App\Repository\SensorRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * @ORM\Entity(repositoryClass=SensorRepository::class)
 */
#[UniqueEntity(fields: 'id_influx', message: 'id_flux est déjà utilisé.')]
class Sensor
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity=SensorType::class, inversedBy="sensors")
     * @ORM\JoinColumn(nullable=false)
     */
    private SensorType $type;

    /**
     * @ORM\ManyToOne(targetEntity=Module::class, inversedBy="sensors")
     * @ORM\JoinColumn(nullable=false)
     */
    private Module $module;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private string $id_influx;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $last_value;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): SensorType
    {
        return $this->type;
    }

    public function setType(SensorType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getModule(): ?Module
    {
        return $this->module;
    }

    public function setModule(Module $module): self
    {
        $this->module = $module;

        return $this;
    }

    public function getIdInflux(): string
    {
        return $this->id_influx;
    }

    public function setIdInflux(string $id_influx): self
    {
        $this->id_influx = $id_influx;

        return $this;
    }

    public function getLastValue(): ?int
    {
        return $this->last_value;
    }

    public function setLastValue(?int $last_value): self
    {
        $this->last_value = $last_value;

        return $this;
    }
}
