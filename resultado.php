<?php
  use App\Database;

  extract($_POST, EXTR_SKIP);
  $database = new Database($host, $port, $user, $pass, $dbName);
  // echo "<pre>"; var_dump($database); echo "</pre>"; exit;
?>

<h1>resultado aqui</h1>