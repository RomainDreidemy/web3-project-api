<?php


namespace App\Services;

use App\Entity\Influx\Records;
use App\Entity\SensorType;
use App\Repository\SensorTypeRepository;
use InfluxDB2\Client;

class InfluxService
{
  public function __construct(
    string $url,
    string $token,
    private string $bucket,
    string $org,
    private SensorTypeRepository $sensorTypeRepository
  ) {
    $client = new Client([
      'url' => $url,
      'token' => $token,
      'org' => $org,
      'verifySSL' => false,
    ]);

    $this->queryApi = $client->createQueryApi();
  }

    /**
     * @param $nodeId
     * @return Records[]
     */
    public function getLastMeasurementsByNodeId($nodeId): array
  {
    $query = "from(bucket: \"{$this->bucket}\")
              |> range(start: -1h)
              |> filter(fn: (r) => r[\"Node_ID\"] == \"{$nodeId}\")
              |> last()";

    $results = $this->queryApi->query($query);

    $records = [];

    foreach ($results as $result){
        $values = $result->records[0]->values;

        $records[] = (new Records())
            ->setNodeid($values['Node_ID'])
            ->setValue($values['_value'])
            ->setSensorType($this->sensorTypeRepository->findOneBy(['inflexId' => $values['_measurement']]))
        ;
    }

    return $records;
  }
}
