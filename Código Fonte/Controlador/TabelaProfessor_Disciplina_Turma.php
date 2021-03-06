<?php

require_once("Conexão_BD.php");

function ListaAulasDoProfessor($ID_Professor)
{
  $BD = CriaConexaoBD();

  $SQL = $BD -> prepare('SELECT
                          professor_disciplina_turma.id_turma AS ID_Turma,
                          turma.nome AS Turma,
                          professor_disciplina_turma.id_disciplina AS ID_Disciplina,
                          disciplina.disciplina AS Disciplina
                         FROM professor_disciplina_turma
                         RIGHT JOIN professor ON professor.id_professor = professor_disciplina_turma.id_professor
                         RIGHT JOIN turma ON turma.id_turma = professor_disciplina_turma.id_turma
                         LEFT JOIN disciplina ON professor_disciplina_turma.id_disciplina = disciplina.id_disciplina
                         WHERE professor_disciplina_turma.id_professor = :id_professor;');

  $SQL -> bindValue(":id_professor", $ID_Professor);

  $SQL -> execute();

  return $SQL -> fetchAll();
}

function ListaTurmasDoProfessor($ID_Professor)
{
  $BD = CriaConexaoBD();

  $SQL = $BD -> prepare('SELECT DISTINCT
                          professor_disciplina_turma.id_turma AS ID_Turma,
                          turma.nome AS Nome
                         FROM professor_disciplina_turma
                         RIGHT JOIN professor ON professor.id_professor = professor_disciplina_turma.id_professor
                         RIGHT JOIN turma ON turma.id_turma = professor_disciplina_turma.id_turma
                         LEFT JOIN disciplina ON professor_disciplina_turma.id_disciplina = disciplina.id_disciplina
                         WHERE professor_disciplina_turma.id_professor = :id_professor;');
//Pendencia de filtar as turmas e as aulas 
  $SQL -> bindValue(":id_professor", $ID_Professor);

  $SQL->execute();

  return $SQL -> fetchAll();
}

function ListaTurmasDeDisciplinaDoProfessor($ID_Professor, $ID_Disciplina)
{
  $BD = CriaConexaoBD();

  $SQL = $BD -> prepare('SELECT
                          professor_disciplina_turma.id_turma AS ID_Turma,
                          turma.nome AS Nome
                         FROM professor_disciplina_turma
                         RIGHT JOIN professor ON professor.id_professor = professor_disciplina_turma.id_professor
                         RIGHT JOIN turma ON turma.id_turma = professor_disciplina_turma.id_turma
                         LEFT JOIN disciplina ON professor_disciplina_turma.id_disciplina = disciplina.id_disciplina
                         WHERE professor_disciplina_turma.id_professor = :id_professor AND
                               professor_disciplina_turma.id_disciplina = :id_disciplina;');

  $SQL -> bindValue(":id_professor", $ID_Professor);
  $SQL -> bindValue(":id_disciplina", $ID_Disciplina);

  $SQL->execute();

  return $SQL -> fetchAll();
}

function ListaDisciplinasDoProfessor($ID_Professor)
{
  $BD = CriaConexaoBD();

  $SQL = $BD -> prepare('SELECT
                          professor_disciplina_turma.id_professor AS ID_Professor,
                          professor_disciplina_turma.id_turma AS ID_Turma,
                          professor_disciplina_turma.id_disciplina AS ID_Disciplina,
                          disciplina.disciplina AS Disciplina
                         FROM professor_disciplina_turma
                         JOIN usuario ON usuario.id_usuario = professor_disciplina_turma.id_professor
                         JOIN turma ON turma.id_turma = professor_disciplina_turma.id_turma
                         JOIN disciplina ON professor_disciplina_turma.id_disciplina = disciplina.id_disciplina
                         WHERE professor_disciplina_turma.id_professor = :id_professor;');

  $SQL -> bindValue(":id_professor", $ID_Professor);

  $SQL->execute();

  return $SQL -> fetchAll();
}

function ListaDisciplinasDaTurma($ID_Turma)
{
  $BD = CriaConexaoBD();

  $SQL = $BD -> prepare('SELECT
                          professor_disciplina_turma.id_disciplina AS ID_Disciplina,
                          disciplina.disciplina AS Disciplina
                         FROM professor_disciplina_turma
                         RIGHT JOIN professor ON professor.id_professor = professor_disciplina_turma.id_professor
                         RIGHT JOIN turma ON turma.id_turma = professor_disciplina_turma.id_turma
                         LEFT JOIN disciplina ON professor_disciplina_turma.id_disciplina = disciplina.id_disciplina
                         WHERE professor_disciplina_turma.id_turma = :id_turma;');

  $SQL -> bindValue(":id_turma", $ID_Turma);

  $SQL -> execute();

  return $SQL -> fetchAll();
}

function AssociaProfessorTurma($Dados)
{
  $BD = CriaConexaoBD();

  $SQL = $BD -> prepare('INSERT INTO professor_disciplina_turma(id_professor, id_disciplina, id_turma) VALUES
                         (:id_professor, :id_disciplina, :id_turma);');

  $SQL -> bindValue(":id_professor", $Dados['Professor']);
  $SQL -> bindValue(":id_disciplina", $Dados['Disciplina']);
  $SQL -> bindValue(":id_turma", $Dados['Turma']);

  $SQL -> execute();
}

?>
