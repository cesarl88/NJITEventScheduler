<?php  /* Implementation of curl */


  $Date = $_POST['Date'];

  $post = 'Date='.$Date;
	$url = 'https://web.njit.edu/~jsr24/CS490/getEventByDate.php';
  $ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);      /* functions that set an option for a curl transfer */
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
	$replyFromDB2 = curl_exec($ch); /* set variable to store response */
 
 # echo $replyFromDB2;
 
	curl_close($ch);
  
  
  
 
 $test = json_decode($replyFromDB2, true); /* Using json to decode the response in a form of array */
 /* Below, if statements to compare received values */
 #var_dump($res);
 
# $date = '23:00:00';
 #echo date('h:i:s a', strtotime($temp['endTime']));
 
 #$res = result from sebastian;
 echo "<table border='1' >
  			<tr>
		    <td><b>Title</b></td>
  			<td><b>Start Date</b></td>
      		<td><b>Start Time</b></td>
  			<td><b>End Date</b></td>
		    <td><b>End Time</b></td>
  
			</tr>";
 #$test = json_decode($res,true);
 #$Ev = json_decode($test['Events'][1],true);
 # var_dump($Ev);
 #echo 'Event[0] : '.$Ev['ID'].<br/>;
 foreach($test['Events'] as $item)
 {
 	$temp = json_decode($item,true);
 	#var_dump($temp);
 	echo "<tr>";
 	echo "<td>".$temp['Title']."</td>";
 	echo "<td>".$temp['startDate']."</td>";
 	echo "<td>".date('h:i:s a', strtotime($temp['startTime']))."</td>";
 	echo "<td>".$temp['EndDate']."</td>";
 	echo "<td>".date('h:i:s a', strtotime($temp['endTime']))."</td>";
 	echo "</tr>";
 }
 echo "</table>";
 
?>