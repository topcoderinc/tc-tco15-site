<?php
	error_reporting(0);
	require('class.XMLHttpRequest.php');
	require('class.SimpleDOM.php');
	require('color.php');

	$c 			= $_GET['c'];
	$dsid 		= $_GET['dsid'];
	$cd 		= $_GET['cd'];
	$sdir 		= (empty($_GET['sdir']) ? 'asc' : $_GET['sdir']);
	$start 		= intval($_GET['start']);
	$records 	= intval($_GET['records']);
	$total 		= $_GET['total'];
	$module 	= $_GET['module'];

	if ($start < 0) { $start = 0; }
	if ($records == 0) { $records = 30; }
	$search = $_GET['search'];

	$data = array(
		'module' 	=> $module,
		'c'			=> $c,
		'dsid' 		=> $dsid,
		'cd' 		=> $cd
	);
	
	
	$ajax = new XMLHttpRequest();
	$ajax->open("GET", "http://community.topcoder.com/tc");
	$ajax->send($data);

	if($ajax->status == 200){
		$xml = simpledom_load_string($ajax->responseText);
			
		//if (empty($s)) { 
			$s = 'placement_points';
			$sdir = 'desc';
		//}
		$xArray = $xml->sortedXPath('row', $s, ($sdir == 'asc' ? SORT_ASC : SORT_DESC));
		if (!empty($total)) {
			echo json_encode(count($xArray));
		}
		else if (!empty($search)) {
			$found = false;
			foreach ($xArray as $x) {
				if ($x->handle == $search) {
					$x->handlecolor = getCoderColor($x->user_id); 
					echo json_encode($x); 
					$found = true;
					break; 
				}
			}
			if (!$found) {
				echo json_encode("Unable to find the specified user.");
			}
		}
		else {
			$newArray = $xArray; //array_splice($xArray, $start, $records);
			foreach ($newArray as $k=>$v) {
				$v->handlecolor = getCoderColor($v->user_id);
				$newArray[$k] = $v;
			}
			echo json_encode($newArray);
		}
	}else echo "ERROR: $ajax->status";
?>
