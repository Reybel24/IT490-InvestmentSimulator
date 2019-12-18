#!/usr/bin/php
<?php
header("Access-Control-Allow-Origin:*");
header("Access-Control-Allow-Methods:GET");
header("Access-Control-Allow-Header:Content-Type");
header("Access-Control-Allow-Credentials:true");

require_once('../rabbitconfig/path.inc');
require_once('../rabbitconfig/get_host_info.inc');
require_once('../rabbitconfig/rabbitMQLib.inc');
require_once('publishLog.php');

$crypto_base_url="https://min-api.cryptocompare.com/data";

function cryptoFetch_TopList($crypto_base_url, $exchange) {
    $request_url = $crypto_base_url."/top/totalvolfull?limit=75"."&tsym=USD".$exchange;
    return $request_url;
}

function cryptoFetch_price($crypto_base_url, $exchange, $formatted_symbols, $currency) {
    $request_url = $crypto_base_url."/pricemulti?fsyms=".$formatted_symbols."&tsyms=".$currency.$exchange;
    return $request_url;
}

function requestProcessor($request) {
    print_r($request);

    $returnCode = 0;
    $response = [];
    $message = "";
    $payload = "";

    switch ($request['type']) {
        // Authenticate
        case "fetchTopList":
            $returnCode = 0;
            $message = "request recieved successfully";
            $payload = cryptoFetch_TopList($request['exchange']);
            break;
        case "fetchPrice":
            $returnCode = 0;
            $message = "request recieved successfully";
            $payload = cryptoFetch_price($request['exchange'], $request['formatted_symbols'], $request['currency']);
            break;

        case "error":
            $returnCode = 0;
            //$message = "$request['msg']";
            //$payload = logError($request['error']);
            break;
        default:
            // do nothing
            break;
    }
}

// Listen for incoming data
$server = new rabbitMQServer("testRabbitMQ.ini","testServer");

// Process data
$server->process_requests('requestProcessor');
exit();

?>
