<?php

/**
 * Cesar Salazar
 * This file gets list of events in a week based on the given date 
 */  
include_once 'EntityModel.php';
  try{
  	
  	$keyWord = $_POST['keyWord'];
  	
  	if(!isset($keyWord))
  	{
  		echo json_encode(array('Events' => "-3"),JSON_PRETTY_PRINT);;
  		return;
  	}
  	$db = new DBContext();
  	
  	$query = "SELECT * FROM `Events` WHERE `Title` like '%".$keyWord."%' or `Place` like '%".$keyWord."%' or `Submitter` like '%".$keyWord."%' or `Organization` like '%".$keyWord."%' or `EventName` like '%".$keyWord."%' or `Description` like '%".$keyWord."%'";
  	
  	//echo $query."<br/>";
  	
  	$event = $db->findCustom(new Events(),$query);
  	
  	if($event)
  	{
  		$result = [];
  		foreach($event as $item)
  		{
  			$result[] = $item->getJSON();
  		}
  		echo json_encode(array('Events' => $result),JSON_PRETTY_PRINT);;
  	}
  	else
  		echo json_encode(array('Events' => "-1"),JSON_PRETTY_PRINT);
  }
  catch(Exception $e)
  {
  	
  	echo json_encode(array('Events' => "-2"),JSON_PRETTY_PRINT);
  }

  #echo $username;
  
  /* $DatabaseConnection = new DataBaseConnection();
  #echo '<br/> getEventsbyWeek: ".$Date." <br/>';
  $events = $DatabaseConnection->getEventsbyWeek($Date,$Approved);
  echo json_encode(json_decode($events,true),JSON_PRETTY_PRINT);
  $DatabaseConnection->disconnect();
 */
?>
