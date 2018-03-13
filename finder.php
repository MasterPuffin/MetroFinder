<head>
  <link rel="stylesheet" href="style.css">
  <link rel="icon" href="https://www.endorwind.de/wp-content/uploads/2017/08/icon1.png" sizes="192x192" />
  <title>endorwind Minecraft Server</title>
</head>
<style>
linie1 {
  color: #fff;
  background-color: #FF8000;
  padding-left: 4px;
  padding-right: 4px;
}
linie2 {
  color: #fff;
  background-color: #97CB16;
  padding-left: 4px;
  padding-right: 4px;
}
linie3 {
  color: #fff;
  background-color: #007FFF;
  padding-left: 4px;
  padding-right: 4px;
}
linie4 {
  color: #fff;
  background-color: #7F00FF;
  padding-left: 4px;
  padding-right: 4px;
}
</style>
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
    echo "Von <b>" . stationName($from) . "</b> nach <b>" . stationName($to) . "</b>";
    echo "<br><hr><br>";
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
      echo "<br>";
      finderDirect(1,$to,$lines);
    }
  } else {
    echo "Start und Ziel sind identisch!";
  }
}

function finderDirect($from, $to, $lines) {
  foreach($lines AS $line => $partOfLine) {
    if (in_array($from, $partOfLine) && in_array($to, $partOfLine)) {
      echo "Ab <b>" . stationName($from) . "</b>";
      echo "<br>";
      //Richtung berechnen
      if (array_search($from, $partOfLine) < array_search($to, $partOfLine)) {
        $endPoint = array_values(array_slice($partOfLine, -1))[0];
      } else {
        $endPoint = current($partOfLine);
      }
      if ($line == "Linie 1") {
        echo '<linie1>Linie 1</linie1> Richtung <i>' . stationName($endPoint) . '</i>';
      } elseif ($line == "Linie 2") {
        echo '<linie2>Linie 2</linie2> Richtung <i>' . stationName($endPoint) . '</i>';
      } elseif ($line == "Linie 3") {
        echo '<linie3>Linie 3</linie3> Richtung <i>' . stationName($endPoint) . '</i>';
      } elseif ($line == "Linie 4") {
        echo '<linie4>Linie 4</linie4> Richtung <i>' . stationName($endPoint) . '</i>';
      }
      echo "<br>";
      echo "An <b>" . stationName($to) . "</b>";
      echo "<br>";
      break;
    } else {
    }
  }
}

//Berechne Route
finder($from,$to,$lines);

 ?>
