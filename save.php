<?php

session_start();
$start = microtime(true); // Время начала исполнения скрипта
$validX = array(-5, -4, -3, -2, -1, 0, 1, 2, 3);
$r = floatval(htmlspecialchars($_GET["r"]));
$x = floatval(htmlspecialchars($_GET["x"]));
$y = floatval(htmlspecialchars($_GET["y"]));
date_default_timezone_set("Europe/Moscow");
$current_time = date("H:i:s");
$message = "";
$class = "No";

$int_value = is_numeric($r) ? floatval($r) : null;
if ($int_value === null)
{
// $value wasn't all numeric
}

$int_value = is_numeric($y) ? floatval($y) : null;
if ($int_value === null)
{
// $value wasn't all numeric
}

if ((($x <= 0 && $y >= 0 && 4*($x*$x+$y*$y) <= $r*$r)) ||
     ($x <= 0 && $y <= 0 && ($x + $y >= -$r/2)) ||
     ($x >= 0 && $y <= 0 && abs($x) <= $r && abs($y) <= $r/2)) {
  $message = "Yes";
  $class = "Yes";
} else {
  $message = "No";
}

if (!is_null($r) && !is_null($x) && !is_null($y)) {
  if ($r == 0 && $x == 0 && $y == 0) {
    $message = "Insert Data";
  } else {
    if ($r > 4 || $r < 1) {
      $message = "Invalid R";
    }
    if (!in_array($x, $validX)) {
      $message = "Invalid X";
    }
    if ($y > 3 || $y < -3) {
      $message = "Invalid Y";
    }
  }



  $time = strval(number_format(microtime(true) - $start, 10, ".", "")*1000) . 'ms';

  // Сохранение в сессию
  $result = array($x, $y, $r, $message, $time, $current_time);
  if (!isset($_SESSION['results'])) {
    $_SESSION['results'] = array();
  }
  array_push($_SESSION['results'], $result);

  // Печать в таблицу
  print_r('<tr><td>'.$x.'</td><td>'.$y.'</td><td>'.$r.'</td><td class="'.$class.'">'.$message.'</td><td>'.$time.'</td><td>'.$current_time.'</td></tr>');

}

?>
