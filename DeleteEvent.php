<?php

  #include_once('DataBaseConnection.php');
  include_once 'EntityModel.php';

  $ID = $_POST['ID'];
  #echo $ID;
  $db = new DBContext();
  $event = $db->find(new Events(),array('ID' => $ID));
  if($event)
  {	
  	$db->remove($event);
  	$db->saveChanges();
  	echo json_encode(array('DeletedID' => $ID));
  	 
  }
  else 
  {
  	echo json_encode(array('DeletedID' => - 1));
  }
  /* $DatabaseConnection = new DataBaseConnection();
  $DatabaseConnection->DeleteEvent($ID);
  $DatabaseConnection->disconnect(); */

?>
