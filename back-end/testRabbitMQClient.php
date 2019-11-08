<?php
// Don't touch this. Used for request.
header("Access-Control-Allow-Origin:*");
header("Access-Control-Allow-Methods:GET");
header("Access-Control-Allow-Headers:Content-Type");
header("Access-Control-Allow-Credentials:true");

// Dont touch this. Keeps that weird text up there from polluting response.
// if (ob_get_level()) {lll ob_end_clean(); ob_start(); }
// echo 'hey';
// Includesl
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

// Grab POST data sent by axios in front-end
$request = file_get_contents('php://input');

// Decode from JSON into object
// $request = json_decode($request, false);
// print_r($request);
// echo 'hi';
// Make connection as client
$client = new rabbitMQClient("testRabbitMQ.ini", "testServer");

// Send request to rabbit server where it will be recieved on
// the other end of the "pipe" by testRabbitMQServer.php and
// read
// echo $request;

$arr = array("type" => "login",
"username" => "user1",
"password" => "password"
);

$response = $client -> send_request($arr);
$response = json_encode($response);
print_r($response);
?>
