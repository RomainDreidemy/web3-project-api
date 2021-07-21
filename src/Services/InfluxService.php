<?php


namespace App\Services;

use InfluxDB2\Client;

class InfluxService
{
  public function __construct(
    string $url,
    string $token,
    private string $bucket,
    string $org,
  ) {
    $client = new Client([
      'url' => $url,
      'token' => $token,
      'org' => $org,
      'verifySSL' => false,
    ]);

    $this->queryApi = $client->createQueryApi();
  }

  public function getLastMeasurementsByNodeId($nodeId)
  {
    $query = "from(bucket: \"{$this->bucket}\")
              |> range(start: -1h)
              |> filter(fn: (r) => r[\"Node_ID\"] == \"{$nodeId}\")
              |> last()";

    return $this->queryApi->query($query);
  }
}
