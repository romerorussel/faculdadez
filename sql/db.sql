/* 
 * Create By: Romero Russel
 * Date: 15/05/2017
 * Time: 11:43
 * Begin DB
 */
CREATE DATABASE faculdadez;
use faculdadez;

/*
 * Creating Tables
 */
CREATE TABLE estudante(
						id INT NOT NULL AUTO_INCREMENT,
						nome VARCHAR(50) NOT NULL,
						cpf  VARCHAR(11) NOT NULL PRIMARY KEY,
						matricula VARCHAR(11) NOT NULL

);
CREATE TABLE professor(
						id INT NOT NULL AUTO_INCREMENT,
						nome VARCHAR(50) NOT NULL,
						cpf VARCHAR(11) NOT NULL PRIMARY KEY,
						matricula VARCHAR(11) NOT NULL,
						horario VARCHAR(10) NOT NULL,

);

CREATE TABLE curso(
					id INT NOT NULL AUTO_INCREMENT,
					curso VARCHAR(25) NOT NULL

);
CREATE TABLE disciplina(
						id INT NOT NULL AUTO_INCREMENT,
						disciplina VARCHAR(25) NOT NULL,
						complexidade VARCHAR(10) NOT NULL,
						periodo CHAR(1) NOT NULL,
);

CREATE TABLE usuario(
						id INT NOT NULL AUTO_INCREMENT,	
						senha VARCHAR(9) NOT NULL
);

/*
 * Foreign Key References
 */


-- Foreign Key estudante
ALTER TABLE `estudante` ADD CONSTRAINT `fk_curso` FOREIGN KEY ( `curso` ) REFERENCES `curso` ( `curso` ) ;
ALTER TABLE `estudante` ADD CONSTRAINT `fk_periodo` FOREIGN KEY ( `periodo` ) REFERENCES `disciplina` ( `periodo` ) ;

-- Foreign Key professor

ALTER TABLE `professor` ADD CONSTRAINT `fk_disciplina` FOREIGN KEY ( `disciplina` ) REFERENCES `disciplina` ( `disciplina` ) ;

-- Foreign Key curso

ALTER TABLE `curso` ADD CONSTRAINT `fk_disciplina_curso` FOREIGN KEY ( `disciplina` ) REFERENCES `disciplina` ( `disciplina` ) ;

-- Foreign Key usuario
ALTER TABLE `usuario` ADD CONSTRAINT `fk_cpf` FOREIGN KEY ( `cpf_estudante` ) REFERENCES `estudante` ( `cpf` ) ;

