<?php

namespace Drupal\flood_station\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\flood_station\Services\FloodStationService;
use GuzzleHttp\Client;

/**
 * FloodStationController class.
 */
class FloodStationController extends ControllerBase {

  /**
   * Get the flood stations.
   *
   * @return array
   */
  public function getStations() {
    $flood_station_service = new FloodStationService(new Client());
    $stations = $flood_station_service->getStations();
    dump($stations);
  }

}
