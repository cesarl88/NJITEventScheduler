<?PHP

include_once 'EntityModel.php';

// Reporting E_NOTICE can be good too (to report uninitialized
// variables or catch variable name misspellings ...)
#error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
$db = new DBContext();

# $user = $db->find(new User(),array('UserName' => 'cls33', 'Password' => hash("sha256",'12345')));

$user = $db->find(new User(),array('userName'=> 'cls33', 'Password' => hash("sha256",'12345')));
#var_dump($db->findAll(new User()));
#	#echo json_encode(array('UserID' => $user->UserID, 'Role'=>$user->Role));
#echo json_encode($user,true);
/*  if($user)
 	echo json_encode(array('UserID' => $user->UserID, 'Role'=>$user->Role));
else
	echo 'Not Found';   */

#var_dump($db->findAll(new Role()));


#var_dump($db->findAll(new Events()));
 $event = $db->findAll(new Events(),array('startDate' => '2016-03-29','Approved'=> 1));

 if($event)
{	var_dump($event);
	#echo "Found ".$event->Title;
	#$event->Title = "Updated Title Again";
	
}
else
	echo 'Not Found';  
     
     
?>