<?php
/* This is the code file you need to modify */

if(isset($_POST['btnSign']))
{
   // Fix 1: Wash input
   // TODO: Apply limits, warn if exceeded
   // TODO: Don't allow empty input, existing JS validator isn't enough.
   $message = htmlspecialchars(strip_tags(trim($_POST['mtxMessage'])));
   $name    = htmlspecialchars(strip_tags(trim($_POST['txtName'])));
   try {
      $pdo =$this->zendDatabaseConnect();
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      // Fix 2: Prepared statement
      $stmt = $pdo->prepare("INSERT INTO guestbook (name, comment) VALUES (:name, :message)");
      $stmt->execute([
         'name' => $name,
         'message' => $message,
      ]);
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
   } catch (PDOException $e) {
// TODO: Log the error, show generic message
//      exit('<pre>' . $e->getMessage() . '</pre>');
   }

   // Fix 3: Deal with user-not-found and other db errors,
   // don't show detailed error message in prod
   if ((is_array($result) || $result instanceof Countable) and count($result) > 0) {
      // Fix 4: Wash output TODO
      // TODO Don't print_r. Loop and wash each item.
      print_r($result);
   } else{
      echo 'No results found';
   }
}
