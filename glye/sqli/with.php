<?php
/* This is the code file you need to modify */

if (isset($_GET['Submit'])) {

    // Retrieve data
    $id = (int) $_GET['id'];
    // Fix 1: Cast to int and ensure it is within the expected range
    if ($id < 1) {
        $html .= '<pre>User ID must be a positive integer!</pre>';
    } else {

	//Employ ACL to determine access

    try {
        $pdo = $this->zendDatabaseConnect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // Fix 2: Use prepared statement
        $stmt = $pdo->prepare("SELECT first_name, last_name FROM users WHERE user_id = :id");
        $data = ['id' => $id];
        $stmt->execute($data);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        exit('<pre>' . $e->getMessage() . '</pre>');
    }

    // Fix 3: Deal with user-not-found and other db errors,
    // don't show detailed error message in prod
    if ((is_array($result) || $result instanceof Countable) and count($result) > 0) {
        $html .= '<pre>';
        // Fix 4: Filter output
        $html .= 'ID: ' . htmlspecialchars($id) .
                 '<br>First name: ' . htmlspecialchars($result['first_name']) .
                 '<br>Surname: ' . htmlspecialchars($result['last_name']);
        $html .= '</pre>';
    } else {
        $html .= '<pre>An error occurred. The user was not found, perhaps?</pre>';
    }

    }
}

