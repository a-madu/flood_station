<?php

namespace Drupal\flood_station\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\flood_station\Services\FloodStationService;

/**
 * FloodStationController class.
 */
class FloodStationController extends ControllerBase {

  protected $flood_station_service;

  /**
   * FloodStationController constructor.
   *
   * @param \Drupal\flood_station\Services\FloodStationService $flood_station_service
   */
  public function __construct(FloodStationService $flood_station_service) {
    $this->flood_station_service = $flood_station_service;
  }

  /**
   * Get the flood stations.
   *
   * @return array
   */
  public function getStations() {
    $stations = $this->flood_station_service->getStations();
    $station = $this->flood_station_service->getStation();
    dump($stations);
    dump($station);
  }

}
