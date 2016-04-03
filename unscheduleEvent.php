<?php
include_once 'EntityModel.php';
  $UserID = $_POST['UserID'];
  $EventID = $_POST['EventID'];

  $db = new DBContext();
  $schedule = $db->find(new Schedule(),array('EventID' => $EventID, 'UserID' => $UserID));
  
  if($schedule)
  {
  	try{
  		$db->remove($schedule);
  		$db->saveChanges();
  		echo json_encode(array('Result' => 1));
  	}
  	catch(Exception $e)
  	{
  		echo json_encode(array('Result' => -1));
  	}
  	
  }
 
?>
