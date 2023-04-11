update  inscritos set pacote_id = 1 where data_inscricao < '2023-01-01' ;
update  inscritos set pacote_id = 2 where data_inscricao >= '2023-01-01' and data_inscricao < '2023-03-11';
update inscritos set pacote_id = 3 where data_inscricao >= '2023-03-11';