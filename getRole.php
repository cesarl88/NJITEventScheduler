<?php

 # include_once('DataBaseConnection.php');
	include_once 'EntityModel.php';

  $UserID = $_POST['UserID'];
  #echo $UserID;
  /* $DatabaseConnection = new DataBaseConnection();

  echo $DatabaseConnection->getRole($UserID);
  
  
  $DatabaseConnection->disconnect(); */
  $db = new DBContext();
  $user = $db->find(new User(),array('UserID' => $UserID));
  
  if($user)
  	echo json_encode(array('Role'=>$user->Role));
  else
  	echo json_encode(array('Roles'=> "-1"));
 # var_dump($user);
?>
