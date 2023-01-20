<?php

namespace Drupal\flood_station\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Class FloodStationForm.
 *
 * @package Drupal\flood_station\Form
 */
class FloodStationForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'flood_station_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['station'] = [
      '#type' => 'select',
      '#title' => $this->t('Select a station'),
      '#options' => $this->getStationOptions(),
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $form_values = $form_state->getValue('station');
    $url = Url::fromRoute('flood_station.reading', ['id' => $form_values]);
    $form_state->setRedirectUrl($url);
  }

  /**
   * Get the list of stations.
   *
   * @return array
   *   An array of stations.
   */
  private function getStationOptions(){
    $options = [];
    $flood_station_service = \Drupal::service('flood_station.flood_station_service');
    $stations = $flood_station_service->getStations();
    foreach($stations as $station) {
      $options[$station['url']] = $station['name'];
    }
    return $options;
  }
}
