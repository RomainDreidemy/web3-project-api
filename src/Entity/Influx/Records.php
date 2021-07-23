<?php


namespace App\Entity\Influx;


use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\Influx\InfluxController;
use App\Entity\SensorType;
use Symfony\Component\Serializer\Annotation\Groups;

#[
    ApiResource(
        collectionOperations: [
        'GET' => [
            'normalization_context' => ['groups' => ['Records:read']],
            'openapi_context' => [
                'security' => [['bearerAuth' => []]],
                'summary' => 'Retrieves the list of actions for a module',
                'description' => 'Retrieves the list of actions for a module',
            ],
            'tags' => ['Sensor'],
            'method' => 'GET',
            'controller' => InfluxController::class,
            'path' => '/modules/{moduleId}/sensors/{sensorId}',
            'read' => false,
            'write' => false,
        ]
    ],
        itemOperations: ['GET' => []],
        formats: ['json'],
        paginationEnabled: false,
    ),
]
class Records
{
    #[
        ApiProperty(identifier: true),
        Groups(['Records:read'])]
    private $nodeid;

    #[Groups(['Records:read'])]
    private int $value;

    private SensorType $sensorType;

    #[Groups(['Records:read'])]
    private int $timestamp;

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

    /**
     * @return string
     */
    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    /**
     * @param string $timestamp
     */
    public function setTimestamp(string $timestamp): self
    {
        $this->timestamp = strtotime($timestamp);
        return $this;
    }
}