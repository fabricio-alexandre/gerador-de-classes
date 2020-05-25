<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title>Gerador de classes</title>
</head>

<body>
  <h1>Gerador de classes</h1>

  <form method="POST">
    <h2>Informações gerais</h2>

    <fieldset>
      <legend>Acesso ao banco de dados</legend>
      <input type="text" name="host" placeholder="Host" value="localhost"><br>
      <input type="text" name="port" placeholder="Porta" value="3306"><br>
      <input type="text" name="user" placeholder="Usuário"><br>
      <input type="text" name="pass" placeholder="Senha"><br>
      <input type="text" name="dbName" placeholder="Banco"><br>
    </fieldset>

    <fieldset>
      <legend>Outras informações</legend>
      <input type="text" name="author" placeholder="Autor" value=""><br>
      <input type="text" name="package" placeholder="Pacote" value=""><br>
    </fieldset>

    <h2>Tabelas</h2>

    <div class="boxTabelas">
      <fieldset class="boxTabela">
        <legend>Tabela</legend>
        <input type="text" name="tabelas[0][name]" placeholder="Nome" value=""><br>
        <input type="text" name="tabelas[0][description]" placeholder="Descrição" value=""><br>
      </fieldset>

      <fieldset class="boxClasse">
        <legend>Tabela</legend>
        <input type="text" name="tabelas[1][name]" placeholder="Nome" value=""><br>
        <input type="text" name="tabelas[1][description]" placeholder="Descrição" value=""><br>
      </fieldset>
    </div>

    <br>
    <button>Gerar classes</button>
  </form>
</body>