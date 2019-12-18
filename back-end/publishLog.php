#!/usr/bin/php
<?php
require_once('../rabbitconfig/path.inc');
require_once('../rabbitconfig/get_host_info.inc');
require_once('../rabbitconfig/rabbitMQLib.inc');


function logError($errorLog){
  $client = new rabbitMQClient("loggerRMQ.ini","testServer");
  $machine_info = date("m-d-Y h:i:s", time())." ".gethostname()." ".$errorLog.PHP_EOL;


  $response = $client->publish($machine_info);

}

//$errorMessage = $argv[1];
//logError($errorMessage);

?>
