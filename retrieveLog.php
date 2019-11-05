#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');


function errorLogProcessor($errorLog)
{
	echo "received error log".PHP_EOL;
	file_put_contents("home/tmp/funwitherrors.txt", $errorLog.PHP_EOL, FILE_USE_INCLUDE_PATH | FILE_APPEND);

}

$server = new rabbitMQServer("loggerRMQ.ini","testServer");

$server->process_requests('errorLogProcessor');
exit();
?>
