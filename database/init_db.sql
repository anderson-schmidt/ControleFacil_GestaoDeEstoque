create database IF NOT EXISTS controlefacil;
use controlefacil;

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
);

INSERT INTO `usuario` (`id`, `usuario`, `password`) VALUES
(1,	'admin@email.com',	'12345');

create table medicamentos(
id int auto_increment not null,
nome varchar(100) not null,
primary key (id)
);

create table medicamento_controle(
id int auto_increment not null,
dt_vencimento date not null,
lote varchar(50) not null, 
qtd int not null default 0,
id_med int not null, 
primary key (id),
FOREIGN KEY(id_med) REFERENCES medicamentos(id)
);

create table bordero(
id int auto_increment not null,
dt_evento datetime default now(),
id_med_ctrl int not null, 
qtd int not null,
primary key (id),
FOREIGN KEY(id_med_ctrl) REFERENCES medicamento_controle(id)
);

