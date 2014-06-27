<?php
	error_reporting(0);
	require('class.XMLHttpRequest.php');
	require('class.SimpleDOM.php');
	require('color.php');

	$c = $_GET['c'];
	$eid = $_GET['eid'];
	$dsid = $_GET['dsid'];
	$cr = $_GET['cr'];
	$s = $_GET['sortField'];
	$sdir = (empty($_GET['sdir']) ? 'asc' : $_GET['sdir']);
	$start = intval($_GET['start']);
	$records = intval($_GET['records']);
	$total = $_GET['total'];
	$module = $_GET['module'];

	if ($start < 0) { $start = 0; }
	if ($records == 0) { $records = 30; }
	$search = $_GET['search'];

	$data = array(
		'module' => $module,
		'c'=> $c,
		'eid' => $eid,
		'dsid' => $dsid
	); print '';
	$ajax = new XMLHttpRequest();
	$ajax->open("GET", "http://community.topcoder.com/tc");
	$ajax->send($data);
	if($ajax->status == 200){
		echo $ajax->responseText;
	}else echo "ERROR: $ajax->status";
?>
