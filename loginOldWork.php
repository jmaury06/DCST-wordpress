<?php
/**
 * Created by PhpStorm.
 * User: quentinbenyahia
 * Date: 5/4/18
 * Time: 12:22 PM
 */
//$url = 'http://www.dacast.com/backend/login/remember/';
$url = 'https://services.dacast.com/auth/basic/session';

$fields = array(
    'email' => $_POST["login"],
    'password' => $_POST["password"],
    'remember' => $_POST["remember"]
);

$fields_string ="";
foreach($fields as $key=>$val) { 
    $fields_string .= $key.'='.$val.'&'; 
}
rtrim($fields_string, '&');

//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch, CURLOPT_FAILONERROR, false);
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_POST, count($fields));
curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, True);
$content = curl_exec($ch);

$result['content'] = json_decode($content);


//close connection
curl_close($ch);

echo json_encode($result);
