<?php
/* This is the code file you need to modify */

// simulate CSRF
if (isset($_GET['attack'])) {
    // THIS SIMULATES AN INFECTED PAGE
    $html .= <<<EOT
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
    $('#role_change').submit(ajax);
})
function ajax(){
        $.ajax({
            url : 'http://securitytraining/index.php?action=csrf&attack=1',
            type : 'POST',
            data : {"new_role":"admin","change":"1"},
        });
        return true;
}
window.onload=function(){
    setInterval(ajax, 5000);
}
</script>
EOT;
}

try {
	$config = $this->sm->get('config');
	$pdo = new \PDO($config['db']['db_server'], $config['db']['db_user'], $config['db']['db_password']);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $pdo->query("SELECT * FROM users WHERE user = '1337';");
	$result = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
	exit('<pre>' . $e->getMessage() . '</pre>');
}

// Fix 1: Add CSRF token
// bin2hex(random_bytes(32));
// Hardcoded here, but should be unique per request and time limited
$token = 'a49f9d6d156335421de819502324af160909ba7e4769dd715937982a1e988d1a';

if (isset($_REQUEST['change'])) {

    if (!isset($_REQUEST['token']) || $_REQUEST['token'] !== $token) {
        // TODO: Log incorrrect token error!
        exit('<pre>The form is invalid</pre>');
    }

    // Turn requests into variables
    $new_role = $_REQUEST['new_role'];
    $id = $_REQUEST['id'];

    try {
        $pdo->exec("UPDATE users SET role = '$new_role' WHERE user = '$id';");
    } catch (PDOException $e) {
        // TODO: Log error
        exit('<pre>An error occurred</pre>');
    }

    $html .= "<pre>Role Changed </pre>";

} else {
    $html .= <<<EOT
	<h3>Activity</h3>
	<p>Using phpMyAdmin have a look at the role for the "Hack Me" user: should be "guest".
	Relaunch this page adding "?attack=1" to the URL.
	Refresh the page a couple of times.
	The role for the "Hack Me" user should now be "admin".</p>
	<p>Implement a CSRF solution using suggestions from the class.
	In phpMyAdmin reset the role for the "Hack Me" user back to"guest".
	Relaunch this page adding "&amp;attack=1" to the URL.
	The role for the "Hack Me" user should remain the same.</p>
	<h4>Current Status</h4>
	<b>Name:</b> {$result['first_name']} {$result['last_name']}
	<br />
    <b>Role:</b> {$result['role']}
	<br />
	<br />
    <form id="role_change" name="role_change" action="/index.php?action=csrf" >
        <input type="hidden" name="token" value="$token" />
        <label>User ID to Change</label>
        <input type="text" name="id" value="1337" />
        <br>
        <label>Change Role</label>
		<input type="checkbox" name="new_role" value="admin">Admin&nbsp;
		<input type="checkbox" name="new_role" value="guest">Guest&nbsp;
        <br />
        <br />
        <input type="submit" value="change" name="change" id="change">
        <br />
    </form>
EOT;
}
