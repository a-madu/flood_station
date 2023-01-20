<?php

namespace Drupal\flood_station\Service;

use GuzzleHttp\Client;

/**
 * Class FloodStationService.
 */
class FloodStationService
{

  /**
   * Guzzle client.
   *
   * @var \GuzzleHttp\Client
   */
  protected $client;

  /**
   * Constructs a new FloodStationService object.
   */
  public function __construct(Client $client)
  {
    $this->client = $client;
  }

  /**
   * Get stations.
   */
  public function getStations()
  {
    try {
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
    } catch (\Exception $e) {
      \Drupal::logger('flood_getStations')->error('Error getting data:'.$e->getMessage());
      return json_encode(array('error' => true, 'message' => $e->getMessage()));
    }
  }

  /**
   * Get station information.
   */
  public function getStation($id)
  {
    try {
      $response = $this->client->get("https://environment.data.gov.uk/flood-monitoring/id/stations/{$id}/readings?_sorted&_limit=10");
      $data = json_decode($response->getBody(), TRUE);

      $readingsData = array();
      foreach ($data['items'] as $reading) {
        $date = $reading['dateTime'];
        $measurement = $reading['value'];
        $readingsData[] = array('date' => $date, 'measurement' => $measurement);
      }
      return json_encode($readingsData);
    } catch (\Exception $e) {
      \Drupal::logger('flood_getStation')->error('Error getting data :'.$e->getMessage());
      return json_encode(array('error' => true, 'message' => $e->getMessage()));
    }
  }
}
