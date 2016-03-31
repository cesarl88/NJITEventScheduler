<?php

  #include_once('DataBaseConnection.php');
  include_once 'EntityModel.php';
  $UserID = $_POST['UserID'];
  $db = new DBContext();

  $conditions = array('UserID' => $UserID );
 
  $event = $db->findAll(new Events(),$conditions);
  
  if($event)
  {	
  	$result = [];
  	foreach($event as $item)
  	{
  		$result[] = $item->getJSON();
/*   		$test = json_decode($item->getJSON(),true);
  		echo 'Title : '.$test['Title'].'<br/>'; */
  	}
  	/* $test = json_decode(json_encode(array('Events' => $result),JSON_PRETTY_PRINT),true);
  	echo 'Event[0] : '.$test['Events'][1].'<br/>'; */
	echo json_encode(array('Events' => $result),JSON_PRETTY_PRINT);;
  }
  else
  	echo json_encode(array('Events' => "-1"),JSON_PRETTY_PRINT);  
  /* $DatabaseConnection = new DataBaseConnection();
  #echo '<br/> getEventsbyWeek: ".$Date." <br/>';
  $events = $DatabaseConnection->getEventsbyDate($Date,$Approved);
  echo json_encode(json_decode($events,true),JSON_PRETTY_PRINT);
  $DatabaseConnection->disconnect(); */

?>
