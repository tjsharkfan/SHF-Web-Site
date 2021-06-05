<?php 
  //phpinfo(); 
  /* 
  date_default_timezone_set ( "America/Los Angeles" );
  echo "2020-11-09T02:14:02Z,<br>";
  echo date('Y-m-d H:i:s', strtotime("2020-11-09T02:14:02Z"));
  echo "<br>";
  $dt = new DateTime("2020-11-09T02:14:02Z", new DateTimeZone('UTC'));
  var_dump($dt->format("Y-m-d H:i:s"));
  echo "<br>";
  $dt->setTimezone(new DateTimeZone('America/Los Angeles'));
  echo "<br>";

  echo $dt->format('Y-m-d H:i:s');
  echo "<br>";
 */
echo "Try this<br>";
$date = '2020-11-09T02:14:02Z';
echo $date . "<br>";
$l10nDate = new DateTime($date, new DateTimeZone('UTC'));
$l10nDate->setTimeZone(new DateTimeZone('America/Vancouver'));
echo $l10nDate->format('Y-m-d H:i:s');
?>
