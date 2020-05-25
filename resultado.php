<?php
  use App\Database;
  use App\Generator;

  $host     = $_POST['host'] ?? null;
  $port     = $_POST['port'] ?? null;
  $user     = $_POST['user'] ?? null;
  $pass     = $_POST['pass'] ?? null;
  $dbName   = $_POST['dbName'] ?? null;
  $database = new Database($host, $port, $user, $pass, $dbName);

  $tables  = $_POST['tabelas'] ?? [];
  $package = $_POST['package'] ?? null;
  $author  = $_POST['author'] ?? null;

  $generatedFiles = [];
  $obGenerator = new Generator;
  foreach ($database->getTableDetails($tables) as $key => $tableDetails) {
    $generatedFiles[] = $obGenerator->buildClass($tableDetails, $package, $author);
  }

  echo "<pre>Classes geradas: "; print_r($generatedFiles); echo "</pre>"; exit;