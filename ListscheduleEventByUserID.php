<?php
include_once 'EntityModel.php';
  $UserID = $_POST['UserID'];
 // $EventID = $_POST['EventID'];
  
#  echo "SELECT * FROM `Schedule` as sc inner join `Events` as e on sc.EventID = e.ID WHERE sc.UserID = ".$UserID;
  $db = new DBContext();
  $schedule = $db->findAll(new Schedule(),array('UserID' => $UserID));
 // $schedule = $db->findCustom(new Schedule(),"SELECT * FROM `Schedule` as sc inner join `Events` as e on sc.EventID = e.ID WHERE sc.UserID = ".$UserID);
  if($schedule)
  {
  /*	$result = [];
  	foreach($schedule as $item)
  	{
  		$result[] = $item->getJSON();
  		   		$test = json_decode($item->getJSON(),true);
  		 echo 'Title : '.$test['Title'].'<br/>'; 
  	}*/
  	echo json_encode(array('Event' => $schedule));
  }
  else
  {
  	echo json_encode(array('Event' => -1));
  }
 
?>
