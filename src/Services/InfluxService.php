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

}
