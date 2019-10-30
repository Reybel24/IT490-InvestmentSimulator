#!/usr/bin/php
<?php
// Don't touch this. Used for request.
header("Access-Control-Allow-Origin:*");
header("Access-Control-Allow-Methods:GET");
header("Access-Control-Allow-Headers:Content-Type");
header("Access-Control-Allow-Credentials:true");

// Dont touch this. Keeps that weird text up there from polluting response.
if (ob_get_level()) { ob_end_clean(); ob_start(); }

// Includes
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

// Grab POST data sent by axios in front-end
$data = file_get_contents('php://input');

// Make connection as client
# $client = new rabbitMQClient("testRabbitMQ.ini","testServer");

// Send request to rabbit server where it will be recieved on
// the other end of the "pipe" by testRabbitMQServer.php and
// read
# $response = $client->send_request($data);
# print_r($response);

// temp - return this
echo($data);