<?php

function njit_login($user, $pass){
	// user=UCID&pass=pass&uuid=0xACA021
 
  $user = $_POST['userName'];
  $pass = $_POST['Password'];

  $ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://cp4.njit.edu/cp/home/login");
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
	 	"user" => $user,
	 	"pass" => $pass,
	 	"uuid" => "0xACA021"
	)));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$result = curl_exec($ch);
	curl_close($ch);
  #echo $result;
	// Logout to kill any sessions
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://cp4.njit.edu/up/Logout?uP_tparam=frm&frm=");
	curl_exec($ch);
	curl_close($ch);
 
	// Return validation bool
	return strpos($result, "loginok.html") !== false;
}

$result =  njit_login("","");
if($result)
{
  //Return 1 in the JSON;
  echo "Pass";
}
else
{
  //Return 0 or -1 in the JSON;
  echo "Fail";
}
?>              