<?php
include_once 'EntityModel.php';
  $UserID = $_POST['UserID'];
  $EventID = $_POST['EventID'];

  $db = new DBContext();
  $GoogleCalendar = $db->find(new GoogleCalendar(),array('EventID' => $EventID, 'UserID' => $UserID));
  
  if($GoogleCalendar)
  {
  		echo json_encode(array('Result' => 1));
 	}
  else
  	{
  		echo json_encode(array('Result' => -1));
  	}
  	
  
 
?>