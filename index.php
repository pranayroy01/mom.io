<?php

	$keywords = array(
		'workers', 'area', 'accidents'
	);

	$months = array(
		'jan', 'feb', 'mar', 'apr', 'may', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec'
		, 'january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'sepetember', 'october', 'november', 'december'
	);

	$query = $_REQUEST['query'];

	require_once('sql.php');

	$words = explode(" ", $query);
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
		if ($found == 'accidents') {
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

	$data = array();
	foreach ($data as $key => $value) {
		$data[] = array($key => $value);
	}

	$data_json = json_encode($data);
	echo $data_json;
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