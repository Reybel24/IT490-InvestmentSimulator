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
$request = file_get_contents('php://input');

// Decode from JSON into object
$request = json_decode($request, false);

// Make connection as client
# $client = new rabbitMQClient("testRabbitMQ.ini","testServer");

// Send request to rabbit server where it will be recieved on
// the other end of the "pipe" by testRabbitMQServer.php and
// read
# $response = $client->send_request($data);
# print_r($response);

// Temporarily run database queries here
function getAccountDetails($userID)
{
    // Get account details from database and add to respoonse
    return array(
        'fullName' => "Bob Jimbilly",
        'current_balance' => 578,
    );
}

function makeTransaction($userID, $trans_amt)
{
    $user_balance = 500; // grabbed from database
    $new_balance = $user_balance;
    $wasSuccess = false;
    
    if ($trans_amt <= $user_balance)
    {
        $new_balance = $user_balance + $trans_amt;
        $wasSuccess = true;
    }
    else
    {
        $new_balance = $user_balance;
        $wasSuccess = false;
    }
    
    return array(
        'wasSuccess' => $wasSuccess,
        'new_balance' => $new_balance,
    );
}

// tempoiarily placed here
function requestProcessor($request)
{
    $returnCode = 0;
    $response = [];
    $message = "";

    // Is there a request type?
    if(!isset($request->type))
    {
        $returnCode = "1";
        $message = "error";
    }
    else
    {
        // Perform appropriate action depending on type
        switch ($request->type)
        {
            // Authenticate
            case "login":
	            //echo "Login Request Sent...\n";
			    //$returnCode = 0;
			    $returnCode = doLogin($request->username, $request->password);
			    //echo $returnCode;
                //return doLogin($request['username'],$request['password']);
                break;
  
            // Account details
            case "account":
                $returnCode = 0;
                $message = "request recieved successfully";
                $payload = getAccountDetails($request->userID);
                break;

            case "profileValue":
                // do stuff here
                break;
            
            case "transaction":
                // do stuff here
                $returnCode = 0;
                $message = "request recieved successfully";
                $payload = makeTransaction($request->userID, $request->amount);
                break;

            // Session Validation
            case "validate_session":
                //return doValidate($request['sessionId']);
                break;

            default:
                // do nothing
                break;
        }
    }
    
    // Response
    $testResponse = array("returnCode" => $returnCode, 'message'=> $message, 'payload' => $payload);
    echo json_encode($testResponse);
}

// Process data
requestProcessor($request);
