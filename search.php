<?php
include 'config/settings.php';
include 'config/mysql.php';

$search_html = '<li class="dropdown-item">';
$search_html .= '<a href="urlString">';
$search_html .= '<p>nameString</p>';
$search_html .= '</li>';

$search_string = preg_replace("/[^A-Za-z\ ]/", "", $_POST['query']);
$search_string = $mysqli->real_escape_string($search_string);

if (strlen($search_string) >= 1 && $search_string !== ' ') {
	$query = 'SELECT * FROM strassen WHERE strasse LIKE "%' . $search_string . '%" LIMIT 10';

	$result = $mysqli->query($query);
	while ($results = $result->fetch_assoc()) {
		$result_array[] = $results;
	}

	if (isset($result_array)) {
		foreach ($result_array as $result) {

			$display_name = preg_replace("/" . $search_string . "/i", "<b class='highlight'>\$0</b>", $result['strasse']);

			$display_url = '/' . urlencode($result['strasse']);

			$output = str_replace('nameString', $display_name, $search_html);
			$output = str_replace('urlString', $display_url, $output);

			echo ($output);
		}
	} else {

		$output = str_replace('nameString', '<b>Keine Ergebnisse</b>', $search_html);
		$output = str_replace('<a href="urlString">', '', $output);

		echo ($output);

	}
}

?>