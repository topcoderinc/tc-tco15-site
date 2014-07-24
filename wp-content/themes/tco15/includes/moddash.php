<?php
	error_reporting(0);
	require('class.XMLHttpRequest.php');
	require('class.SimpleDOM.php');
	require('color.php');

	$c = $_GET['c'];
	$dsid = $_GET['dsid'];
	$sdate = $_GET['sdate'];
	$edate = $_GET['edate'];
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
		'dsid' => $dsid,
		'sdate' => $sdate,
		'edate' => $edate
	); print '';
	$ajax = new XMLHttpRequest();
	$ajax->open("GET", "http://community.topcoder.com/tc");
	$ajax->send($data);
	if($ajax->status == 200){
		echo $ajax->responseText;
	}else echo "ERROR: $ajax->status";
?>
