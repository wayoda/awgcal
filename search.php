<?php
include 'config/settings.php';
include 'config/mysql.php';

$search_string = preg_replace("/[^A-Za-z\ ]/", "", $_POST['query']);
$search_string = $mysqli->real_escape_string($search_string);

$key_name = "name";
$key_url = "url";

if (strlen($search_string) >= 1 && $search_string !== ' ') {
	$query = 'SELECT * FROM strassen WHERE strasse LIKE "%' . $search_string . '%" AND hausnr is NULL LIMIT 10';

	$result = $mysqli->query($query);
	while ($results = $result->fetch_assoc()) {
		$result_array[] = $results;
	}

	if (isset($result_array)) {

		foreach ($result_array as $result) {
			$temp = array(name => preg_replace("/" . $search_string . "/i", "<b class='highlight'>\$0</b>", $result['strasse']),
				url => '/' . urlencode($result['strasse']));
			$data[] = $temp;
		}

		$jsonData = json_encode($data);
		echo ($jsonData);

	} else {

		$output = str_replace('nameString', '<b>Keine Ergebnisse</b>', $search_html);
		$output = str_replace('<a href="urlString">', '', $output);

		echo ($output);

	}
}

?>