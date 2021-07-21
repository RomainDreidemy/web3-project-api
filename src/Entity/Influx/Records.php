<?php


namespace App\Entity\Influx;


use App\Entity\SensorType;

class Records
{
    private $nodeid;

    private int $value;

    private SensorType $sensorType;

    /**
     * @return mixed
     */
    public function getNodeid()
    {
        return $this->nodeid;
    }

    /**
     * @param mixed $nodeid
     */
    public function setNodeid($nodeid): self
    {
        $this->nodeid = $nodeid;

        return $this;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @param int $value
     */
    public function setValue(int $value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getSensorType(): SensorType
    {
        return $this->sensorType;
    }

    /**
     * @param ?SensorType $sensorType
     */
    public function setSensorType(?SensorType $sensorType): self
    {
        $this->sensorType = $sensorType;

        return $this;

    }
}