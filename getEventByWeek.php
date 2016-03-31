<?php

  #include_once('DataBaseConnection.php');
include_once 'EntityModel.php';
  $Date = $_POST['Date'];
  $Approved = $_POST['Approved'];
  
  
  $UserID = $_POST['UserID'];
  $db = new DBContext();
  
  if(isset($UserID))
  {
  	$query = "select e.* from Events e cross join (select min(startDate) as nextdate from Events where startDate >= Date '".$Date."' and Approved = ".$Approved." and UserID = ".$UserID.") em where e.startDate between em.nextdate and date_add(em.nextdate, interval 1 week) and Approved = ".$Approved.";";
  }
  else
  {
  	$query = "select e.* from Events e cross join (select min(startDate) as nextdate from Events where startDate >= Date '".$Date."' and Approved = ".$Approved.") em where e.startDate between em.nextdate and date_add(em.nextdate, interval 1 week) and Approved = ".$Approved.";";
  }
  $event = $db->findCustom(new Events(),$query);
  
   if($event)
  {
  	$result = [];
  	foreach($event as $item)
  	{
  		$result[] = $item->getJSON();
  	}
  	echo json_encode(array('Events' => $result),JSON_PRETTY_PRINT);;
  }
  else
  	echo json_encode(array('Events' => "-1"),JSON_PRETTY_PRINT); 
  #echo $username;
  
  /* $DatabaseConnection = new DataBaseConnection();
  #echo '<br/> getEventsbyWeek: ".$Date." <br/>';
  $events = $DatabaseConnection->getEventsbyWeek($Date,$Approved);
  echo json_encode(json_decode($events,true),JSON_PRETTY_PRINT);
  $DatabaseConnection->disconnect();
 */
?>
