create DATABASE db_desafiophp;

create table produtos(
    id int PRIMARY key not null AUTO_INCREMENT,
    nome varchar(100) not null,
    cor varchar(50) not null,
    preco decimal(8,2) not null
);