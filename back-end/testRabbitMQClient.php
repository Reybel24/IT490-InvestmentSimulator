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
# $client = new rabbitMQClient("testRabbitMQ.ini", "testServer");

// Send request to rabbit server where it will be recieved on
// the other end of the "pipe" by testRabbitMQServer.php and
// read
# $response = $client -> send_request($data);
# print_r($response);

// Temporarily run database queries here
function getDBCon() {
    $db = mysqli_connect("127.0.0.1", "root", "", "crypto_1");
    if (!$db) {
        die("Connection failed: ".mysqli_connect_error());
    }
    return $db;
}

function createAccount($username, $password, $fname, $lname) {

    $db = mysqli_connect("127.0.0.1", "root", "", "crypto_1");
    if (!$db) {
        die("Connection failed: ".mysqli_connect_error());
    }

    //Create new account
    $sql = "INSERT INTO accounts (username, password , fname, lname)
    VALUES('$username', '$password', '$fname', '$lname')";

    if (mysqli_query($db, $sql)) {
        echo "New record created successfully";

    } else {
        echo "Error: ".$sql. "<br>".mysqli_error($db);
    }

    mysqli_close($db);


    $db = mysqli_connect("127.0.0.1", "root", "12345", "homedb");
    if (!$db) {
        die("Connection failed: ".mysqli_connect_error());
    }


    $sql2 = "SELECT * from accounts where username= '$username'";


    $result = mysqli_query($db, $sql2);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {

            $userID = $row['userid'];
            echo "$userID";
        }
    }
    else {
        echo " No results";

    }
    mysqli_close($db);



    $db = mysqli_connect("127.0.0.1", "root", "12345", "homedb");
    if (!$db) {
        die("Connection failed: ".mysqli_connect_error());
    }

    //Inserts new row in Portfolio with userid from accounts table
    $sql3 = "INSERT INTO portfolio(userid) 
    SELECT userid FROM accounts WHERE userid = '$userID'";

    if (mysqli_query($db, $sql3)) {
        echo "New record created successfully";


    } else {
        echo "Error: ".$sql3. "<br>".mysqli_error($db);
    }

    mysqli_close($db);



    $db = mysqli_connect("127.0.0.1", "root", "12345", "homedb");
    if (!$db) {
        die("Connection failed: ".mysqli_connect_error());
    }

    //Sets balance for new user to 500 dollars and portfolio value zero

    $sql4 = "UPDATE portfolio SET available_balance= 500, portfolio_value=0
    WHERE userid = '$userID'";

    if (mysqli_query($db, $sql4)) {
        echo "Balance added";

    } else {
        echo "Error updating record: ".mysqli_error($db);
    }
    return array(
        "userID" => $userID,
        "username" => $username,
        "firstname"=> $fname,
        "lastname"=> $lname,
        "password" => $password,
    );

    mysqli_close($db);
}
//TO test
//createAccount('user578','password','byy','byy');




function getAccountDetails($userID) {
    $username = "";
    $fname = "";
    $lname = "";
    $fullname = "";
    $balance = "";
    $baseCurrency = "";
    $targetCurrency = "";
    $amtInvested = "";

    //MUST CHANGE DATABASE CREDENTIALS
    $db = mysqli_connect("127.0.0.1", "root", "", "crypto_1");
    if (!$db) {
        die("Connection failed: ".mysqli_connect_error());
    }


    $sql = "SELECT accounts.userid, accounts.username, accounts.fname, accounts.lname, 
    portfolio.available_balance, investments.base_currency, investments.target_currency,
        amount_invested
    FROM accounts
    LEFT JOIN portfolio on accounts.userid = portfolio.userid
    LEFT JOIN investments on portfolio.portfolio_id = investments.portfolio_id
    WHERE accounts.userid = '$userID'";


    $result = mysqli_query($db, $sql);

    if (mysqli_num_rows($result) > 0) {

        while ($row = mysqli_fetch_assoc($result)) {

            //To show output from for account details
            /*
                    echo "userid: " . $row["userid"].
                     "username: " . $row["username"]. 
                     "First name: " . $row["fname"].
                    "Last Name: " . $row["lname"]. 
                    "Balance " . $row["available_balance"]. 
                    "Currency " . $row["base_currency"]. 
                    "Target Currency " . $row["target_currency"]. 
                    "Invested" . $row["amount_invested"]. 
                    "<br>";
            */

            // Look user up in portfolio table and grab portfolio_id
            // using that portfolio id, grab all investments and add to array

            // Variables for array
            $userID = $row['userid'];
            $username = $row['username'];
            $fname = $row['fname'];
            $lname = $row['lname'];
            $fullname = $row['fname']." ".$row['lname'];
            $balance = $row['available_balance'];
            $baseCurrency = $row['base_currency'];
            $targetCurrency = $row['target_currency'];
            $amtInvested = $row['amount_invested'];

        }
        
        // Grab all investments belonging to profile id
        $investments = [];

        // Prepare and execute query
        $sql = "SELECT * from portfolio Where userid='$userID'";
        $result = mysqli_query($db, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {

                // Grab portfolio ID
                $portfolio_id = $row['portfolio_id'];
                //$wasSuccess = true;

                // Use portfolio ID to grab all investments
                $sql = "SELECT * from investments Where portfolio_id='$portfolio_id'";
                $result_2 = mysqli_query($db, $sql);
                if (mysqli_num_rows($result_2) > 0) {
                    while ($row = mysqli_fetch_assoc($result_2)) {
                        
                        // item
                        $invest = array(
                            "base_currency" => $row['base_currency'],
                            "target_currency" => $row['target_currency'],
                            "amount_invested" => $row['amount_invested'],
                        );

                        // Insert into investments
                        array_push($investments, $invest);
                    }
                }
            }
        }
        } else {
            // Do nothing
            $investments = -1;
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
        "investments" => $investments,

    );

    mysqli_close($db);

}



// Transaction
function makeTransaction($userID, $trans_details) {
    
    // Get database connection
    $db = getDBCon();

    // Query
    $sql = "SELECT * from portfolio Where userid='$userID'";
    $result = mysqli_query($db, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {

            // Grab portfolio ID
            $portfolio_id = $row['portfolio_id'];

            $user_balance = $row['available_balance'];
            $new_balance = $user_balance + $trans_details->amount;

            $wasSuccess = true;

            $sql2 = "UPDATE portfolio SET available_balance= $new_balance 
            WHERE userid = '$userID'";

            $result2 = mysqli_query($db, $sql2);

            // Coin
            $coin_symbol = $trans_details->base_currency;
            $coin_target = $trans_details->target_currency;
            $coin_amount = $trans_details->coinAmount;

            // Update investments
            // Check if row exists. If so, update it.
            $sql = "SELECT * from investments Where portfolio_id='$portfolio_id' AND base_currency='$coin_symbol'";
            $result = mysqli_query($db, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    // Update existing row
                    $sql = "UPDATE investments SET amount_invested = amount_invested + $coin_amount 
                    WHERE portfolio_id = '$portfolio_id' AND base_currency='$coin_symbol'";
                    mysqli_query($db, $sql);
                }
            } else {
                // Insert new row
                $sql = "INSERT INTO investments (investment_id, portfolio_id, base_currency, target_currency, amount_invested)
                VALUES(default, '$portfolio_id', '$coin_symbol', '$coin_target', '$coin_amount')";
                mysqli_query($db, $sql);
            }
        }
    }
    else {
        // echo "0 results";
    }

    return array(
        'wasSuccess' => $wasSuccess,
        'new_balance' => $new_balance,
    );


    mysqli_close($db);

}

////To Test

// makeTransaction(1,100);

function doLogin($username, $password) {

    // Get database connection
    $db = getDBCon();

    $sql = "SELECT * from accounts Where username='$username' AND password='$password'";
    $result = mysqli_query($db, $sql);

    $success = false;
    $userID = "";
    $message = "";

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $userID = $row["userid"];
            $success = true;
        }
    } else {
        $message = "User does not exist.";
    }

    //Get account details from database and add to respoonse
    return array(
        'success' => $success,
        'userID' => $userID,
        'message' => $message,
    );
}


function testQuery($userID) {
    //MUST CHANGE DATABASE CREDENTIALS       
    $db = mysqli_connect("127.0.0.1", "root", "12345", "homedb");
    if (!$db) {
        die("Connection failed: ".mysqli_connect_error());
    }

    $sql = "SELECT accounts.userid, accounts.username, accounts.fname, accounts.lname, 
    portfolio.available_balance
    FROM accounts LEFT JOIN portfolio on  accounts.userid = portfolio.portfolio_id
    WHERE accounts.userid = '$userID'";

    $result = mysqli_query($db, $sql);

    if (mysqli_num_rows($result) > 0) {


        while ($row = mysqli_fetch_assoc($result)) {

            //To show output from for account details

            echo "fullname: ".$row["fname"]. " "
                .$row["lname"]. " ". 
                "Balance ".$row["available_balance"].
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


// tempoiarily placed here
function requestProcessor($request) {
    $returnCode = 0;
    $response = [];
    $message = "";

    // Is there a request type?
    if (!isset($request -> type)) {
        $returnCode = "1";
        $message = "error";
    }
    else {
        // Perform appropriate action depending on type
        switch ($request -> type) {
            // Authenticate
            case "login":
                $returnCode = 0;
                $message = "request recieved successfully";
                $payload = doLogin($request -> username, $request -> password);
                break;

            // Account details
            case "account":
                $returnCode = 0;
                $message = "request recieved successfully";
                $payload = getAccountDetails($request -> userID);
                break;

            case "profileValue":
                // do stuff here
                break;

            case "transaction":
                // do stuff here
                $returnCode = 0;
                $message = "request recieved successfully";
                $payload = makeTransaction($request -> userID, $request -> details);
                break;

            // Session Validation
            case "validate_session":
                //return doValidate($request['sessionId']);
                break;

            case "test":
                $returnCode = 0;
                $message = "request recieved successfully";
                $payload = testQuery($request -> userID);
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