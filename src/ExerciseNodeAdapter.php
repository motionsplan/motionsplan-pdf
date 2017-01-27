<?php

namespace Drupal\motionsplan_pdf;

use Motionsplan\Exercise\ExerciseInterface;
use Drupal\node\NodeInterface;
use Drupal\motionsplan_pdf\ExerciseImageAdapter;

class ExerciseNodeAdapter implements ExerciseInterface
{
  protected $node;

  function __construct(NodeInterface $node) {
    $this->node = $node;
  }

  public function getTitle() {
    return $this->node->getTitle();
  }

  public function getCues() {
    return 'My cues';
  }

  public function getIntroduction() {
    return $this->node->field_introduction->value;
  }

  public function getDescription() {
    return $this->node->field_description->value;
  }

  public function getUrl() {
    global $base_url;
    return $base_url . $this->node->url();
  }

  /**
   * return array with ImageInterface[]
   */
  public function getImages() {
    $images = array();
    foreach ($this->node->field_images as $image) {
      $images[] = new ExerciseImageAdapter($image->entity);
    }
    return $images;
  }

  public function getBarCode() {
    return null;
  }
}
