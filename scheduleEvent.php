<?php

/**
 * Cesar Salazar
 * This file creates a mapping between the user and the event to be added to the data base
 * so the user can schedule an event
 */  
  include_once 'EntityModel.php';
  $UserID = $_POST['UserID'];
  $EventID = $_POST['EventID'];
  $db = new DBContext();
  
  $schedule = new Schedule();
  $schedule->UserID = $UserID;
  $schedule->EventID = $EventID;
  $schedule->dateModified = date("Y-m-d");
  #$today = getdate();
  #echo $schedule->dateModified;
  
 try{
 	$db->add($schedule);
 	$db->saveChanges();
 	echo json_encode(array('Result' => 1));
 }
 catch(Exception $e)
 {
 	echo json_encode(array('Result' => -1));
 }


 
?>
