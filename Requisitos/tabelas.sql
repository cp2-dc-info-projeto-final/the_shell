CREATE TABLE Classe (

	id_classe INT NOT NULL AUTO_INCREMENT,
  classe VARCHAR(100),
  PRIMARY KEY(id_classe)
);

CREATE TABLE Disciplina (

	id_disciplina INT NOT NULL AUTO_INCREMENT,
	disciplina VARCHAR(50),
	PRIMARY KEY (id_disciplina)
);

CREATE TABLE Turma (

	id_turma INT NOT NULL AUTO_INCREMENT,
	nome VARCHAR(100),
	serie VARCHAR(50),
	integrado BOOLEAN,
	PRIMARY KEY (id_turma)
);

CREATE TABLE Usuario (

	id_usuario INT NOT NULL AUTO_INCREMENT,
	id_classe_usuario INT,
	login VARCHAR(100),
	nome VARCHAR(100),
	senha VARCHAR(80),
	email VARCHAR(100),
	tel VARCHAR(50),
	data_nasc DATE,
	id_turma INT,
	PRIMARY KEY (id_usuario),
	FOREIGN KEY (id_classe_usuario) REFERENCES Classe(id_classe),
	FOREIGN KEY (id_turma) REFERENCES Turma(id_turma)
);


CREATE TABLE Professor (

	id_professor INT,
	id_classe_usuario INT,
	siape VARCHAR(50),
	PRIMARY KEY (id_professor),
	FOREIGN KEY (id_classe_usuario) REFERENCES Classe(id_classe),
	FOREIGN KEY (id_professor) REFERENCES Usuario(id_usuario)
);

CREATE TABLE Aluno (

	id_aluno INT,
	id_classe_usuario INT,
	matricula VARCHAR(50),
	id_turma INT,
	PRIMARY KEY (id_aluno),
	FOREIGN KEY (id_turma) REFERENCES Turma(id_turma),
	FOREIGN KEY (id_classe_usuario) REFERENCES Classe(id_classe)
);

CREATE TABLE Boletim (

	id_boletim INT NOT NULL AUTO_INCREMENT,
	primeira_cert DECIMAL,
	segunda_cert DECIMAL,
	terceira_cert DECIMAL,
	pfv DECIMAL,
	media DECIMAL,
	id_aluno INT,
	id_disciplina INT,
	PRIMARY KEY(id_boletim),
	FOREIGN KEY(id_disciplina) REFERENCES disciplina(id_disciplina),
	FOREIGN KEY(id_aluno) REFERENCES aluno(id_aluno)
);


CREATE TABLE Secretaria (

	id_secretaria INT,
	id_classe_usuario INT,
	siape VARCHAR(50),
	PRIMARY KEY (id_secretaria),
	FOREIGN KEY (id_classe_usuario) REFERENCES Classe(id_classe),
	FOREIGN KEY (id_secretaria) REFERENCES Usuario(id_usuario)
);

CREATE TABLE Professor_Disciplina_Turma (

	id_dados INT NOT NULL AUTO_INCREMENT,
	id_professor INT,
	id_turma INT,
	id_disciplina INT,
	PRIMARY KEY (id_dados),
	FOREIGN KEY (id_professor) REFERENCES Professor(id_professor),
	FOREIGN KEY (id_turma) REFERENCES Turma(id_turma),
	FOREIGN KEY (id_disciplina) REFERENCES Disciplina(id_disciplina)
);


INSERT INTO Classe(classe) VALUES
("Aluno"),
("Professor"),
("Secretaria");

/* INSERT INTO `disciplina` (`disciplina`) VALUES ('Banco de Dados'), ('Engenharia de Software'); */
/* INSERT INTO `professor` (`professor`) VALUES ('Prof1'), ('Prof2'); */
/* INSERT INTO `aluno` (`aluno`) VALUES ('a'), ('b'); */



/* Tabela agregadora turmas diciplina professor */
/* o professor so tera acesso a pagina de lançamento de notas das turmas na tabela agregadora para  essas diciplinas na que seu id seja igual */
