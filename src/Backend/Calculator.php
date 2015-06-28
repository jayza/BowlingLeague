<?php
namespace Jayza\BowlingLeague\Backend;

class Calculator {
  protected $scoreboard;

  /**
   * Iteration function for frames that are going to be calculated.
   * @param $frames An array containing the current state of frames.
   * @return string Frames are returned as JSON. 
   */
  public function iterateFrames(&$frames) {
    $this->scoreboard = $frames;

    for ($i = 0; $i < count($frames); $i++) {
      $this->calculateFrame($i, $frames[$i]);
    }

    $frames = $this->scoreboard;

    return json_encode($frames);
  }

  /**
   * This function calculates one frame. 
   * @param $id Current frame id.
   * @param $primary_frame Current frame data.
   */
  private function calculateFrame($id, $primary_frame) {
    $score = $primary_frame[0] + $primary_frame[1];

    // If secondary frame is a strike.
    if ($this->isStrike($this->scoreboard[$id - 1])) {

      // If tertiary frame is a strike.
      if ($this->isStrike($this->scoreboard[$id - 2])) {
        // Base score after two strikes.
        $tertiary_score = 20;

        // Calculate what the tertiary frame score is according to primary frame's score.
        $tertiary_score += ($this->isStrike($primary_frame)) ? 10 : $primary_frame[0];

        // Set tertiary frame score.
        $this->scoreboard[$id - 2]['score'] = $this->scoreboard[$id - 3]['score'] + $tertiary_score;
      }

      if ($this->isStrike($primary_frame)) {
        $secondary_score = NULL;
      }
      else {
        // Base score after one strike.
        $secondary_score = 10;

        // Calculate what the secondary frame score is according to primary frame's score.
        $secondary_score += ($this->isSpare($primary_frame)) ? 10 : $score;
        
        // Set secondary frame score
        $this->scoreboard[$id - 1]['score'] = $this->scoreboard[$id - 2]['score'] + $secondary_score;
      }
    } 
    // If secondary frame is a spare.
    elseif ($this->isSpare($this->scoreboard[$id - 1])) {
      // Base score after one spare.
      $secondary_score = 10;

      // Calculate what the secondary frame score is according to primary frame's score.
      $secondary_score += ($this->isStrike($primary_frame)) ? 10 : $primary_frame[0];

      // Set secondary frame score.
      $this->scoreboard[$id - 1]['score'] = $this->scoreboard[$id - 2]['score'] + $secondary_score;
    }

    /*
     * If primary frame is either a strike or spare, set to NULL.
     * Otherwise set primary score to current frame score.
     */ 
    if ($this->isSpare($primary_frame) || $this->isStrike($primary_frame)) {
      $score = NULL;
    }
    
    // If current frame is the last frame.
    if ($id == 9) {
      if ($this->isStrike($primary_frame)) {
        $score = 10;
        
        // Set 9th frame to add 30 points if statement works.
        if ($primary_frame[0] == 'X' && $primary_frame[1] == 'X' && $this->isStrike($this->scoreboard[$id - 1])) {
          $this->scoreboard[$id - 1]['score'] = $this->scoreboard[$id - 2]['score'] + 30;
        }

        // If 10th frame is a perfect frame add 30 points.
        if ($primary_frame[1] == 'X' && $primary_frame[2] == 'X') {
          $score += 20;
        }
        
        // Calculate score if 10th frame and 3rd window has a spare. Otherwise adds score of first two windows.
        if ($primary_frame[2] == '/') {
          $score += 10;
        } else {
          $score += $primary_frame[1] + $primary_frame[2];
        }
        
      }
      elseif ($this->isSpare($primary_frame)) {
        $score = 10 + $primary_frame[2];
      }
    }

    $score = $this->scoreboard[$id - 1]['score'] + $score;

    // Insert back in to the scoreboard after calculating.
    $primary_frame = array($primary_frame[0], $primary_frame[1], $primary_frame[2], 'score' => $score);
    $this->scoreboard[$id] = $primary_frame;
  }

  /**
   * Checks whether or not the input frame is a strike.
   * @param $frame An array which contains the frame data.
   * @return bool Returns true or false.
   */
  public function isStrike($frame) {
    if ($frame[0] == 'X')
      return true;

    return false;
  }

  /**
   * Checks whether or not the input frame is a spare.
   * @param $frame An array which contains the frame data.
   * @return bool Returns true or false.
   */
  public function isSpare($frame) {
    if ($frame[1] == '/')
      return true;

    return false;
  }
}
