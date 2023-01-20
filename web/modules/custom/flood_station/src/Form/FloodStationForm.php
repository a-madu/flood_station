<?php


namespace Drupal\flood_station\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class FloodStationForm.
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
      // $form['#attributes']['onsubmit'] = 'event.preventDefault();';
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
    // Perform actions on form submission
    $form_values = $form_state->getValue('station');
    \Drupal::logger('flood_station')->notice('Form values: <pre>' . print_r($form_values, TRUE) . '</pre>');
    $form_state->setRedirectUrl( '/flood-station/reading/'.$form_values);
  }

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
