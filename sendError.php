#!/usr/bin/php
<?php
require_once('logErrorRMQ.php');

$errorMessage = $argv[1];
logError($errorMessage);

?>
