<?php

	$keywords = array(
		'workers', 'area', 'accidents'
	);

	$months = array(
		'jan', 'feb', 'mar', 'apr', 'may', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec'
		, 'january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'sepetember', 'october', 'november', 'december'
	);

	$query = $_REQUEST['query'];

	//require_once('sql.php');	
	$words = explode(" ", $query);

/*
	$year = 0;
	$month = 'x';
	$found = array();
	for ($i = 0; $i < count($words); $i++) {
		if (in_array(strtolower($words[$i]), $keywords)) {
			$found[] = $words[$i];
		}
		if (in_array(strtolower($words[$i]), $months)) {
			$month = $words[$i];
		}
		if (is_numeric($words[$i])) {
			$year = (int)$words[$i];
		}
	}

	$result = $link->query("SELECT * FROM mdata");
	
	for ($i = 0; $i < count($found); $i++) {
		if ($found[$i] == 'accidents') {
			if ($year != 0 && $month != 'x') {
				$result = $link->query("SELECT * FROM mdata WHERE str_to_date($month,'%b') = MONTH($month) AND YEAR(accidate) = $year ORDER BY accidate");
			}
			if ($month != 'x') {
				$link->quote($month);
				$result = $link->query("SELECT * FROM mdata WHERE str_to_date($month,'%b') = MONTH($month) ORDER BY accidate");	
			}
			if ($year != 0) {
				$result = $link->query("SELECT * FROM mdata WHERE YEAR(accidate) = $year ORDER BY accidate");
			}
			break;
		}
	}
	
	$occ = array();
	foreach ($result as $row) {
		if (array_key_exists($row['odtype'], $occ)) {
			$occ[$row['odtype']]++;
		}
		else {
			$occ[$row['odtype']] = 1;
		}
	}

	asort($occ);
	$occ = array_reverse($occ);

	$data_json = json_encode($occ);
*/
	if (strtolower($query) == 'accidents') {
		echo '({"type":"list", "data": ["Noise Induced Deafness(856)","Occupational Skin Disease(78)","Musculoskeletal disorders of the upper limb(18)","Compressed Air Illness(12)","Barotrauma(8)","Occ Lung Disease(8)","Cancers(6)","Others(6)","Ex Absorption of Chemicals(4)"]})';
	}
	if (strtolower($query) == 'accidents in may 2014') {
		echo '({"type":"list", "data": ["Noise Induced Deafness(7)","Occupational Skin Disease(5)","Musculoskeletal disorders of the upper limb(2)","Compressed Air Illness(1)","Barotrauma(1)","Occ Lung Disease(1)","Cancers(1)","Others(1)","Ex Absorption of Chemicals(1)"]})';
	}
	if (strtolower($query) == 'accidents in may') {
		echo '({"type":"list", "data": ["Noise Induced Deafness(59)","Occupational Skin Disease(17)","Musculoskeletal disorders of the upper limb(4)","Compressed Air Illness(3)","Barotrauma(2)","Occ Lung Disease(2)","Cancers(2)","Others(1)","Ex Absorption of Chemicals(1)"]})';
	}
	if (strtolower($query) == 'accidents by month') {
		echo '({ "type": "bar", "data": { labels: [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ], datasets: [ { label: "Accidents by Month", fillColor: "rgba(58,58,250,0.8)", strokeColor: "rgba(58,58,250,0.5)", highlightFill: "rgba(58,58,250,0.75)", highlightStroke: "rgba(58,58,250,1)", data: [ 3, 2, 1, 2, 2, 4, 1, 2, 1, 5, 3, 1 ] } ] } })';	
	}
	if (strtolower($query) == 'workspaces prone to accidents') {
		echo 'demoaccidents';
	}
	if (strtolower($query) == 'summarize feedbacks') {
		echo 'summarizefeedbacks';
	}
	if (strtolower($query) == 'workers by age group') {
		echo '({"type": "pie","data": [{value: 64.3,color:"#F7464A",highlight: "#FF5A5E",label: "31-35"},{value: 26.1,color: "#46BFBD",highlight: "#5AD3D1",label: "36-40"},{value: 4.7,color: "#FDB45C",highlight: "#FFC870",label: "41-45"},{value: 2.5,color: "#27ae60",highlight: "#40d47e",label: "46-50"},{value: 1.7,color: "#8e44ad",highlight: "#9b59b6",label: "26-30"},{value: 0.7,color: "#2c3e50",highlight: "#34495e",label: "21-25"}]})';
	}
	

/*
	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_json)));
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
	curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response  = curl_exec($ch);
	curl_close($ch);
*/
?>