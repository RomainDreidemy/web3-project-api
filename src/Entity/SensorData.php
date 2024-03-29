<?php


namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;

class SensorData
{
    private Module $module;

    #[Groups(['SensorData:read', 'ModuleApi:read'])]
    private SensorType $sensorType;

    #[Groups(['SensorData:read', 'ModuleApi:read'])]
    private float $min;

    #[Groups(['SensorData:read', 'ModuleApi:read'])]
    private float $max;

    #[Groups(['SensorData:read', 'ModuleApi:read'])]
    private float $currentValue;

    /**
     * @var Action[]
     */
    #[Groups(['SensorData:read', 'ModuleApi:read'])]
    private Collection $actions;

    #[Groups(['SensorData:read', 'ModuleApi:read'])]
    private bool $status;

    /**
     * @return Module
     */
    public function getModule(): Module
    {
        return $this->module;
    }

    /**
     * @param Module $module
     */
    public function setModule(Module $module): self
    {
        $this->module = $module;

        return $this;
    }

    /**
     * @return SensorType
     */
    public function getSensorType(): SensorType
    {
        return $this->sensorType;
    }

    /**
     * @param SensorType $sensorType
     */
    public function setSensorType(SensorType $sensorType): self
    {
        $this->sensorType = $sensorType;

        return $this;
    }

    /**
     * @return int
     */
    public function getMin(): float
    {
        return $this->min;
    }

    /**
     * @param float $min
     */
    public function setMin(float $min): self
    {
        $this->min = $min;

        return $this;
    }

    /**
     * @return float
     */
    public function getMax(): float
    {
        return $this->max;
    }

    /**
     * @param float $max
     */
    public function setMax(float $max): self
    {
        $this->max = $max;

        return $this;
    }

    /**
     * @return Action[]
     */
    public function getActions(): Collection
    {
        return $this->actions;
    }

    /**
     * @param Collection $actions
     */
    public function setActions(Collection $actions): self
    {
        $this->actions = $actions;

        return $this;
    }

    public function addAction(Action $action): self
    {
        if (!$this->actions->contains($action)) {
            $this->actions[] = $action;
        }

        return $this;
    }

    public function __construct()
    {
        $this->actions = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getCurrentValue(): int
    {
        return $this->currentValue;
    }

    /**
     * @param int $currentValue
     */
    public function setCurrentValue(int $currentValue): self
    {
        $this->currentValue = $currentValue;

        return $this;
    }

    /**
     * @return bool
     */
    public function isStatus(): bool
    {
        return $this->status;
    }

    /**
     * @param bool $status
     */
    public function setStatus(): self
    {
        $this->status = ($this->min <= $this->currentValue && $this->max >= $this->currentValue);

        return $this;
    }
}