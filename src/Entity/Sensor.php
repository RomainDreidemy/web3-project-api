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
}
