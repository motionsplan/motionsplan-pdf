<?php

namespace Drupal\motionsplan_pdf;

use Motionsplan\Exercise\ExerciseImageInterface;

class ExerciseImageAdapter implements ExerciseImageInterface
{
  protected $image;
  protected $path;

  public function __construct($file) {
    $this->path = $file->getFileUri();
    $this->image = \Drupal::service('image.factory')->get($this->path);
    if (!$this->image->isValid()) {
      throw new \Exception('Image does not exist on given path.');
    }
  }

  public function getPath() {
    return \Drupal::service('file_system')->realpath($this->path);
  }

  public function getOrientation() {
    if ($this->image->getWidth() > $this->image->getHeight()) {
      return 'landscape';
    }
    else if ($this->image->getHeight() > $this->image->getWidth()) {
      return 'portrait';
    }
    return 'square';
  }
}
