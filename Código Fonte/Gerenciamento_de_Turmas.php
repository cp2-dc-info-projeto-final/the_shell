<!DOCTYPE html>

<script>

function ExcluiTurma(id_turma, funcao)
{
  location.href = `Controlador/Excluir.php?id_turma=${id_turma}&excluir=${funcao}`;
}

function AlteraTurma(id_turma)
{
  location.href = `Controlador/PageEdição.php`;
}

</script>

<html>

<?php

require_once("Controlador/TabelaTurmas.php");

$Turmas = ListaTurmas();

session_start();

$UsuarioLogado = $_SESSION['Usuário'];
$Classe_Usuario = $UsuarioLogado['id_classe'];

$Erros = null;

if (isset($_SESSION['erros'])) {
    $Erros = $_SESSION['erros'];
}

unset($_SESSION['erros']);

?>

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="Gerenciamento_de_Turmas.css" type="text/css">
  <title> Cadastro de Turma</title>
</head>

<body>
  <?php if ($Classe_Usuario == 1) { ?>

    <div class="Barra_de_Navegacao">
      <a id="SHELL">SHELL</a>
      <a class="Celula" href="Homepage.php">Home</a>
      <a class="Celula" href="Aluno.php">Perfil</a>
      <a class="Celula" href="Boletim.php">Boletim</a>
    </div>

  <?php } else if ($Classe_Usuario == 2) { ?>
    <div class="Barra_de_Navegacao">
      <a id="SHELL">SHELL</a>
      <a class="Celula" href="Homepage.php">Home</a>
      <a class="Celula" href="Professor.php">Perfil</a>
      <a class="Celula" href="Gerenciamento_de_Turmas.php">Turmas</a>
      <a class="Celula" href="Seleção_de_Boletim.php">Notas</a>
    </div>

  <?php } else if ($Classe_Usuario == 3) { ?>
    <div class="Barra_de_Navegacao">
      <a id="SHELL">SHELL</a>
      <a class="Celula" href="Homepage.php">Home</a>
      <a class="Celula" href="Secretaria.php">Perfil</a>
      <a class="Celula" href="Cadastro_de_Usuario.php">Cadastrar Usuários</a>
      <a class="Celula" href="Gerenciamento_de_Disciplina.php">Disciplinas</a>
      <a class="Celula" href="Gerenciamento_de_Turmas.php">Turmas</a>
      <a class="Celula" href="Gerenciamento_de_Professores.php">Professores</a>
      <a class="Celula" href="Gerenciamento_de_Secretaria.php">Secretaria</a>
      <a class="Celula" href="Professor_Disciplina_Turma.php">Turmas e Professores</a>
      <a class="Celula" href="Seleção_de_Boletim.php">Notas</a>
    </div>

  <?php } ?>

  <br>
  <br>
  <br>

  <?php if ($Erros != null) { ?>

    <div id="Exibicao_de_Erro">
      <p>
        <?php
          if ($Erros != null)
          {
            foreach ($Erros as $Erro)
            {
              echo $Erro;
            }

            unset($Erro);
          }
        ?>

        <br>
      </p>
    </div>
  <?php } ?>


  <table id="Turmas">
    <tr>
      <th class="Nome_Coluna">Turma</th>
      <th class="Nome_Coluna">Série</th>
      <th class="Nome_Coluna">Quantidade de Alunos</th>
      <th class="Nome_Coluna">Integrado</th>
      <th class="Nome_Coluna">Remover</th>
      <th class="Nome_Coluna">Alterar</th>
    </tr>
    <?php for ($i = 0; $i <= (count($Turmas) - 1) ; $i++) { ?>
      <tr class="Linhas">
        <td class="Celulas"><a name="Turma" href="Turma.php?id_turma=<?= $Turmas[$i]["ID_Turma"] ?>"><?= $Turmas[$i]["Nome"] ?></a></th>
        <td class="Celulas"> <?= $Turmas[$i]["Serie"] ?></th>
        <td class="Celulas"> <?= count(ListaAlunosDaTurma($Turmas[$i]["ID_Turma"])) ?></th>
        <td class="Celulas">
          <?php

          if ($Turmas[$i]["Integrado"] == 1) {
            echo "Sim";
          }
          else {
            echo "Não";
          }

          ?>
        <th id="Exclui_Turma" class="Celulas" name="Exclui_Turma" onclick="ExcluiTurma(<?= $Turmas[$i]["ID_Turma"] ?>, 'turma')">Excluir</th>
        <th id="Edita_Turma" class="Celulas" name="Edita_Turma"  onclick="AlteraTurma(<?= $Turmas[$i]["ID_Turma"] ?>)">Editar</a></th>

        </tr>

    <?php } ?>
  </table>

  <br>

  <div id="Div_Cadastro">
    <legend id="Legend">Cadastro de Turma</legend>

    <form class="Fonte" method="POST" action="Controlador/Cadastrar_Turma.php">
      <fieldset id="Campo_Cadastro">
        <label id="Label_Turma" for="Nome_da_turma">Nome: </label>
        <input type="text" name="Nome_Turma" required>

        </br>
        </br>

        <label for="Serie_Turma">Serie: </label>
        <select name="Serie_Turma" id="Serie">
          <option value="Primeiro Ano">Primeiro Ano</option>
          <option value="Segundo Ano">Segundo Ano</option>
          <option value="Terceiro Ano">Terceiro Ano</option>
        </select>

        <br>
        <br>

        <input type="checkbox" id="Integrado" name="Integrado" value="1"> Integrado

        <br>
        <br>
        <br>
        <br>

        <input id="Botao_Cadastrar" type="submit" name="Botao_Enviar" value="Cadastrar">

        <br>
        <br>

      </fieldset>

   </form>

   <br>
   <br>

   <a id="Botao_Cadastrar_Usuario" href="Cadastro_de_Usuario.php">Cadastrar Alunos</a>
  </div>


  <div id="Rodape">
    <h4 class="Desenvolvedores">Desenvolvedores</h4>
    <p class="Desenvolvedores"> Carlos Eduardo de França, Danilo Alexandre, Gabriel Rodrigues, João Víctor de Aguiar Nery, Maria Jose.</p>
  </div>

</body>

</html>
