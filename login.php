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
    $fields_string .= $key.'='.urlencode($val).'&'; 
}
$fields_string = rtrim($fields_string, '&');

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

curl_close($ch);

$jsonResponse = json_decode($content);

if(isset($jsonResponse->code) ) {

    $ch2 = curl_init();

    if($_POST["preprod"]) {
        $urlVoD = 'https://api-test.dacast.com/v2/login/advancedvod';
    } else {
        $urlVoD = 'https://api.dacast.com/v2/login/advancedvod';
    }

    $fieldsVod = array(
        'email' => $_POST["login"],
        'password' => $_POST["password"]
    );
    
    $fieldsvod_string ="";
    foreach($fieldsVod as $key=>$val) { 
        $fieldsvod_string .= $key.'='.urlencode($val).'&'; 
    }
    $fieldsvod_string = rtrim($fieldsvod_string, '&');

    curl_setopt($ch2, CURLOPT_FAILONERROR, false);
    curl_setopt($ch2,CURLOPT_URL, $urlVoD);
    curl_setopt($ch2,CURLOPT_POST, count($fieldsVod));
    curl_setopt($ch2,CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch2,CURLOPT_POSTFIELDS, $fieldsvod_string);
    curl_setopt($ch2, CURLOPT_FOLLOWLOCATION, True);
    $contentVod = curl_exec($ch2);

    if(curl_getinfo($ch2, CURLINFO_HTTP_CODE) == '400') {
        $result['content']['error'] = true;
        $result['content']['platform'] = 'vod';

    } else {
        $result['content'] = json_decode($contentVod);
        $result['content']->platform = 'vod';
    }
    

    curl_close($ch2);
    echo json_encode($result);

} else {
    
    $result['content'] = json_decode($content);
    $result['content']->platform = 'live';

    //close connection


    echo json_encode($result);
}