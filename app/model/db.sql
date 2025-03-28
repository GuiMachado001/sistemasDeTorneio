CREATE DATABASE torneioArduino;
USE torneioArduino;

CREATE TABLE professor (
    id_professor INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(250),
    senha VARCHAR(100), 
    PRIMARY KEY(id_professor)
);

INSERT INTO professor(nome, senha) VALUE('Enilda', 'admin');

CREATE TABLE times (
    id_times INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(200),
    id_professor INT,
    PRIMARY KEY(id_times),
    FOREIGN KEY(id_professor) REFERENCES professor(id_professor)
);

CREATE TABLE desafio (
    id_desafio INT NOT NULL AUTO_INCREMENT,
    pontos INT,
    enunciado VARCHAR(200),
    opcaoA CHAR(250),
    opcaoB CHAR(250),
    opcaoC CHAR(250),
    opcaoD CHAR(250),
    opcaoE CHAR(250),
    resposta CHAR(1), 
    id_professor INT,
    PRIMARY KEY(id_desafio),
    FOREIGN KEY(id_professor) REFERENCES professor(id_professor)
);

CREATE TABLE pontuacao (
    id_pontuacao INT NOT NULL AUTO_INCREMENT,
    id_times INT,
    id_desafio INT,
    pontos INT,
    PRIMARY KEY(id_pontuacao),
    FOREIGN KEY(id_times) REFERENCES times(id_times),
    FOREIGN KEY(id_desafio) REFERENCES desafio(id_desafio)
);


DELIMITER //

CREATE TRIGGER after_insert_time
AFTER INSERT ON times
FOR EACH ROW
BEGIN
    INSERT INTO pontuacao (id_times, id_desafio, pontos) 
    VALUES (NEW.id_times, NULL, 0); 
END;

//
DELIMITER ;

select * from times;

INSERT INTO pontuacao (id_times, id_desafio, pontos)
VALUES (9, 1, 200); 

INSERT INTO pontuacao (id_times, id_desafio, pontos)
VALUES (10, 1, 220); 

INSERT INTO pontuacao (id_times, id_desafio, pontos)
VALUES (14, 1, 250); 



SELECT 
    t.id_times, 
    t.nome AS nome_time,
    p.pontos,
    d.enunciado AS desafio_enunciado
FROM 
    times t
LEFT JOIN 
    pontuacao p ON t.id_times = p.id_times
LEFT JOIN 
    desafio d ON p.id_desafio = d.id_desafio
ORDER BY 
    t.id_times;
