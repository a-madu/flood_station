<?php

namespace Drupal\flood_station\Service;

use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\JsonResponse;

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
    try{
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
      \Drupal::logger('flood_getStations')->error('Error getting data:', ['@error' => $e->getMessage()]);
      return 'error';
    }
  }


  public function getStation($id) {
    try {
      $response = $this->client->get("https://environment.data.gov.uk/flood-monitoring/id/stations/{$id}/readings?_sorted&_limit=10");
      $data = json_decode($response->getBody(), TRUE);
      return $data['items'];
    } catch (\Exception $e) {
      \Drupal::logger('flood_getStation')->error('Error getting data', ['@error' => $e->getMessage()]);
      return 'error';
    }
  }
}
