<?php
require_once('/code/wp-config.php');
global $wpdb;
$data= $wpdb->get_results("SELECT fields FROM wp_wpforms_entries");
$num_rows = $wpdb->num_rows;
$email = $_POST['email'];
$response = 0;
for($i=0 ; $i < $num_rows ; $i++){
$fields = json_decode($data[$i]->fields);
$counter = 0;
    foreach($fields  as $key=>$f){
        if($counter == 1){
            if($f->value == $email ){
                $response = 1;
            }

        break;
        }
    $counter ++;
    }
}

echo $response;
?>