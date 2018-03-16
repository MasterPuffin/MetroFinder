<head>
  <link rel="stylesheet" href="style_finder.css">
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
<script>
  document.getElementById("results").style.display = "none";
  document.getElementById("search").style.display = "none";
  function newSearch() {
    document.getElementById("search").style.display = "block";
    document.getElementById("results").style.display = "none";
  }
</script>
<body>
  <div id="search">
  Von
  <form action="finder.php" method="post" id="searchForm">
    <select name="from" id="selectFrom">
      <option value="11">Botanitscheski sad</option>
      <option value="1">Kiewskaja</option>
      <option value="9">Marjino</option>
      <option value="12">Medwedkowo</option>
      <option value="6">Park Podeby</option>
      <option value="3">Prospekt Mira</option>
      <option value="10">Reykjavik</option>
      <option value="8">Rimskaja</option>
      <option value="5">Tolstaya Veshch'</option>
      <option value="4">WDNCh</option>
    </select>
  <br>
  <br>
  Nach<br>
    <select name="to" id="selectTo">
      <option value="11">Botanitscheski sad</option>
      <option value="1">Kiewskaja</option>
      <option value="9">Marjino</option>
      <option value="12">Medwedkowo</option>
      <option value="6">Park Podeby</option>
      <option value="3">Prospekt Mira</option>
      <option value="10">Reykjavik</option>
      <option value="8">Rimskaja</option>
      <option value="5">Tolstaya Veshch'</option>
      <option value="4">WDNCh</option>
    </select>

    <br>
    <br>
    <input type="submit" value="Suchen">
  </form>
</div>
<?php
function stationName ($no) {
  $stations = array(
      1 => "Kiewskaja",
      3 => "Prospekt Mira",
      4 => "WDNCh",
      5 => "Tolstaya Veshch'",
      6 => "Park Podeby",
      8 => "Rimskaja",
      9 => "Marjino",
      10 => "Reykjavik",
      11 => "Botanitscheski sad",
      12 => "Medwedkowo",
  );
  return $stations[$no];
}

$lines = array
  (
    1 => array(1,3),
    2 => array(1,6,7,8,9,10),
    3 => array(1,4,11,12),
    4 => array(1,5)
  );

function plattform($station,$direction) {
  $plattforms = array
    (
      //Format: Richtung => Gleis
      //Kiewskaja
      1 => array(
        5 => 1, 12 => 2, 3 => 3, 10 => 4
      ),
      //Prospekt Mira
      3 => array(
        1 => 1, 1 => 2
      ),
      //WDNCh
      4 => array(
        1 => 1, 12 => 2
      ),
      //Tolstaya Veshch'
      5 => array(
        1 => 1, 1 => 2
      ),
      //Park Podeby
      6 => array(
        10 => 1, 1 => 2
      ),
      //Rimskaja
      8 => array(
        10 => 1, 1 => 1
      ),
      //Marjino
      9 => array(
        10 => 2, 1 => 1, 1 => 2
      ),
      //Reykjavik
      10 => array(
        1 => 1, 1 => 2
      ),
      //Botanitscheski sad
      11 => array(
        1 => 2, 12 => 1
      ),
      //Medwedkowo
      12 => array(
        1 => 1, 1 => 2
      )
    );
  return $plattforms[$station][$direction];
}

//Prüfe ob Stationen auf einer Linie
function finder($from, $to, $lines) {
  if ($from != $to) {
    echo "Von <b>" . stationName($from) . "</b> nach <b>" . stationName($to) . "</b>";
    echo "<br><hr><br>";
    foreach($lines AS $line => $partOfLine) {
      if (in_array($from, $partOfLine) && in_array($to, $partOfLine)) {
        finderDirect($from,$to,$lines);
        $sameLine = true;
        break;
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
      if ($line == 1) {
        echo '<linie1>Linie 1</linie1> Richtung <i>' . stationName($endPoint) . '</i>';
      } elseif ($line == 2) {
        echo '<linie2>Linie 2</linie2> Richtung <i>' . stationName($endPoint) . '</i>';
      } elseif ($line == 3) {
        echo '<linie3>Linie 3</linie3> Richtung <i>' . stationName($endPoint) . '</i>';
      } elseif ($line == 4) {
        echo '<linie4>Linie 4</linie4> Richtung <i>' . stationName($endPoint) . '</i>';
      }
      echo "<br>";
      echo "Abfahrt von Gleis " . plattform($from,$endPoint);
      echo "<br>";
      $noStations = abs(array_search($from, $lines[$line]) - array_search($to, $lines[$line]));
      if ($noStations == 1) {
        echo $noStations . " Station";
      } else {
        echo $noStations . " Stationen";
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
?>
<div id="results">
<?php
if (isset($_POST["from"]) && isset($_POST["to"])) {
  ?>
  <script>
    document.getElementById("search").style.display = "none";
  </script>

  <?php
  $from = $_POST["from"];
  $to = $_POST["to"];
  finder($from,$to,$lines);
  ?>
  <br>
 <button onclick="newSearch()">Neue Suche</button>
  <?php
} else {
 ?>
 <script>
   document.getElementById("search").style.display = "block";
 </script>
 <?php
}
  ?>
</div>
