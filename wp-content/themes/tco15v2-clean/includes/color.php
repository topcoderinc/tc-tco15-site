<?php
	error_reporting(0);
	require_once('class.XMLHttpRequest.php');
	require_once('class.SimpleDOM.php');
	
	function getCoderColor($cr) {
		return "#000000";
		/*
		$data = array(
			'module' => 'BasicData',
			'c'=> 'coder_all_ratings',
			'dsid' => '30',
			'cr' => $cr
		);
		$ajax = new XMLHttpRequest();
		$ajax->open("GET", "http://www.topcoder.com/tc");
		$ajax->send($data);
		if($ajax->status == 200){
			$xml = simpledom_load_string($ajax->responseText);
			$xArray = $xml->sortedXPath('row', 'coder_id', SORT_DESC);
			$max = 0;
			foreach ($xArray[0] as $k=>$rating) {
				if (strpos($k, 'rating')) {
					$rating = (int)$rating;
					if ($max < $rating) {
						$max = $rating;
					}
				}
			}
			
			
			if ($max > 2199) {
				return "#EE0000";
			} else if ($max > 1499 && $max < 2200) {
				return "#DDCC00";
			} else if ($max > 1199 && $max < 1500) {
				return "#6666FF";
			} else if ($max > 899 && $max < 1200) {
				return "#00A900";
			} else if ($max > 0 && $max < 900) {
				return "#999999";
			} else {
				return "#000000";
			}
		}else return "#000000";
		*/
	}
?>
