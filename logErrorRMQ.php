#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

$errorLog = $argv[1];

function logError($errorLog){
  $client = new rabbitMQClient("testRabbitMQ.ini","testServer");
  $machine_info = date("m-d-Y h:i:s", time())." "gethostname()." ".$errorLog.PHP_EOL;
  file_put_contents("/home/tmp/funswitherrors.txt", $machine_info, FILE_USE_INCLUDE_PATH | FILE_APPEND);

  $response = $client->publish($machine_info);

}
?>
