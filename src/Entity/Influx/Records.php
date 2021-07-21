<?php


namespace App\Entity\Influx;


class Records
{
    private $nodeid;

    private int $value;

    private string $sensorType;

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
    public function getSensorType(): string
    {
        return $this->sensorType;
    }

    /**
     * @param string $sensorType
     */
    public function setSensorType(string $sensorType): self
    {
        $this->sensorType = $sensorType;

        return $this;

    }
}