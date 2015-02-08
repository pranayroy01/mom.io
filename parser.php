	<?php

	$file = file_get_contents('php://input');
	$request = json_decode($file, TRUE);

	require_once('sql.php');

	$f = fopen("request.txt", "w");
	fwrite($f, $request['query']);
	fclose($f);



?>



<html>
	<body>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
			Query: <input type="text" name="query">
			<input type="hidden" name="submit" value="1">
			<br><input type="submit" value="Send">
		</form>
		<?php 
			if (isset($_POST['submit'])) {
				$url = 'http://localhost/momhack/parser.php';
				$ch = curl_init($url);
				$data = array(
					'query' => $_POST['query']
				);

				$jsonDataEncoded = json_encode($data);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

				$result = curl_exec($ch);
			}
		?>
	</body>
</html>