<?php
//To test the CRON is running or NOT




//SalesForce Connection
define("SOAP_CLIENT_BASEDIR", "sf_lib/soapclient/");
include SOAP_CLIENT_BASEDIR.'SforcePartnerClient.php';
include SOAP_CLIENT_BASEDIR.'SforceHeaderOptions.php';
//SF user LOGIN
include 'sf_lib/userAuth.php';

$mySforceConnection = new SforcePartnerClient();
//$mySoapClient = $mySforceConnection->createConnection(SOAP_CLIENT_BASEDIR.'partner.wsdl.xml');
$mySoapClient = $mySforceConnection->createConnection('/code/integration/GoogleAds_SF/sf_lib/soapclient/partner.wsdl.xml');

$mylogin = $mySforceConnection->login($USERNAME, $PASSWORD);
//SalesForce Connection

 $Date = date("Y-m-d\TH:i:s");
//IF CONVERSION FILES ALREADY EXISTS THEN FIRST DELETE IT
if(file_exists("/files/cron/conversions/Conversion.csv")){
    
    unlink("/files/cron/conversions/Conversion.csv");
	
}

//CONVESRSION CSV HEADERS
$listParam = array (
  array("Parameters:TimeZone=US/Eastern", "" ,"", "","")
);
        						    
        						    
$list1 = array (
  array("Google Click ID", "Conversion Name" ,"Conversion Time", "Conversion Value","Conversion Currency")
);
$list=array();


//GET THE CONTACTS DATA FROM SALESFORCE
	$queryLFV = "SELECT Id,CreatedDate  from Contact Where CreatedDate= YESTERDAY and (cloudamp__gclid__c !=null or cloudamp__Last_gclid__c !=null) and Plan_Type__c!=null";
	$responseLFV = $mySforceConnection->query($queryLFV);

	
	foreach ($responseLFV->records as $recordLFV) {
		$DateTimeString = str_replace(".000Z","",$recordLFV->any);
		$DateTimeString = str_replace("<sf:CreatedDate>","",$DateTimeString);
		$DateTimeString = str_replace("</sf:CreatedDate>","",$DateTimeString);
		
		
		
		$ConID= $recordLFV->Id[0];
		 $CnqueryLFV = "SELECT cloudamp__gclid__c, cloudamp__Last_gclid__c from Contact Where Id= '$ConID'";
		$ConresponseLFV = $mySforceConnection->query($CnqueryLFV);
		foreach ($ConresponseLFV->records as $ConrecordLFV) {
			$GclidVal = $ConrecordLFV->any; echo "</br>";
		   
			$GclidVal = str_replace("<sf:cloudamp__Last_gclid__c>","",$GclidVal);
			$GclidVal = str_replace('<sf:cloudamp__Last_gclid__c xsi:nil="true"/>',"",$GclidVal);
			$GclidVal = str_replace('</sf:cloudamp__Last_gclid__c>',"",$GclidVal);
		  
		   
		   
			$GclidVal = str_replace("<sf:cloudamp__gclid__c>","",$GclidVal);
			$GclidVal = str_replace('<sf:cloudamp__gclid__c xsi:nil="true"/>',"",$GclidVal);
			$GclidVal = str_replace('</sf:cloudamp__gclid__c>',"",$GclidVal);
			
				$CnqueryLFVPlan = "SELECT Plan_Type__c from Contact Where Id= '$ConID'";
				$ConresponseLFVPlan = $mySforceConnection->query($CnqueryLFVPlan);
				foreach ($ConresponseLFVPlan->records as $ConrecordLFVPlan) {
					//print_r($ConrecordLFVPlan->any);
					
					$Plan = $ConrecordLFVPlan->any;
					$Plan = str_replace("<sf:Plan_Type__c>","",$Plan);
					$Plan = str_replace("</sf:Plan_Type__c>","",$Plan);
					//echo"PLAN==>>". $Plan; echo "</br>";
					
					if($Plan == 'Monthly Starter'){
						$Plan = 'Stackmatix - Monthly Starter';
					}
					
					if($Plan == 'Annual Starter'){
						$Plan = 'Stackmatix - Annual Starter';
					}
					
					if($Plan == 'Monthly Premium'){
						$Plan = 'Stackmatix - Monthly Premium';
					}
					
					if($Plan == 'Annual Premium'){
						$Plan = 'Stackmatix - Annual Premium';
					}
					
					if($Plan == 'Event'){
						$Plan = 'Stackmatix - Event';
					}
					
					if($Plan == 'Monthly Enterprise'){
						$Plan = 'Stackmatix - Monthly Enterprise';
					}
					
					if($Plan == 'Annual Enterprise'){
						$Plan = 'Stackmatix - Annual Enterprise';
					}
        						    
					$listPush = 
					array("$GclidVal", "$Plan" ,"$DateTimeString", "","");

					array_push($list,$listPush);
					
        						    
				}
						    
		}
						
						
						
						
						/*$CnqueryLFVPlan = "SELECT Plan_Type__c from Contact Where Id= '$ConID'";
					$ConresponseLFVPlan = $mySforceConnection->query($CnqueryLFVPlan);
						foreach ($ConresponseLFVPlan->records as $ConrecordLFVPlan) {
						    print_r($ConrecordLFV);
						}*/
	}
					//GENERATE MAIN CONVERSION CSV FILE WITH BACKUP FILE
    					if(sizeof($list) > 0){
    					    $file = fopen("/files/cron/conversions/Conversion.csv","w");
    					
                            foreach ($listParam as $listParamline) {
                              fputcsv($file, $listParamline);
                            }
                            
                            foreach ($list1 as $line1) {
                              fputcsv($file, $line1);
                            }
                            foreach ($list as $line) {
                              fputcsv($file, $line);
                            }
                        
                            fclose($file);
                            
                            
                            
                            $fileBK = fopen("/files/cron/conversions/ConversionBK - ".date("Y-m-d H:i:s").".csv","w");
    					
                            foreach ($listParam as $listParamline) {
                              fputcsv($fileBK, $listParamline);
                            }
                            
                            foreach ($list1 as $line1) {
                              fputcsv($fileBK, $line1);
                            }
                            foreach ($list as $line) {
                              fputcsv($fileBK, $line);
                            }
                        
                            fclose($fileBK);
                            
                            /*if(file_exists("Conversion.csv")){
                                //echo "file exists";
                                unlink("Conversion.csv");
                            }*/
                            
    					}else{
    					    
    					    
    					     $fileZero = fopen("/files/cron/conversions/Conversion.csv","w");
    					
                            foreach ($listParam as $listParamline) {
                              fputcsv($fileZero, $listParamline);
                            }
                            
                            foreach ($list1 as $line1) {
                              fputcsv($fileZero, $line1);
                            }
                            fclose($fileZero);
                            
                            
                            
                            
                            
                            $fileBKZero = fopen("/files/cron/conversions/ConversionBK - ".date("Y-m-d H:i:s").".csv","w");
    					
                            foreach ($listParam as $listParamline) {
                              fputcsv($fileBKZero, $listParamline);
                            }
                            
                            foreach ($list1 as $line1) {
                              fputcsv($fileBKZero, $line1);
                            }
                            fclose($fileBKZero);
    					}

?>