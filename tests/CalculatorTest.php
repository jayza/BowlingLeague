<?php
namespace Jayza\BowlingLeague\Tests;

use Jayza\BowlingLeague\Backend\Calculator;

class CalculatorTest extends \PHPUnit_Framework_TestCase {

  public function setUp() {
    $this->calc = new Calculator();
  }

  public function testIfFrameIsStrike() {
    $frame_strike = array('X');
    $frame_spare = array('3', '/');

    $this->assertTrue($this->calc->isStrike($frame_strike));
    $this->assertFalse($this->calc->isStrike($frame_spare));
  }

  public function testIfFrameIsSpare() {
    $frame_strike = array('X');
    $frame_spare = array('3', '/');

    $this->assertTrue($this->calc->isSpare($frame_spare));
    $this->assertFalse($this->calc->isSpare($frame_strike));
  }

  public function testIfCalculationIsCorrect() {
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
    $this->calc->iterateFrames($frames_perfect);
    $this->assertEquals(300, $frames_perfect[9]['score']);

    // Should be 159.
    $this->calc->iterateFrames($frames_mixed);
    $this->assertEquals(159, $frames_mixed[9]['score']);

    // Should be 150.
    $this->calc->iterateFrames($frames_spare);
    $this->assertEquals(150, $frames_spare[9]['score']);
  }
}
