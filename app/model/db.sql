CREATE DATABASE torneioArduino;
USE torneioArduino;
DROP DATABASE torneioArduino;

DROP TABLE times;
DROP TABLE desafio;

CREATE TABLE professor (
    id_professor INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(250),
    senha VARCHAR(100), 
    PRIMARY KEY(id_professor)
);

SELECT * FROM professor;
SELECT * FROM desafio;
SELECT * FROM times;
INSERT INTO professor(nome, senha) VALUE('Guilherme', 'admin');

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

CREATE TABLE premiacao (
    id_premiacao INT NOT NULL AUTO_INCREMENT,
    descricao TEXT NOT NULL,
    id_professor INT NOT NULL,
    id_desafio INT NOT NULL,
    PRIMARY KEY(id_premiacao),
    FOREIGN KEY(id_professor) REFERENCES professor(id_professor),
    FOREIGN KEY(id_desafio) REFERENCES desafio(id_desafio)
);

INSERT INTO premiacao (descricao, id_professor, id_desafio) 
VALUES ('Prêmio liberado "KIT 01 ARDUINO" da fase 01', 1, 1);


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


Select * FROM desafio;

-- Criar Times com pontos inicializados como 0 (não precisa especificar explicitamente o valor de 'pontos')
INSERT INTO times (nome) VALUES ('Time 1');
INSERT INTO times (nome) VALUES ('Time 2');
INSERT INTO times (nome) VALUES ('Time 3');
INSERT INTO times (nome) VALUES ('Time 4');
INSERT INTO times (nome) VALUES ('Time 5');
INSERT INTO times (nome) VALUES ('Time 6');
INSERT INTO times (nome) VALUES ('Time 7');
INSERT INTO times (nome) VALUES ('Time 8');
INSERT INTO times (nome) VALUES ('Time 9');
INSERT INTO times (nome) VALUES ('Time 9');
INSERT INTO times (nome) VALUES ('Time 10');


-- Criar Desafios
INSERT INTO desafio (nome, descricao) VALUES ('Desafio 1', 'Descrição do desafio 1');
INSERT INTO desafio (nome, descricao) VALUES ('Desafio 2', 'Descrição do desafio 2');

-- Inserir pontuaçao
INSERT INTO pontuacao (id_times, id_desafio, pontos) VALUES (1, 1, 250);
INSERT INTO pontuacao (id_times, id_desafio, pontos) VALUES (1, 2, 100);

  
INSERT INTO pontuacao (id_times, id_desafio, pontos) VALUES (6, 1, 150); 
INSERT INTO pontuacao (id_times, id_desafio, pontos) VALUES (2, 2, 100);  
 
INSERT INTO pontuacao (id_times, id_desafio, pontos) VALUES (7, 1, 320);
INSERT INTO pontuacao (id_times, id_desafio, pontos) VALUES (3, 2, 100);

INSERT INTO pontuacao (id_times, id_desafio, pontos) VALUES (8, 1, 100);
INSERT INTO pontuacao (id_times, id_desafio, pontos) VALUES (4, 2, 100);

INSERT INTO pontuacao (id_times, id_desafio, pontos) VALUES (5, 1, 120);
INSERT INTO pontuacao (id_times, id_desafio, pontos) VALUES (5, 2, 130);
-- consultar os desafios
SELECT * FROM desafio;


-- Consultar todos os desafios e as pontuações de cada time
SELECT 
    t.nome AS time, 
    d.nome AS desafio, 
    p.pontos 
FROM pontuacao p
JOIN times t ON p.id_times = t.id_times
JOIN desafio d ON p.id_desafio = d.id_desafio
ORDER BY d.nome, t.nome;

-- Consultar a pontuação total de cada time
SELECT 
    t.nome AS time, 
    SUM(p.pontos) AS total_pontos
FROM pontuacao p
JOIN times t ON p.id_times = t.id_times
GROUP BY t.id_times
ORDER BY total_pontos DESC;

-- Consultar a pontuação de um time específico em todos os desafios
SELECT 
    d.nome AS desafio, 
    p.pontos 
FROM pontuacao p
JOIN desafio d ON p.id_desafio = d.id_desafio
WHERE p.id_times = ID_DO_TIME
ORDER BY d.nome;

-- Consultar todos os times e suas pontuações em um desafio específico
SELECT 
    t.nome AS time, 
    p.pontos 
FROM pontuacao p
JOIN times t ON p.id_times = t.id_times
WHERE p.id_desafio = ID_DO_DESAFIO
ORDER BY p.pontos DESC;


-- Consultar a quantidade de pontos de um time em um desafio específico
SELECT 
    p.pontos 
FROM pontuacao p
WHERE p.id_times = ID_DO_TIME
  AND p.id_desafio = ID_DO_DESAFIO;


-- Consultar os 5 times com mais pontos totais
SELECT 
    t.nome AS time, 
    SUM(p.pontos) AS total_pontos
FROM pontuacao p
JOIN times t ON p.id_times = t.id_times
GROUP BY t.id_times
ORDER BY total_pontos DESC
LIMIT 5;



