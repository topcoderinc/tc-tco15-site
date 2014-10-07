<?php
	error_reporting(0);
	require('class.XMLHttpRequest.php');
	require('class.SimpleDOM.php');
	require('color.php');

	$cr = $_GET['cr'];
	$cd = $_GET['cd'];

	if ( $cd=='all' ) {
		
		echo '<?xml version="1.0" encoding="ISO-8859-1"?><tco_software_leaderboard_user_detail>';
		
		$data = array(
			'module' 	=> 'BasicData',
			'c'			=> 'tco_dev_leaderboard_user_detail_2015',
			'dsid' 		=> '30',
			'cd' 		=> '563',
			'cr' 		=> $cr
		);
		$ajax1 = new XMLHttpRequest();
		$ajax1->open("GET", "http://community.topcoder.com/tc");
		$ajax1->send($data);
		if($ajax1->status == 200){
			$obj1 = str_replace('<?xml version="1.0" encoding="ISO-8859-1"?><tco_software_leaderboard_user_detail>', '', $ajax1->responseText);
			$obj1 = str_replace('<?xml version="1.0" encoding="ISO-8859-1"?>', '', $obj1);
			$obj1 = str_replace('<tco_software_leaderboard_user_detail/>', '', $obj1);				
			$obj1 = str_replace('<tco_software_leaderboard_user_detail>', '', $obj1);
			$obj1 = str_replace('</tco_software_leaderboard_user_detail>', '', $obj1);
			echo $obj1;
		}

		$data = array(
			'module' 	=> 'BasicData',
			'c'			=> 'tco_software_leaderboard_user_detail',
			'dsid' 		=> '30',
			'cd' 		=> '564',
			'cr' 		=> $cr
		);
		$ajax2 = new XMLHttpRequest();
		$ajax2->open("GET", "http://community.topcoder.com/tc");
		$ajax2->send($data);
		if($ajax2->status == 200){
			$obj2 = str_replace('<?xml version="1.0" encoding="ISO-8859-1"?><tco_software_leaderboard_user_detail>', '', $ajax2->responseText);
			$obj2 = str_replace('<?xml version="1.0" encoding="ISO-8859-1"?>', '', $obj2);
			$obj2 = str_replace('<tco_software_leaderboard_user_detail/>', '', $obj2);				
			$obj2 = str_replace('<tco_software_leaderboard_user_detail>', '', $obj2);
			$obj2 = str_replace('</tco_software_leaderboard_user_detail>', '', $obj2);
			echo $obj2;
		}

		$data = array(
			'module' 	=> 'BasicData',
			'c'			=> 'tco_software_leaderboard_user_detail',
			'dsid' 		=> '30',
			'cd' 		=> '565',
			'cr' 		=> $cr
		);
		$ajax3 = new XMLHttpRequest();
		$ajax3->open("GET", "http://community.topcoder.com/tc");
		$ajax3->send($data);
		if($ajax3->status == 200){
			$obj3 = str_replace('<?xml version="1.0" encoding="ISO-8859-1"?><tco_software_leaderboard_user_detail>', '', $ajax3->responseText);
			$obj3 = str_replace('<?xml version="1.0" encoding="ISO-8859-1"?>', '', $obj3);
			$obj3 = str_replace('<tco_software_leaderboard_user_detail/>', '', $obj3);				
			$obj3 = str_replace('<tco_software_leaderboard_user_detail>', '', $obj3);
			$obj3 = str_replace('</tco_software_leaderboard_user_detail>', '', $obj3);
			echo $obj3;
		}
		
		
		$data = array(
			'module' 	=> 'BasicData',
			'c'			=> 'tco_software_leaderboard_user_detail',
			'dsid' 		=> '30',
			'cd' 		=> '566',
			'cr' 		=> $cr
		);
		$ajax4 = new XMLHttpRequest();
		$ajax4->open("GET", "http://community.topcoder.com/tc");
		$ajax4->send($data);
		if($ajax4->status == 200){
			$ajax4 = str_replace('<?xml version="1.0" encoding="ISO-8859-1"?><tco_software_leaderboard_user_detail>', '', $ajax4->responseText);
			$ajax4 = str_replace('<?xml version="1.0" encoding="ISO-8859-1"?>', '', $ajax4);
			$ajax4 = str_replace('<tco_software_leaderboard_user_detail/>', '', $ajax4);				
			$ajax4 = str_replace('<tco_software_leaderboard_user_detail>', '', $ajax4);
			$ajax4 = str_replace('</tco_software_leaderboard_user_detail>', '', $ajax4);
			echo $ajax4;
		}
		
		echo '</tco_software_leaderboard_user_detail>';

		
	} else {
		$data = array(
			'module' 	=> 'BasicData',
			'c'			=> 'tco_dev_leaderboard_user_detail_2015',
			'dsid' 		=> '30',
			'cd' 		=> $cd,
			'cr' 		=> $cr
		);
		$ajax = new XMLHttpRequest();
		$ajax->open("GET", "http://community.topcoder.com/tc");
		$ajax->send($data);
		if($ajax->status == 200){
			echo $ajax->responseText;
		}else echo "ERROR: $ajax->status";
	}
	
?>
