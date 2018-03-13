<?php
$from = $_POST["from"];
$to = $_POST["to"];

//echo $from;
//echo $to;

function stationName ($no) {
  $stations = array(
      1 => "Kiewskaja",
      2 => "Prospekt Mira (Fracht)",
      3 => "Prospekt Mira",
      4 => "WDNCh",
      5 => "Tolstaya Veshch'",
      6 => "Park Podeby",
      7 => "Park Podeby Kreuzung",
      8 => "Rimskaja",
      9 => "Marjino",
      10 => "Reykjavik",
  );
  return $stations[$no];
}

$lines = array
  (
    "Linie 1" => array(1,2,3),
    "Linie 2" => array(1,6,7,8,9,10),
    "Linie 3" => array(1,4),
    "Linie 4" => array(1,5)
  );

//Prüfe ob Stationen auf einer Linie
function finder($from, $to, $lines) {
  if ($from != $to) {
    foreach($lines AS $line => $partOfLine) {
      if (in_array($from, $partOfLine) && in_array($to, $partOfLine)) {
        finderDirect($from,$to,$lines);
        $sameLine = true;
        exit;
      } else {
        $sameLine = false;
      }
    }
    if (!$sameLine) {
      finderDirect($from,1,$lines);
      finderDirect(1,$to,$lines);
    }
  } else {
    echo "Start und Ziel sind identisch!";
  }
}

function finderDirect($from, $to, $lines) {
  foreach($lines AS $line => $partOfLine) {
    if (in_array($from, $partOfLine) && in_array($to, $partOfLine)) {
      echo "Von " . stationName($from);
      echo "<br>";
      //Richtung berechnen
      if (array_search($from, $partOfLine) < array_search($to, $partOfLine)) {
        $endPoint = array_values(array_slice($partOfLine, -1))[0];
      } else {
        $endPoint = current($partOfLine);
      }
      echo "Via " . $line . " Richtung " . stationName($endPoint);
      echo "<br>";
      echo "Nach " . stationName($to);
      echo "<br>";
      break;
    } else {
    }
  }
}

//Berechne Route
finder($from,$to,$lines);

 ?>
