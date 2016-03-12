<?php
include 'config/settings.php';
include 'config/mysql.php';

$search_string = preg_replace("/[^A-Za-z\ ]/", "", $_POST['query']);

$key_name = "name";
$key_url = "url";

if (strlen($search_string) >= 1 && $search_string !== ' ') {
	$stmt = $mysqli->prepare("SELECT strasse FROM strassen WHERE strasse LIKE CONCAT('%', ?, '%') AND hausnr is NULL LIMIT 10");
	$stmt->bind_param("s", $search_string);
	$stmt->execute();
	$stmt->bind_result($res_strasse);

	while ($stmt->fetch()) {
		$data[] = [
			$key_name => preg_replace("/" . $search_string . "/i", "<b class='highlight'>\$0</b>", $res_strasse),
			$key_url => '/' . urlencode($res_strasse),
		];
	}

	if (isset($data)) {
		$jsonData = json_encode($data);
		echo ($jsonData);
	}
}

?>