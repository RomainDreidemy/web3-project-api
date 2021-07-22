<?php


namespace App\Entity\Api;


use App\Entity\Module;
use App\Entity\SensorData;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

class ModuleApi
{
    #[Groups(['ModuleApi:read'])]
    private Module $module;

    #[Groups(['ModuleApi:read'])]
    private $sensorData;

    public function __construct()
    {
        $this->sensorData = new ArrayCollection();
    }

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
     * @return ArrayCollection
     */
    public function getSensorData(): ArrayCollection
    {
        return $this->sensorData;
    }

    /**
     * @param SensorData $sensorData
     */
    public function addSensorData(SensorData $sensorData): self
    {
        $this->sensorData[] = $sensorData;

        return $this;
    }
}