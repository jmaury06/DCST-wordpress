<?php
require_once('/code/wp-config.php');
global $wpdb;
$data= $wpdb->get_results("SELECT fields FROM wp_wpforms_entries");
$num_rows = $wpdb->num_rows;
$email = $_POST['email'];
//$email ='test444@test.com';
$response = 0;
$countFields=0;

for($i=0 ; $i < $num_rows ; $i++){
$fields = json_decode($data[$i]->fields);
$counter = 0;
    foreach($fields  as $key=>$f){
        if($counter == 1){
            if($f->value == $email ){
                $response = 1;
                $countFields=$i;
            }
        break;
        }
    $counter ++;
    }
}

if($response == 1)
{

     $fields = json_decode($data[$countFields]->fields);
    $counter = 0;
    foreach($fields  as $key=>$f){
        if($counter == 2){
            $access_token=md5($f->value);
            $url ="https://my.dacast.com/login?access_token=$access_token";
            echo $url;
        break;
        }
    $counter ++;
    }

}
else
{
	echo '0';
}
?>