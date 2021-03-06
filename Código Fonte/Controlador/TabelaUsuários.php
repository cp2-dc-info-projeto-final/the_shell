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

  $SQL = $BD -> prepare('INSERT INTO usuario(login, nome, senha, email, tel, id_classe_usuario, data_nasc)
                         VALUES (:login, :nome, :senha, :email, :tel, :classe, :data_nasc);');

  $SQL -> bindValue(':login', $Info_Login['Login']);
  $SQL -> bindValue(':nome', $Info_Login['Nome']);
  $SQL -> bindValue(':senha', password_hash($Info_Login['Senha'], PASSWORD_DEFAULT));
  $SQL -> bindValue(':email', $Info_Login['Email']);
  $SQL -> bindValue(':tel', $Info_Login['Tel']);
  $SQL -> bindValue(':classe', $Info_Login['Classe']);
  $SQL -> bindValue(':data_nasc', $Info_Login['Data_Nasc']);

  $SQL -> execute();

  return $ID_Usuario = $BD -> lastInsertId();
}

function ListaUsuarioPorLogin($Login_Usuario)
{
  $BD = CriaConexaoBD();

  $SQL = $BD -> prepare('SELECT
                          usuario.id_usuario AS id_usuario,
                          usuario.login AS Login,
                          usuario.nome AS Nome,
                          usuario.senha AS Senha,
                          usuario.email AS Email,
                          usuario.data_nasc AS Data_Nasc,
                          usuario.tel AS Tel,
                          usuario.id_classe_usuario AS id_classe,
                          aluno.matricula AS Matricula,
                          professor.siape AS Siape,
                          secretaria.siape AS Siape,
                          aluno.id_turma AS ID_Turma,
                          turma.nome AS Turma
                         FROM usuario
                         LEFT JOIN aluno ON aluno.id_aluno = usuario.id_usuario
                         LEFT JOIN turma ON aluno.id_turma = turma.id_turma
                         LEFT JOIN professor ON usuario.id_usuario = professor.id_professor
                         LEFT JOIN secretaria ON usuario.id_usuario = secretaria.id_secretaria
                         WHERE login = :login;');

  $SQL -> bindValue(':login', $Login_Usuario);

  $SQL -> execute();

  return $SQL -> fetch();
}

function ListaClasseUsuario($Login_Usuario)
{
  $BD = CriaConexaoBD();

  $Usuario = $BD -> prepare('SELECT
                              id_classe_usuario
                             FROM usuario
                             WHERE login = :login');

  $Usuario -> bindValue(":login", $Login_Usuario);

  $Usuario -> execute();

  return $Usuario -> fetch();
}

function ListaInfoProfessor($Login_Usuario)
{
  $BD = CriaConexaoBD();

  $Info_Usuario = $BD ->prepare('SELECT
                                  usuario.login AS Login,
                                  usuario.id_usuario As id_usuario,
                                  usuario.nome AS Nome,
                                  usuario.senha AS Senha,
                                  usuario.email AS Email,
                                  usuario.tel AS Tel,
                                  usuario.data_nasc AS Data_Nasc,
                                  classe.classe AS Classe,
                                  classe.id_classe as id_classe,
                                  professor.siape AS Siape
                                FROM usuario
                                LEFT JOIN classe
                                ON usuario.id_classe_usuario = classe.id_classe
                                JOIN professor
                                ON professor.id_professor = usuario.id_usuario
                                WHERE usuario.login = :varlogin;');

  $Info_Usuario -> bindValue(':varlogin', $Login_Usuario);

  $Info_Usuario -> execute();

   return $Info_Usuario -> fetch();
}

function ListaInfoFuncionario($Login)
{
  $BD = CriaConexaoBD();

  $Info_Usuario = $BD ->prepare('SELECT
                                  usuario.login AS Login,
                                  usuario.id_usuario As id_usuario,
                                  usuario.nome AS Nome,
                                  usuario.senha AS Senha,
                                  usuario.email AS Email,
                                  usuario.tel AS Tel,
                                  usuario.data_nasc AS Data_Nasc,
                                  classe.classe AS Classe,
                                  classe.id_classe as id_classe,
                                  secretaria.siape AS Siape
                                FROM usuario
                                LEFT JOIN classe
                                ON usuario.id_classe_usuario = classe.id_classe
                                LEFT JOIN secretaria
                                ON secretaria.id_classe_usuario = classe.id_classe
                                WHERE usuario.login = :login;');

  $Info_Usuario -> bindValue(':login', $Login);

  $Info_Usuario -> execute();

   return $Info_Aluno = $Info_Usuario -> fetch();
}


?>
