docker-compose build 
docker-compose up



docker-compose down



1) bordero 

1 - media de saida do remedio em 30 dias 
select id_med_con, mean(*) media from bordero where data <= 30 dias 

2 - select id_med_con, (now() - data_vencimento) as dia, qtd from medicament_controle where (now() - data_vencimento) < 30


3 - (media * dia_vencimento) >= qtd  

