<?php
function curlDBLogin($username, $password){
$url = '192.168.1.103/hello.php';
echo "curl file run\n";
$fields = [
  'username' => $username,
  'password' => $password
];

$fields_string = http_build_query($fields);

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($ch);
print_r($result);

return $result;
}
?>
