<?php
/* This is the code file you need to modify */

Class User
{
	const SOME_CONSTANT = "Sensitive data";
	protected $username;
	protected $password;

	/**
	 * @param null $name
	 * @param null $pass
	 */
	public function __construct($name = null, $pass = null)
	{
		$this->username = $name;
		$this->password = $pass;
	}
}

$user = new User();
$html = '';

if (!empty($_GET['username']) && !empty($_GET['password'])) {
	$username = $_GET['username'];
	$password = $_GET['password'];

	//Code to check the database for existing username, we'll assume none here

	// Fix 1: Hash password
	$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

	$user = new User($username, $hashedPassword);

	//Call model and store the user object...

	$html .= "
		<br>
        <div class=\"vulnerable_code_area\">
            <div>
	            <h1>Thank You for signing up for our cool service!</h1>
			    <p>We are here to help in case you need it.</p>
		  </div>
		 </div>";
}
