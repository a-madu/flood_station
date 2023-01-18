<?php

namespace Drupal\flood_station\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

/**
 * FloodStationService class.
 */
class FloodStationService {

  protected $client;

  /**
   * FloodStationService constructor.
   *
   * @param \GuzzleHttp\Client $client
   */
  public function __construct(Client $client) {
    $this->client = $client;
  }

  /**
   * Get the flood stations.
   *
   * @return array|string
   */
  public function getStations() {
    try {
      $response = $this->client->request('GET', 'https://environment.data.gov.uk/flood-monitoring/id/stations?_limit=50');
      $data = json_decode($response->getBody(), true);
      $stations = array();
      foreach ($data['items'] as $station) {
        $stations[] = array(
          'name' => $station['label'],
          'url' => $station['url'],
        );
      }
      return $stations;
    } catch (RequestException $e) {
      return 'Error: ' . $e->getMessage();
    }
  }


  public function getStation($id) {
    try {
      $response = $this->client->request('GET', 'https://environment.data.gov.uk/flood-monitoring/id/stations/'.$id.'/readings?_sorted&_limit=10');
      $data = json_decode($response->getBody(), true);
      $readings = array();
      foreach ($data['items'] as $reading) {
        $readings[] = array(
          'date' => $reading['dateTime'],
          'measurement' => $reading['value'],
        );
      }
      return json_encode($readings);
    } catch (RequestException $e) {
      return 'Error: ' . $e->getMessage();
    }
  }

}
