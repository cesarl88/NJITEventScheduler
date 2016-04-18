<?php
/**
 * Cesar Salazar
 * This files receives the information to update an specific event based on its ID
 */  
  include_once 'EntityModel.php';

  
  #echo $ID;
  
 // ini_set('display_errors', 'On');
//	error_reporting(E_ALL);
  
  $EventID = $_POST['EventID'];
  $google = $_POST['Google'];
  //var_dump($EventID);
 # var_dump($google);
  $db = new DBContext();
  $Event = $db->find(new Events(),array('ID' => $EventID));
  //var_dump($Event);
  if($Event)
  {
  	try{
  		$Event->addToGoogle = $google;
  		
  	#	 var_dump($Event->addToGoogle);
  		$db->update($Event);
  		$db->saveChanges();
  		echo json_encode(array('Result' => "1"),JSON_PRETTY_PRINT);
  	}
  	catch(Exception $ex)
  	{
  		echo json_encode(array('Result' => "-2"),JSON_PRETTY_PRINT);
  	}
  }
  else
  	echo json_encode(array('Result' => "-1"),JSON_PRETTY_PRINT);
  
/*   $DatabaseConnection = new DataBaseConnection();
  #echo '<br/> getEventsbyWeek: ".$Date." <br/>';
  $events = $DatabaseConnection->getEventByID($ID);
  echo json_encode(json_decode($events,true),JSON_PRETTY_PRINT);
  $DatabaseConnection->disconnect(); */
?>