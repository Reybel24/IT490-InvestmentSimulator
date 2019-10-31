#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('login.php.inc');
require_once('logError.php');
//require_once('funwithcurl.php');
function doLogin($username,$password)
{
	//echo "Connecting to database... \n";
	// lookup username in database
    // check password
		//return curlDBLogin($username,$password);
		$login = new loginDB();
    return $login->validateLogin($username,$password);

}

function requestProcessor($request)
{
	echo "received request".PHP_EOL;
  var_dump($request);
  if(!isset($request['type']))
  {
    return "ERROR: unsupported message type";
  }
  switch ($request['type'])
  {
    case "login":
	    echo "Login Request Sent...\n";
			//$returnCode = 0;
			$returnCode = doLogin($request['username'],$request['password']);
			echo $returnCode;

			//return doLogin($request['username'],$request['password']);

    case "validate_session":
			//return doValidate($request['sessionId']);
		case "error_log":
			echo "receiving error from ".$request['machine_name'];
			$returnCode = writeLogMessage($request['time'], $request['machine_name'], $request['error_message']);
				//return doValidate($request['sessionId']);
  }

  return array("returnCode" => $returnCode, 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("testRabbitMQ.ini","testServer");

$server->process_requests('requestProcessor');
exit();
?>
