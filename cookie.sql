create database loja;

use loja;

create table usuario(
nome varchar(255) not null,
senha varchar(255) not null,
id int auto_increment primary key
);

create table imagens(
    id_img int auto_increment primary KEY,
    caminho LONGTEXT NOT NULL
);

INSERT INTO usuario (nome, senha) values ('admin', 'admin');

INSERT INTO imagens (caminho) 
VALUES 
('imgs/img1.webp'), 
('imgs/img2.webp'), 
('imgs/img3.webp'), 
('imgs/img4.webp'), 
('imgs/img5.webp');






