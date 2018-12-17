<?php

require_once('TabelaUsuários.php');

$Erro = null;

$Request = array_map('trim', $_REQUEST);
$Request = filter_var_array(
               $Request,
               [
                 'Login' => FILTER_DEFAULT,
                 'Senha' => FILTER_DEFAULT
               ]
           );

$Login = $Request['Login'];
$Senha = $Request['Senha'];

if ($Login == false)
{
  $Erro = "Login não informado.";
}
else if ($Senha == false)
{
  $Erro = "Senha não informada.";

}
else {
  $Login_Correto = ListaUsuarioPorLogin($Login);

  if ($Login_Correto == false)
  {
    $Erro = "Nenhum usuário encontrado para este Login.";
  }
  else if (! password_verify($Senha, $Login_Correto['Senha']))
  {
    $Erro = "Senha inválida.";
  }
}

session_start();

if (empty($Erro))
{
  $_SESSION['Usuário'] = ListaUsuarioPorLogin($Login);

  $Classe_Usuario = ListaClasseUsuario($Login);

  #ID das classes:
  #1 - Aluno
  #2 - Professor
  #3 - Secretário

    if ($Classe_Usuario['id_classe_usuario'] = 1)
    {
    header("Location: ../Homepage.php");
    }
    else if ($Classe_Usuario['id_classe_usuario'] = 2)
    {
    header("Location: ../Homepage.php");
    }
    else if ($Classe_Usuario['id_classe_usuario'] = 3)
    {
    header("Location: ../Homepage.php");
    }
}
else
{
  $_SESSION['Erro'] = $Erro;
  header("Location: ../Login.php");
}


?>
