<?php
namespace Drupal\motionsplan_pdf;

use Motionsplan\Workout\WorkoutInterface;
use Drupal\node\NodeInterface;
use Drupal\motionsplan_pdf\ExerciseNodeAdapter;

class WorkoutNodeAdapter implements WorkoutInterface
{
  protected $node;
  public function __construct(NodeInterface $node) {
    $this->node = $node;
  }

  public function getTitle() {
    return $this->node->getTitle();
  }

  public function getIntroduction() {
    return $this->node->field_introduction->value;
  }

  public function getWarmupExercises() {
    $exercises = array();
    foreach ($this->node->field_warmup_exercises as $exercise) {
      $exercises[] = new ExerciseNodeAdapter($exercise->entity);
    }
    return $exercises;
  }

  public function getExercises() {
    $exercises = array();
    foreach ($this->node->field_exercises as $exercise) {
      $exercises[] = new ExerciseNodeAdapter($exercise->entity);
    }
    return $exercises;
  }
}
