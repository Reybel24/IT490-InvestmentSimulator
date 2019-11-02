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


function createAccount($username,$password,$fname,$lname){

    $db = mysqli_connect("127.0.0.1", "root", "12345", "homedb");
    if (!$db) {
        die("Connection failed: " . mysqli_connect_error());
    }

    //Create new account
    $sql= "INSERT INTO accounts (username, password , fname, lname)
VALUES ('$username','$password','$fname','$lname')";

if (mysqli_query($db, $sql)) {
    echo "New record created successfully";

} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($db);
}

mysqli_close($db);


$db = mysqli_connect("127.0.0.1", "root", "12345", "homedb");
    if (!$db) {
        die("Connection failed: " . mysqli_connect_error());
    }


$sql2= "SELECT * from accounts where username= '$username'";


$result = mysqli_query($db, $sql2);

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        
        $userID=$row['userid'];
        echo "$userID";
    }
}
    else{
         echo " No results";

    }
mysqli_close($db);



$db = mysqli_connect("127.0.0.1", "root", "12345", "homedb");
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

//Inserts new row in Portfolio with userid from accounts table
$sql3= "INSERT INTO portfolio(userid) 
SELECT userid FROM accounts WHERE userid='$userID'";

if (mysqli_query($db, $sql3)) {
    echo "New record created successfully";


} else {
    echo "Error: " . $sql3 . "<br>" . mysqli_error($db);
}

mysqli_close($db);



$db = mysqli_connect("127.0.0.1", "root", "12345", "homedb");
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

//Sets balance for new user to 500 dollars and portfolio value zero

$sql4= "UPDATE portfolio SET available_balance= 500, portfolio_value=0
WHERE userid= '$userID'";

if (mysqli_query($db, $sql4)) {
    echo "Balance added";

} else {
    echo "Error updating record: " . mysqli_error($db);
}
        return array(
            "userID" => $userID,
            "username" => $username,
            "firstname"=> $fname,
            "lastname"=>$lname,
            "password" => $password,
    );

mysqli_close($db);
}
//TO test
createAccount('user578','password','byy','byy');




function getAccountDetails($userID)
{
    //MUST CHANGE DATABASE CREDENTIALS
    $db = mysqli_connect("127.0.0.1", "root", "12345", "homedb");
    if (!$db) {
        die("Connection failed: " . mysqli_connect_error());
    }

    
    $sql= "SELECT accounts.userid, accounts.username, accounts.fname, accounts.lname, 
    portfolio.available_balance , investments.base_currency, investments.target_currency,
    amount_invested
    FROM accounts 
    LEFT JOIN portfolio on accounts.userid = portfolio.userid 
    LEFT JOIN investments on portfolio.portfolio_id = investments.portfolio_id
    WHERE accounts.userid='$userID'";
  

$result = mysqli_query($db, $sql);

if (mysqli_num_rows($result) > 0) {


    while($row = mysqli_fetch_assoc($result)) {
      

        //To show output from for account details

        echo "userid: " . $row["userid"].
         "username: " . $row["username"]. 
         "First name: " . $row["fname"].
        "Last Name: " . $row["lname"]. 
        "Balance " . $row["available_balance"]. 
        "Currency " . $row["base_currency"]. 
        "Target Currency " . $row["target_currency"]. 
        "Invested" . $row["amount_invested"]. 
        "<br>";




// Variables for array
       $userID= $row['userid'];
        $username = $row['username'];
        $fname = $row['fname'];
        $lname = $row['lname'];
        $fullname = $row['fname']." ".$row['lname'];
        $balance = $row['available_balance'];
        $baseCurrency = $row['base_currency'];
        $targerCurrency = $row['target_currency'];
        $amtInvested = $row['amount_invested'];

    }
}
else {
    echo "0 results";
}
    //Get account details from database and add to respoonse
    return array(
        "fullName" => $fullname,
        "userID" => $userID,
        "username" => $username,
        "current_balance" => $balance,
        "base_currency" => $baseCurrency,
        "target_currency" => $targetCurrency,
        "amount_invested" => $amtInvested,
   
    );

 mysqli_close($db);

}
// //To test
// $data= getAccountDetails(1);
// $data;



function makeTransaction($userID, $trans_amt)
{
      //MUST CHANGE DATABASE CREDENTIALS
    $db = mysqli_connect("127.0.0.1", "root", "12345", "homedb");
    if (!$db) {
        die("Connection failed: " . mysqli_connect_error());
    }

$sql= "SELECT * from portfolio Where userid='$userID'";

    $result = mysqli_query($db, $sql);

if (mysqli_num_rows($result) > 0) {

    while($row = mysqli_fetch_assoc($result)) {

        $user_balance= $row['available_balance'];

                 
        echo "$user_balance";
        echo "<br>";
        

    $new_balance = $user_balance;
    $wasSuccess = false;
    
    if ($trans_amt <= $user_balance)
    {
        $new_balance = $user_balance + $trans_amt;
        $wasSuccess = true;

        $sql2= "UPDATE portfolio SET available_balance= $new_balance 
        WHERE userid= '$userID'";
        
         $result2 = mysqli_query($db, $sql2);

         echo " New Balance:";
         echo "<br>";
         echo "$new_balance";
    }
    else
    {
        $new_balance = $user_balance;
        $wasSuccess = false;

        $sql2= "UPDATE portfolio SET available_balance= $new_balance 
        WHERE userid= '$userID'";
        $result2 = mysqli_query($db, $sql2);
    }


    }
}
else {
    echo "0 results";
}

return array(
    'wasSuccess' => $wasSuccess,
    'new_balance' => $new_balance,
);
   

 mysqli_close($db);

}

////To Test

// makeTransaction(1,100);


   

function testQuery($userID)
{
     //MUST CHANGE DATABASE CREDENTIALS       
    $db = mysqli_connect("127.0.0.1", "root", "12345", "homedb");
            if (!$db) {
                die("Connection failed: " . mysqli_connect_error());
            }
            
            $sql= "SELECT accounts.userid, accounts.username, accounts.fname, accounts.lname, 
            portfolio.available_balance 
            FROM accounts LEFT JOIN portfolio on  accounts.userid = portfolio.portfolio_id 
            WHERE accounts.userid='$userID'";
        
        $result = mysqli_query($db, $sql);
        
        if (mysqli_num_rows($result) > 0) {
        
        
            while($row = mysqli_fetch_assoc($result)) {
              
                //To show output from for account details
    
                echo "fullname: " . $row["fname"]. " "
                . $row["lname"]. " ". 
                "Balance " . $row["available_balance"].
                "<br>";
        
        
        // Variables for array
        $nameFromDB = $row['fname']." ".$row['lname'];
        $balance = $row['available_balance'];

        
            }
        }
        else {
            echo "0 results";
        }
            //Get account details from database and add to respoonse
            return array(
                'fullName' => $nameFromDB,
                'current_balance' => $balance,
            );
        
            mysqli_close($db);
        
        }

////  To test       
// testQuery(1);



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

            case "test":
                $returnCode = 0;
                $message = "request recieved successfully";
                $payload = testQuery($request->userID);
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



?>