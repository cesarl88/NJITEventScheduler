<?php

  #include_once('DataBaseConnection.php');
  include_once 'EntityModel.php';

  $ID = $_POST['ID'];
  #echo $ID;
  try
  {
    $db = new DBContext();
    $event = $db->find(new Events(),array('ID' => $ID));
    if($event)
    {	
      #echo 'found';
    	$db->remove($event);
    	$db->saveChanges();
    	echo json_encode(array('DeletedID' => $ID));
    	 
    }
    else 
    {
    	echo json_encode(array('DeletedID' => - 1));
    }
  }
  catch(Exception $ex)
  {
  //echo $ex->getMessage();
  echo json_encode(array('DeletedID' => - 2));
  }
  
  /* $DatabaseConnection = new DataBaseConnection();
  $DatabaseConnection->DeleteEvent($ID);
  $DatabaseConnection->disconnect(); */

?>
