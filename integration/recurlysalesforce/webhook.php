<?php

//GET DATA FROM RECURLY WEBHOOK
 $entityBody = file_get_contents('php://input');

//SalesForce Connection
define("SOAP_CLIENT_BASEDIR", "soapclient/");
include SOAP_CLIENT_BASEDIR.'SforcePartnerClient.php';
include SOAP_CLIENT_BASEDIR.'SforceHeaderOptions.php';
//SF USER LOGIN
include 'userAuth.php';

$mySforceConnection = new SforcePartnerClient();
$mySoapClient = $mySforceConnection->createConnection(SOAP_CLIENT_BASEDIR.'partner.wsdl.xml');

$mylogin = $mySforceConnection->login($USERNAME, $PASSWORD);

$sxe = new SimpleXMLElement($entityBody);


//CHECK NOTIFICATION TYPE

if($sxe->getName() == 'successful_payment_notification'){ //CHECK NOTIFICATION TYPE
    
	$ob= simplexml_load_string($entityBody);
	$DataWebHook = json_decode(json_encode($ob),true);
	
		//foreach($DataWebHook as $Row){
			$FirstName = '';
		    
            $FirstName = $DataWebHook['account']['first_name'];echo "</br>";
            $LastName = $DataWebHook['account']['last_name'];echo "</br>";
			//$FirstName = '';
			if($FirstName == '' || is_array($FirstName)){
				$FirstName = "(FirstName='[not provided]' or FirstName='')";
			}else{
				$FirstName = "FirstName='".$FirstName."'";
			}
			
			
			if($LastName == '' || is_array($LastName)){
				$LastName = "(LastName='[not provided]' or LastName='')";
			}else{
				$LastName = "LastName='".$LastName."'";
			}
			//First Search In SF Contact
            $Email = $DataWebHook['account']['email'];
            
			$query = "SELECT Id from Contact Where ".$FirstName." and ".$LastName." and Email='".$Email."'";
			
            $response = $mySforceConnection->query($query);
            
			if(!empty($response->records)){
				
				foreach ($response->records as $record) {
				
					$queryLFV = "SELECT Id,Invoiced_total__c from Contact Where Id='".$record->Id[0]."'";
					$responseLFV = $mySforceConnection->query($queryLFV);
					
					
					foreach ($responseLFV->records as $recordLFV) {
						
					
						 $CustomerLifeTimeValueSF = $recordLFV->any; 
						 
						 if (strpos($CustomerLifeTimeValueSF, '<sf:Invoiced_total__c>') !== false) {
							$CustomerLifeTimeValueSF = str_replace("<sf:Invoiced_total__c>","",$CustomerLifeTimeValueSF);
						}
						 
						 
						 if (strpos($CustomerLifeTimeValueSF, '</sf:Invoiced_total__c>') !== false) {
							$CustomerLifeTimeValueSF = str_replace("</sf:Invoiced_total__c>","",$CustomerLifeTimeValueSF);
						}
						 
						 
						 if (strpos($CustomerLifeTimeValueSF, '<sf:Invoiced_total__c xsi:nil="true"/>') !== false) {
							$CustomerLifeTimeValueSF = str_replace('<sf:Invoiced_total__c xsi:nil="true"/>',"",$CustomerLifeTimeValueSF);
						}
						 
	
						if($CustomerLifeTimeValueSF == ''){
						   $CustomerLifeTimeValueSF = 0.00; 
						}
							   
								
						$Subscription = $DataWebHook['transaction'];
						
						$TotalAmount = 0.00; 
						$TotalAmount = $DataWebHook['transaction']['amount_in_cents']; 
						
						$TotalAmount = number_format($TotalAmount/100, 2, '.', '');
						$CustomerLifeTimeValueSF1 = $CustomerLifeTimeValueSF + $TotalAmount;
						
	
						
						//Update IN SALESFORCE
						$fields = array (
							'Id' =>  $record->Id[0],
							'Invoiced_total__c' => $CustomerLifeTimeValueSF1
						);
						
						$sObject = new SObject();
						$sObject->fields = $fields;
						$sObject->type = 'Contact';
						//print_r($sObject);
						
						try {
								
							  $createResponse = $mySforceConnection->update(array($sObject));
							  if($createResponse[0]->success== "1"){
								  
								  
								  
							  }else{
								  
							  }
						  
						}catch (Exception $e){
					
							  echo $mySforceConnection->getLastRequest();
							  $getLastRequest = $mySforceConnection->getLastRequest();
							  echo $e->faultstring;
							  
							  $faultstring = $e->faultstring;
							  
							  
							  exit;
						
						}
					}
				}
			}else{
				//Search In SF Lead IF NOt FOund IN SF Contact
				
				
				
				
				$Leadquery = "SELECT Id from Lead Where ".$FirstName." and ".$LastName." and Email='".$Email."'";
				
				
				
				$responseLead = $mySforceConnection->query($Leadquery);
				
				if(!empty($responseLead->records)){
				
				foreach ($responseLead->records as $record) {
				
					$queryLFV = "SELECT Id,Invoiced_total__c from Lead Where Id='".$record->Id[0]."'";
					$responseLFV = $mySforceConnection->query($queryLFV);
					
					
					foreach ($responseLFV->records as $recordLFV) {
						
					
						 $CustomerLifeTimeValueSF = $recordLFV->any; echo "</br>";
						 
						 if (strpos($CustomerLifeTimeValueSF, '<sf:Invoiced_total__c>') !== false) {
							$CustomerLifeTimeValueSF = str_replace("<sf:Invoiced_total__c>","",$CustomerLifeTimeValueSF);
						}
						 
						 
						 if (strpos($CustomerLifeTimeValueSF, '</sf:Invoiced_total__c>') !== false) {
							$CustomerLifeTimeValueSF = str_replace("</sf:Invoiced_total__c>","",$CustomerLifeTimeValueSF);
						}
						 
						 
						 if (strpos($CustomerLifeTimeValueSF, '<sf:Invoiced_total__c xsi:nil="true"/>') !== false) {
							$CustomerLifeTimeValueSF = str_replace('<sf:Invoiced_total__c xsi:nil="true"/>',"",$CustomerLifeTimeValueSF);
						}
						 

						if($CustomerLifeTimeValueSF == ''){
						   $CustomerLifeTimeValueSF = 0.00; 
						}
							   
								
						$Subscription = $DataWebHook['transaction'];
						
						$TotalAmount = 0.00;
						$TotalAmount = $DataWebHook['transaction']['amount_in_cents']; 
						
						$TotalAmount = number_format($TotalAmount/100, 2, '.', '');
						$CustomerLifeTimeValueSF1 = $CustomerLifeTimeValueSF + $TotalAmount;
						
						
						
						//Update IN SALESFORCE
						$fields = array (
							'Id' =>  $record->Id[0],
							'Invoiced_total__c' => $CustomerLifeTimeValueSF1
						);
						
						$sObject = new SObject();
						$sObject->fields = $fields;
						$sObject->type = 'Lead';
						//print_r($sObject);
						
						try {
								
							  $createResponse = $mySforceConnection->update(array($sObject));
							  if($createResponse[0]->success== "1"){
								  
								  
								  
							  }else{
								  
							  }
						  
						}catch (Exception $e){
					
							  echo $mySforceConnection->getLastRequest();
							  $getLastRequest = $mySforceConnection->getLastRequest();
							  echo $e->faultstring;
							  
							  $faultstring = $e->faultstring;
							  
							  
							  exit;
						
						}
					}
				}
			}
			}
        //}
}

?>