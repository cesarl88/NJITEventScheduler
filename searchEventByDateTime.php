
<?php
/**
 * Cesar Salazar
 * This file gets list of events in based on the key word 
 */  
include_once 'EntityModel.php';
  try{
  	//echo "hey";
  	$date = $_POST['Date'];
  	$startTime = $_POST['StartTime'];
    $endTime = $_POST['EndTime'];
  	
    if(!isset($date) or !isset($startTime) or !isset($endTime))
  	{
  		echo json_encode(array('Events' => "-3"),JSON_PRETTY_PRINT);;
  		return;
  	}
  	$db = new DBContext();
  	///SELECT * FROM `Events` WHERE `startDate` = '2016-04-10' and ((`startTime` >= '10:00:00' and `startTime` <= '12:00:00') or `endTime` <= '12:00:00') or (`startTime` <= '10:00:00' and `endTime` >= '12:00:00')
  	$query = "SELECT * FROM `Events` WHERE `startDate` = ".$date."  and ( ( (`startTime` >= '".$startTime."' and `startTime` <= '".$endTime."') or `endTime` <= '".$endTime."') or (`startTime` <= '".$startTime."' and `endTime` >= '".$endTime."') )";
  	
  	echo $query."<br/>";
  	
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
  }
  catch(Exception $e)
  {
  	
  	echo json_encode(array('Events' => "-2"),JSON_PRETTY_PRINT);
  }
  #echo $username;
  
  /* $DatabaseConnection = new DataBaseConnection();
  #echo '<br/> getEventsbyWeek: ".$Date." <br/>';
  $events = $DatabaseConnection->getEventsbyWeek($Date,$Approved);
  echo json_encode(json_decode($events,true),JSON_PRETTY_PRINT);
  $DatabaseConnection->disconnect();
 */
?>