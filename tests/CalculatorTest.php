<?php
namespace Jayza\BowlingLeague\Tests;

use Jayza\BowlingLeague\Calculator;

class CalculatorTest extends \PHPUnit_Framework_TestCase {
  public function testIfFrameIsStrike() {
    $bowl = new Calculator();

    $frame_strike = array('X');
    $frame_spare = array('3', '/');

    $this->assertTrue($bowl->isStrike($frame_strike));
    $this->assertFalse($bowl->isStrike($frame_spare));
  }

  public function testIfFrameIsSpare() {
    $bowl = new Calculator();

    $frame_strike = array('X');
    $frame_spare = array('3', '/');

    $this->assertTrue($bowl->isSpare($frame_spare));
    $this->assertFalse($bowl->isSpare($frame_strike));
  }

  public function testIfCalculationIsCorrect() {
    $bowl = new Calculator();

    $frames_perfect = array(
      array('X'),
      array('X'),
      array('X'),
      array('X'),
      array('X'),
      array('X'),
      array('X'),
      array('X'),
      array('X'),
      array('X', 'X', 'X')
    );

    $frames_mixed = array(
      array('3', '6'),
      array('X'),
      array('2', '/'),
      array('5', '4'),
      array('9', '/'),
      array('2', '7'),
      array('X'),
      array('X'),
      array('5', '/'),
      array('X', '5', '/')
    );

    $frames_spare = array(
      array('5', '/'),
      array('5', '/'),
      array('5', '/'),
      array('5', '/'),
      array('5', '/'),
      array('5', '/'),
      array('5', '/'),
      array('5', '/'),
      array('5', '/'),
      array('5', '/', '5')
    );

    // Should be 300.
    $bowl->iterateFrames($frames_perfect);
    $this->assertEquals(300, $frames_perfect[9]['score']);

    // Should be 159.
    $bowl->iterateFrames($frames_mixed);
    $this->assertEquals(159, $frames_mixed[9]['score']);

    // Should be 150.
    $bowl->iterateFrames($frames_spare);
    $this->assertEquals(150, $frames_spare[9]['score']);
  }
}
