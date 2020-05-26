<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title>Gerador de classes</title>

  <link rel="stylesheet" type="text/css" href="css/estilos.css" />
  <script src="js/jquery-3.5.1.js"></script>
  <script src="js/scripts.js"></script>
</head>

<body>
  <h1>Gerador de classes</h1>

  <form method="POST">
    <h2>Informações gerais</h2>

    <fieldset>
      <legend>Acesso ao banco de dados</legend>
      <input type="text" name="host" placeholder="Host"><br>
      <input type="text" name="port" placeholder="Porta" value="3306"><br>
      <input type="text" name="user" placeholder="Usuário"><br>
      <input type="text" name="pass" placeholder="Senha"><br>
      <input type="text" name="dbName" placeholder="Banco"><br>
    </fieldset>

    <fieldset>
      <legend>Outras informações</legend>
      <input type="text" name="author" placeholder="Author" value=""><br>
      <input type="text" name="package" placeholder="Package" value=""><br>

      <span>Utilizar extensão ".class"?</span>
      <label>
        <input type="radio" name="extensionClass" value="s" checked>
        <span>Sim</span>
      </label>
      <label>
        <input type="radio" name="extensionClass" value="n">
        <span>Não</span>
      </label>
    </fieldset>

    <h2>Tabelas</h2>

    <div class="boxTabelas">
      <!-- Preenchido pelo usuario -->
    </div>

    <br><button type="button" class="btnClass btnAdd">+ Tabela</button>

    <br><br><br>
    <button class="btnClass btnBuildClasses">Gerar classes</button>
  </form>

  <br><br><br>
  <a href="limpar-files.php">
    <button class="btnClass btnRemoverArquivos">Limpar pasta de arquivos gerados</button>
  </a>

  <div class="modeloBoxTabela" hidden>
    <fieldset>
      <legend>Tabela</legend>
      <input type="text" name="tables[name][]" placeholder="Nome" value=""><br>
      <input type="text" name="tables[description][]" placeholder="Descrição" value=""><br>
      
      <br><button type="button" class="btnClass btnRemove">- Tabela</button>
    </fieldset>
  </div>
  
</body>