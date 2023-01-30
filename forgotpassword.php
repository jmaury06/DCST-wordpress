<?php
 /*reated by PhpStorm.
 * User: quentinbenyahia
 * Date: 5/4/18
 * Time: 12:22 PM
 */
//$url = 'http://www.dacast.com/backend/login/remember/';
$url = 'api.dacast.com/v2/public/account/forgotpassword?secretkey=backend_pMdw7kNL478xjShT&async_call=false&email='.$_POST["email"];

//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch, CURLOPT_FAILONERROR, false);
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, True);
$content = curl_exec($ch);

$result['content'] = json_decode($content);


//close connection
curl_close($ch);

echo json_encode($result);

