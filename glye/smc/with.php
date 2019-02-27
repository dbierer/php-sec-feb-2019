<?php
/* This is the code file you need to modify */

// Fix 1: Don't display errors
ini_set('display_errors', 0);

try{
	$pdo = $this->zendDatabaseConnect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $pdo->query("SELECT first_name, last_name, some_non_field FROM users WHERE user_id = '1'");
	$stmt->execute();
	$result = $stmt->fetch(PDO::FETCH_ASSOC);
}catch (PDOException $e){
	// Fix 2: Don't show exception message.
	// TODO: Log instead
	echo ('<pre>An error occurred</pre>');
}
$i = 1;
while ($i <= count($result)) {
	$html .= "<pre>ID: 1<br>First name: {$result['first_name']} <br>Surname: {$result['last_name']}</pre>";
	$i++;
}
