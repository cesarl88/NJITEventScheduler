<?php

 # include_once('DataBaseConnection.php');
include_once 'EntityModel.php';

  $UserID = $_POST['UserID'];
  
  #echo $Password;
  $db = new DBContext();
  $user = $db->find(new User(),array('UserID' => $UserID));
  
  if($user)
 	echo json_encode(array('UserName' => $user->UserName));
  else
  	echo json_encode(array('UserName' => "-1"));
  
  /* $user = new User($username,$Password);
  
  $DatabaseConnection = new DataBaseConnection();
  
  $result = $DatabaseConnection->checkLogin($user);
  echo $result;
  
  $DatabaseConnection->disconnect(); */

?>
