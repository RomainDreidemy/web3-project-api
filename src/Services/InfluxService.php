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

    return $this->formatInfluxResults($results);
  }

  /**
   *  @param $nodeId
   *  @param $measurement
   *  @param $timeRange 
   *  @return Records[]
   */
  public function getMeasurementForTimeRange($nodeId, $measurement, array $timeRange): array
  {
    $query = "from(bucket: \"{$this->bucket}\")
              |> range(start: {$timeRange['start']}, stop: {$timeRange['stop']})
              |> filter(fn: (r) => r[\"Node_ID\"] == \"{$nodeId}\")
              |> filter(fn: (r) => r[\"_measurement\"] == \"{$measurement}\")";

    $results = $this->queryApi->query($query);
    return $this->formatInfluxResults($results);
  }

  /**
   * @param $results
   * @return Records[]
   */
  private function formatInfluxResults(array $results): array
  {
    foreach ($results[0]->records as $record) {
      $values = $record->values;

      $records[] = (new Records())
        ->setNodeid($values['Node_ID'])
        ->setValue($values['_value'])
        ->setSensorType($this->sensorTypeRepository->findOneBy(['inflexId' => $values['_measurement']]))
        ->setTimestamp($values['_time']);
    }

    return $records;
  }
}
