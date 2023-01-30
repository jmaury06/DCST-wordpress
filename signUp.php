<?php
/**
 * Created by PhpStorm.
 * User: quentinbenyahia
 * Date: 5/4/18
 * Time: 12:22 PM
 */
//$url = 'http://www.dacast.com/backend/login/remember/';
$url = 'api.dacast.com/v2/mngt/account/signup?secretkey=backend_pMdw7kNL478xjShT&async_call=false';
function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = null;
    return $ipaddress;
}
$fields_string = "";
$fields_string_captcha = "";

//Captcha Check
$fieldsCaptcha = array(
    'response'       => $_POST["captchaToken"],
    'secret'         => "6LfgXLsUAAAAAONTVCpPDSDOg2RtaOPOizKliNiR",
);

foreach($fieldsCaptcha as $key=>$val) { $fields_string_captcha .= $key.'='.$val.'&'; }
rtrim($fields_string_captcha, '&');

//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch, CURLOPT_FAILONERROR, false);
curl_setopt($ch,CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
curl_setopt($ch,CURLOPT_POST, count($fieldsCaptcha));
curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string_captcha);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, True);
$content = curl_exec($ch);
$result2 = json_decode($content);

if($result2->success) {
    
    $fields = array(
        'email'             => $_POST["email"],
        'full_name'         => $_POST["full_name"],
        'telephone'         => $_POST["telephone"],
        'password'          => $_POST["password"],
        'company_url'       => $_POST["company_url"],
        'cloudamp__data__c' => $_POST["cloudamp__data__c"],
        'ip'                => get_client_ip(),
        'gclid'             => $_POST["gclid"],
    );

    foreach($fields as $key=>$val) { $fields_string .= $key.'='.$val.'&'; }
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
} else {
    $resultFail['content']['error'] = "Captcha challenge failed";
    echo json_encode($resultFail);
}




