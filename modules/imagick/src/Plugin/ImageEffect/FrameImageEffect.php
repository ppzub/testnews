<?php

namespace Drupal\imagick\Plugin\ImageEffect;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Image\ImageInterface;
use Drupal\image\ConfigurableImageEffectBase;

/**
 * Blurs an image resource.
 *
 * @ImageEffect(
 *   id = "image_frame",
 *   label = @Translation("Frame"),
 *   description = @Translation("Frames an image with a border")
 * )
 */
class FrameImageEffect extends ConfigurableImageEffectBase {

  /**
   * {@inheritdoc}
   */
  public function applyEffect(ImageInterface $image) {
    if (!$image->apply('frame', $this->configuration)) {
      $this->logger->error('Image frame failed using the %toolkit toolkit on %path (%mimetype)', [
        '%toolkit' => $image->getToolkitId(),
        '%path' => $image->getSource(),
        '%mimetype' => $image->getMimeType()
      ]);
      return FALSE;
    }
    return TRUE;
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'matte_color' => '#707070',
      'width' => '20',
      'height' => '20',
      'inner_bevel' => '5',
      'outer_bevel' => '5',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form = [
      '#type' => 'container',
      '#attributes' => [
        'class' => ['colorform'],
      ],
    ];

    $form['matte_color'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Color of the shadow'),
      '#default_value' => $this->configuration['matte_color'],
      '#attributes' => [
        'class' => ['colorentry'],
      ],
    ];
    $form['colorpicker'] = [
      '#weight' => -1,
      '#type' => 'container',
      '#attributes' => [
        'class' => ['colorpicker'],
        'style' => ['float:right'],
      ],
    ];

    // Add Farbtastic color picker.
    $form['matte_color']['#attached'] = [
      'library' => ['imagick/colorpicker'],
    ];
    $form['width'] = [
      '#type' => 'number',
      '#title' => $this->t('Width'),
      '#description' => $this->t('The width of the frame'),
      '#default_value' => $this->configuration['width'],
    ];
    $form['height'] = [
      '#type' => 'number',
      '#title' => $this->t('Height'),
      '#description' => $this->t('The height of the frame'),
      '#default_value' => $this->configuration['height'],
    ];
    $form['inner_bevel'] = [
      '#type' => 'number',
      '#title' => $this->t('Inner bevel'),
      '#description' => $this->t('The inner bevel of the frame'),
      '#default_value' => $this->configuration['inner_bevel'],
    ];
    $form['outer_bevel'] = [
      '#type' => 'number',
      '#title' => $this->t('Outer bevel'),
      '#description' => $this->t('The outer bevel of the frame'),
      '#default_value' => $this->configuration['outer_bevel'],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    parent::submitConfigurationForm($form, $form_state);

    $this->configuration['matte_color'] = $form_state->getValue('matte_color');
    $this->configuration['width'] = $form_state->getValue('width');
    $this->configuration['height'] = $form_state->getValue('height');
    $this->configuration['inner_bevel'] = $form_state->getValue('inner_bevel');
    $this->configuration['outer_bevel'] = $form_state->getValue('outer_bevel');
  }

}
