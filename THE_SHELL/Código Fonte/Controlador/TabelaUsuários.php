<?php

require_once('Conexão_BD.php');

function ListaUsuarios()
{
  $BD = CriaConexaoBD();

  if ($BD == null)
  {
    return null;
  }

  $Resultado = $BD -> query('SELECT * FROM usuario ORDER BY nome ASC');

  return $Resultado -> fetchAll();
}

function CadastraUsuario($Info_Login)
{
  $BD = CriaConexaoBD();

  $SQL = $BD -> prepare('INSERT INTO usuario(login, nome, senha, email, tel)
                         VALUES (:login, :nome, :senha, :email, :tel);');

  $SQL -> bindValue(':nome', $Info_Login['Nome']);
  $SQL -> bindValue(':login', $Info_Login['Login']);
  $SQL -> bindValue(':senha', password_hash($Info_Login['Senha'], PASSWORD_DEFAULT));
  $SQL -> bindValue(':email', $Info_Login['Email']);
  $SQL -> bindValue(':tel', $Info_Login['Tel']);

  $SQL -> execute();

  header('Location: ../Login.php');
}

function ListaUsuarioPorLogin($Login_Usuario)
{
  $BD = CriaConexaoBD();

  $SQL = $BD -> prepare('SELECT *
                         FROM usuario
                         WHERE login = :login');

  $SQL -> bindValue(':login', $Login_Usuario);

  $SQL -> execute();

  return $SQL -> fetch();
}

function ListaClasseUsuario($Login_Usuario)
{
  $BD = CriaConexaoBD();

  $Usuario = $BD -> query('SELECT
                            classe.id_classe_usuario AS "id_classe",
                            classe.classe AS "classe"
                           FROM $usuario
                           WHERE login = :login
                           LEFT JOIN classe
                           ON usuario.id_classe_usuario = classe.id_classe');

  $Usuario -> bindValue(':login', $Login_Usuario);

  $Usuario -> execute();

  $Info_Usuario = $Usuario -> fetch();
}

?>
