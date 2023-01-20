<?php

namespace Drupal\flood_station;

use GuzzleHttp\Client;
use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * Class FloodStationService.
 */
class FloodStationService {

  /**
   * Guzzle client.
   *
   * @var \GuzzleHttp\Client
   */
  protected $client;

  /**
   * Constructs a new FloodStationService object.
   */
  public function __construct(Client $client) {
    $this->client = $client;
  }

  /**
   * Get station information.
   */
  public function getStations() {
    $response = $this->client->get('https://environment.data.gov.uk/flood-monitoring/id/stations?_limit=50');
    $data = json_decode($response->getBody(), TRUE);
    $stations = [];
    foreach ($data['items'] as $item) {
      $stations[] = [
        'name' => $item['label'],
        'url' => $item['notation'],
      ];
    }
    return $stations;
  }


    public function getStation($id) {
    $response = $this->client->get("https://environment.data.gov.uk/flood-monitoring/id/stations/{$id}/readings?_sorted&_limit=100");
    $data = json_decode($response->getBody(), TRUE);
    return $data;
  }

}
