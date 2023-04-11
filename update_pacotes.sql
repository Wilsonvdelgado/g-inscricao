INSERT INTO g_inscricao.pacotes
( nome, data_inicio, data_fim, valor)
VALUES( 'Pacote 1', '2022-11-01 00:00:00', '2022-12-31 00:00:00', 117400);
INSERT INTO g_inscricao.pacotes
( nome, data_inicio, data_fim, valor)
VALUES( 'Pacote 2', '2023-01-01 00:00:00', '2022-03-10 00:00:00', 118700);
INSERT INTO g_inscricao.pacotes
( nome, data_inicio, data_fim, valor)
VALUES( 'Pacote 3', '2023-01-01 00:00:00', '2023-03-19 00:00:00', 120000);


update  inscritos set pacote_id = 1 where data_inscricao < '2023-01-01' ;
update  inscritos set pacote_id = 2 where data_inscricao >= '2023-01-01' and data_inscricao < '2023-03-11';
update inscritos set pacote_id = 3 where data_inscricao >= '2023-03-11';