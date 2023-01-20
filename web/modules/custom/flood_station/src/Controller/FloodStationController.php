<?php

namespace Drupal\flood_station\Controller;

use Drupal\flood_station\FloodStationService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class MyController.
 */
class FloodStationController {

  /**
   * FloodStationService definition.
   *
   * @var \Drupal\flood_station\FloodStationService
   */
  protected $floodStationService;

  /**
   * MyController constructor.
   *
   * @param \Drupal\flood_station\FloodStationService $flood_station_service
   */
  public function __construct(FloodStationService $flood_station_service) {
    $this->floodStationService = $flood_station_service;
  }

  /**
   * Returns a JSON response of all stations.
   */
  public function getStations() {
    $stations = $this->floodStationService->getStations();
    return new JsonResponse($stations);
  }

    public function getStation($id) {
    $readings = $this->floodStationService->getStation($id);
    return new JsonResponse($readings);
  }
}

