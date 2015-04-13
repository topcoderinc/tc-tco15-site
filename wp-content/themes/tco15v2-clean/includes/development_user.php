<?php
	error_reporting(0);
	require('class.XMLHttpRequest.php');
	require('class.SimpleDOM.php');
	//require('color.php');

	$cr 	= $_GET['cr'];
	$cd 	= $_GET['cd'];
	$module = $_GET['module'];
	$dsid 	= $_GET['dsid'];
	$c 		= $_GET['c'];	
	$data 	= array(
		'module' 	=> $module,
		'c'			=> $c,
		'dsid' 		=> $dsid,
		'cd' 		=> $cd,
		'cr' 		=> $cr
	);

	$ajax = new XMLHttpRequest();
	$ajax->open("GET", "http://community.topcoder.com/tc");
	$ajax->send($data);
	if($ajax->status == 200){
		echo $ajax->responseText;
	}else echo "ERROR: $ajax->status";
	
?>
