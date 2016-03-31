<?php

  #include_once('DataBaseConnection.php');
  include_once 'EntityModel.php';

  $Date = $_POST['Date'];
  $Approved = $_POST['Approved'];
  
  $UserID = $_POST['UserID'];
  $db = new DBContext();

  if(isset($UserID))
  {
  	$conditions = array('startDate' => $Date,'Approved'=> $Approved, 'UserID' => $UserID );
  }
  else
  {
  	$conditions =array('startDate' => $Date,'Approved'=> $Approved);
  }
  $event = $db->findAll(new Events(),$conditions);
  
  if($event)
  {	
  	$result = [];
  	foreach($event as $item)
  	{
  		$result[] = $item->getJSON();
/*   		$test = json_decode($item->getJSON(),true);
  		echo 'Title : '.$test['Title'].'<br/>'; */
  	}
  	/* $test = json_decode(json_encode(array('Events' => $result),JSON_PRETTY_PRINT),true);
  	echo 'Event[0] : '.$test['Events'][1].'<br/>'; */
	echo json_encode(array('Events' => $result),JSON_PRETTY_PRINT);
  }
  else
  	echo json_encode(array('Events' => "-1"),JSON_PRETTY_PRINT); 

 /*  $res = result from sebastian;
  echo "<table border='1' >
  			<tr>
		    <td><b>Title</b></td>
  			<td><b>Start Date</b></td>
      		<td><b>Start Time</b></td>
  			<td><b>End Date</b></td>
		    <td><b>End Time</b></td>
  			
			</tr>";
  $test = json_decode($res,true);
  #$Ev = json_decode($test['Events'][1],true);
 # var_dump($Ev);
  #echo 'Event[0] : '.$Ev['ID'].<br/>;
  #var_dump($test);
  foreach($test['Events'] as $item)
  {
  	$temp = json_decode($item,true);
  	#var_dump($temp);
  	echo "<tr>";
  	echo "<td>".$temp['Title']."</td>";
  	echo "<td>".$temp['startDate']."</td>";
  	echo "<td>".$temp['startTime']."</td>";
  	echo "<td>".$temp['EndDate']."</td>";
  	echo "<td>".$temp['endTime']."</td>";
  	echo "</tr>";
  }
  echo "</table>"; */
  

  /* $DatabaseConnection = new DataBaseConnection();
  #echo '<br/> getEventsbyWeek: ".$Date." <br/>';
  $events = $DatabaseConnection->getEventsbyDate($Date,$Approved);
  echo json_encode(json_decode($events,true),JSON_PRETTY_PRINT);
  $DatabaseConnection->disconnect(); */

?>
