<?php
  // set correct timezone !!!
  date_default_timezone_set('Europe/Berlin');
  // check token for client authentication
  $tok1 = "66efff4c945d3c3b87fc271b47d456db"; // md5(192.168.1.1)
  $token = htmlspecialchars($_GET["token"]);
  if($token!=$tok1) {
	exit(1);
  }

  $now = time();
  $filename = "logs/dht-".date("Ymd", $now).".txt";
  $value = $now.",".htmlspecialchars($_GET["value"])."\n";

  if(!file_exists($filename)) {
	touch($filename);
    file_put_contents($filename, "Time,Temperature,Humidity\n", FILE_APPEND);
  }
  file_put_contents($filename, $value, FILE_APPEND);
?>
