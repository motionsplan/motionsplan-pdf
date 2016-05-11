<?php

namespace Drupal\motionsplan_pdf\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\NodeInterface;
// Use for exerciseSimplePdf.
use Motionsplan\Exercise\Pdf\Portrait;
use Drupal\motionsplan_pdf\ExerciseNodeAdapter;
// Use for workoutPdf.
use Motionsplan\Workout\Html;
use Drupal\motionsplan_pdf\WorkoutNodeAdapter;
use Dompdf\Dompdf;

/**
 * Controller for Pdfs.
 */
class PdfController extends ControllerBase {

  /**
   * {@inheritdoc}
   */
  public function exerciseSimplePdf(NodeInterface $node) {

    /*
    $term = taxonomy_term_load($node->field_exercise_category[LANGUAGE_NONE][0]['tid']);
    $hex = $term->field_category_color[LANGUAGE_NONE][0]['rgb'];
    $rgb = hex2rgb($hex);

    $title = utf8_decode($node->title);
    */

    $adapter = new ExerciseNodeAdapter($node);

    $file_path = \Drupal::service('file_system')->realpath(file_default_scheme() . "://");
    $pdf = new Portrait();
    $pdf->setTemporaryDirectory($file_path);
    //$pdf->setTitleBackgroundColor($rgb);
    $pdf->SetTitle($adapter->getTitle());
    $pdf->SetSubject('');
    $pdf->SetAuthor('Motionsplan.dk');
    $pdf->AddNewPage($adapter);
    $pdf->Output($adapter->getTitle() . '.pdf', 'I');
    exit;
  }

  /**
   * {@inheritdoc}
   */
  public function workoutPdf(NodeInterface $node)
  {
    $adapter = new WorkoutNodeAdapter($node);

    $html = new Html($adapter);
    $html->getPdf()->stream('workout.pdf', array('Attachment' => 0));
    exit;
  }
}
