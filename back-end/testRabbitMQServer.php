#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('login.php.inc');

// Authentication
function doLogin($username,$password)
{
	//echo "Connecting to database... \n";
	// lookup username in database
    // check password
		//return curlDBLogin($username,$password);
		$login = new loginDB();
    return $login->validateLogin($username,$password);
}

function getAccountInfo($data)
{
  // Run database sql query to find user information and add to response
  $response = [];

}

function requestProcessor($request)
{
  echo "received request".PHP_EOL;
  //var_dump($request);

  // Is there a request type?
  if(!isset($request['type']))
  {
    return "ERROR: unsupported message type";
  }

  // Perform appropriate action depending on type
  switch ($request['type'])
  {
    // Authenticate
    case "login":
	    echo "Login Request Sent...\n";
			//$returnCode = 0;
			$returnCode = doLogin($request['username'],$request['password']);
			echo $returnCode;

      //return doLogin($request['username'],$request['password']);
      break;
  
    // Account details
    case "account":
      getAccountInfo($request);
      $returnCode = -1;
      break;

    case "profileValue":
      // do stuff here
      break;

    // Session Validation
    case "validate_session":
      //return doValidate($request['sessionId']);
      break;

    default:
      // do nothing
      break;
  }

  return array("returnCode" => $returnCode, 'message'=>"Server received request and processed", 'payload' => $response);
}

// Listen for incoming data
# $server = new rabbitMQServer("testRabbitMQ.ini","testServer");

// Process data
# $server->process_requests('requestProcessor');

exit();
?>
