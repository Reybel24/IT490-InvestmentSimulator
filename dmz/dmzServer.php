#!/usr/bin/php
<?php
header("Access-Control-Allow-Origin:*");
header("Access-Control-Allow-Methods:GET");
header("Access-Control-Allow-Header:Content-Type");
header("Access-Control-Allow-Credentials:true");

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
//require_once('publishLog.php');

//$crypto_base_url="https://min-api.cryptocompare.com/data";

function cryptoFetch_TopList($exchange) {
    $crypto_base_url="https://min-api.cryptocompare.com/data";
    $request_url = $crypto_base_url."/top/totalvolfull?limit=75"."&tsym=USD".$exchange;

    $ch = curl_init($request_url);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    $returnArray = curl_exec($ch);

    return $returnArray;
}

function cryptoFetch_price($exchange, $formatted_symbols, $currency) {
    $crypto_base_url="https://min-api.cryptocompare.com/data";
    $request_url = $crypto_base_url."/pricemulti?fsyms=".$formatted_symbols."&tsyms=".$currency.$exchange;

    $ch = curl_init($request_url);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    $returnArray = curl_exec($ch);

    return $returnArray;

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

    $testResponse = array("returnCode" => $returnCode, 'message'=> $message, 'payload' => $payload);
    return $testResponse;
}

// Listen for incoming data
$server = new rabbitMQServer("dmzRMQ.ini","testServer");

// Process data
$server->process_requests('requestProcessor');
exit();

?>
