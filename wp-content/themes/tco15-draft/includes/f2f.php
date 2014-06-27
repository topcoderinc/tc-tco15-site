<?php
	error_reporting(0);
	require('class.XMLHttpRequest.php');
	require('class.SimpleDOM.php');
	require('color.php');

	$c 		= $_GET['c'];
	$dsid 	= $_GET['dsid'];
	$cd 	= $_GET['cd'];
	$module = $_GET['module'];

	$data = array(
		'module' 	=> $module,
		'c'			=> $c,
		'dsid' 		=> $dsid,
		'cd' 		=> $cd
	); print '';
	$ajax = new XMLHttpRequest();
	$ajax->open("GET", "http://community.topcoder.com/tc");
	$ajax->send($data);
	if($ajax->status == 200){
		echo $ajax->responseText;
	}else echo "ERROR: $ajax->status";
?>
