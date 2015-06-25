<?php
namespace Jayza\BowlingLeague;

include 'src/Calculator.php';

use Jayza\BowlingLeague\Backend\Calculator;

$frames = array(
  array('X'),
  array('X'),
  array('X'),
  array('X'),
  array('X'),
  array('X'),
  array('X'),
  array('X'),
  array('X'),
  array('X', 'X', 'X', 'score' => NULL)
);

$frames = array(
  array('3', '6'),
  array('X'),
  array('2', '/'),
  array('5', '4'),
  array('9', '/'),
  array('2', '7'),
  array('X'),
  array('X'),
  array('5', '/'),
  array('X', '5', '/', 'score' => NULL)
);

$frames = array(
  array('5', '/'),
  array('5', '/'),
  array('5', '/'),
  array('5', '/'),
  array('5', '/'),
  array('5', '/'),
  array('5', '/'),
  array('5', '/'),
  array('5', '/'),
  array('5', '/', '5', 'score' => NULL)
);

$bwl = new Calculator();

echo "<pre>";
$bwl->iterateFrames($frames);
var_dump($frames);