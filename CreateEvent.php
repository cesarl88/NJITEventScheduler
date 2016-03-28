<?php

 # include_once('DataBaseConnection.php');
  include_once 'EntityModel.php';

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
 # echo $username;
  
  #$DatabaseConnection = new DataBaseConnection();
  
  #$Event = new Event(0,$title,date("Y-m-d",strtotime($startDate)),date("Y-m-d", strtotime($EndDate)), $startTime, $endTime, $Place, $Submitter, $UserID, $Organization, $eventname, $image, $link, $description,$Approved);
  
  $db = new DBContext();
  
  $Event = new Events();
  $Event->ID = 0;
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
  
  $db->add($Event);
  $db->saveChanges();
  $lastID = $db->getLastInsertedID();
  echo json_encode(array('EventID' => $lastID));
    /* $DatabaseConnection->insertEvent($Event);
  $DatabaseConnection->disconnect(); */

?>
