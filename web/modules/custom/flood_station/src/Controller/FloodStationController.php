<?php

namespace Drupal\flood_station\Controller;

use Drupal\flood_station\Service\FloodStationService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class MyController.
 */
class FloodStationController {

  /**
   * FloodStationService definition.
   *
   * @var FloodStationService
   */
  protected $floodStationService;

  /**
   * MyController constructor.
   *
   * @param FloodStationService $flood_station_service
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

  /**
   * Returns a JSON response for station data.
   */
  public function getStation($id)
  {
    $station_data = $this->floodStationService->getStation($id);
    $readings = json_decode($station_data,true);
    if (isset($readings['error']) && $readings['error'] === true) {
      \Drupal::messenger()->addError($readings['message']);
      return [];
    } else {
      $header = [
        'Date',
        'measurement'
      ];
      $rows = array();
      foreach ($readings as $reading) {
        $rows[] = [
          'date' => $reading['date'],
          'measure' => $reading['measurement']
        ];
      }
      $build = array(
        '#type' => 'table',
        '#header' => $header,
        '#rows' => $rows,
        '#attributes' => array(
          'id' => 'reading-table',
        ),
      );
      return $build;
    }
  }
}

