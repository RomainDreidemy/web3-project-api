<?php

namespace App\Entity;

use App\Repository\ActionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

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
    #[Groups(['Actions:read', 'SensorData:read', 'ModuleApi:read'])]
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    #[Groups(['Actions:read', 'SensorData:read', 'ModuleApi:read'])]
    private $text;

    /**
     * @ORM\ManyToMany(targetEntity=ActionCondition::class, inversedBy="actions")
     */
    private $actionCondition;

    #[Groups(['Actions:read'])]
    private ?SensorType $sensorType;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

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

    /**
     * @param int $sensorTypeId
     */
    public function setSensorTypeId(int $sensorTypeId): void
    {
        $this->sensorTypeId = $sensorTypeId;
    }

    /**
     * @return SensorType|null
     */
    public function getSensorType(): ?SensorType
    {
        return $this->sensorType;
    }

    /**
     * @param SensorType|null $sensorType
     */
    public function setSensorType(?SensorType $sensorType): self
    {
        $this->sensorType = $sensorType;

        return $this;
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
}
