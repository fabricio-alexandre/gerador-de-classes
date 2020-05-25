<?php
use App\Database;
use App\Generator;

// CONEXAO COM O BANCO
$host     = $_POST['host'] ?? null;
$port     = $_POST['port'] ?? null;
$user     = $_POST['user'] ?? null;
$pass     = $_POST['pass'] ?? null;
$dbName   = $_POST['dbName'] ?? null;
$database = new Database($host, $port, $user, $pass, $dbName);

// DADOS DAS TABELAS
$tables = [];
if (isset($_POST['tables'])) {
  foreach ($_POST['tables']['name'] as $key => $value) {
    $tables[] = [
      'name'        => $_POST['tables']['name'][$key],
      'description' => $_POST['tables']['description'][$key],
    ];
  }
}

// DADOS ADICIONAIS DO POST
$package      = $_POST['package'] ?? null;
$author       = $_POST['author'] ?? null;
$addExtension = (isset($_POST['extensionClass']) and $_POST['extensionClass'] == 's');

$generatedFiles = [];
$obGenerator = new Generator;
foreach ($database->getTableDetails($tables) as $key => $tableDetails) {
  $generatedFiles[] = $obGenerator->buildClass($tableDetails, $package, $author, $addExtension);
}

$qtd = count($generatedFiles);
$message = $qtd.' classes geradas';
echo "<pre>".$message.": "; print_r($generatedFiles); echo "</pre>"; exit;