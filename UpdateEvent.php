<?php

  #include_once('DataBaseConnection.php');
  
  include_once 'EntityModel.php';

  $ID = $_POST['ID'];

  
  #echo $ID;
  
  $UserID = $_POST['UserID'];
  $title = $_POST['title'];
  $startDate = $_POST['startDate'];
  $EndDate = $_POST['EndDate'];
  $startTime = $_POST['startTime'];
  $endTime = $_POST['endTime'];
  $Place = $_POST['Place'];
  $Submitter = $_POST['Submitter'];
  $Organization = $_POST['Organization'];
  $eventname = $_POST['eventname'];
  $image = $_POST['image'];
  $link = $_POST['link'];
  $description = $_POST['description'];
  $Approved = $_POST['Approved'];
  
  if(!isset($Approved))
  	$Approved = 'FALSE';
  

  $db = new DBContext();
  $Event = $db->find(new Events(),array('ID' => $ID));
  
  if($Event)
  {
  	try{
  		$Event->Title = $title;
  		$Event->startDate = date("Y-m-d",strtotime($startDate));
  		$Event->EndDate = date("Y-m-d", strtotime($EndDate));
  		$Event->startTime = $startTime;
  		$Event->endTime = $endTime;
  		$Event->Place = $Place;
  		$Event->Submitter = $Submitter;
  		$Event->UserID = $UserID;
  		$Event->Organization = $Organization;
  		$Event->EventName = $eventname;
  		$Event->Image = $image;
  		$Event->link = $link;
  		$Event->Description = $description;
  		$Event->Approved = $Approved;
  		 
  		$db->update($Event);
  		$db->saveChanges();
  	}
  	catch(Exception $ex)
  	{
  		
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