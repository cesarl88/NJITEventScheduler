<?php

  /**
 * Cesar Salazar
 * This file gets event based on the given ID
 */  
  include_once 'EntityModel.php';

  $ID = $_POST['ID'];

  
  #echo $ID;
  

  $db = new DBContext();
  $event = $db->find(new Events(),array('ID' => $ID));
  
  if($event)
  {
  	echo json_encode(array('Event' => json_decode($event->getJSON())),JSON_PRETTY_PRINT);
  }
  else
  	echo json_encode(array('Event' => "-1"),JSON_PRETTY_PRINT);
  
/*   $DatabaseConnection = new DataBaseConnection();
  #echo '<br/> getEventsbyWeek: ".$Date." <br/>';
  $events = $DatabaseConnection->getEventByID($ID);
  echo json_encode(json_decode($events,true),JSON_PRETTY_PRINT);
  $DatabaseConnection->disconnect(); */

?>