create database king_of_services;
use king_of_services;

###################################
##CRUD tblSexo
###################################

create table tblSexo(
	idSexo int not null auto_increment primary key,
    sigla varchar(2) not null,
    descricao varchar(45) not null,
    unique key(idSexo)
);

#Inserção

insert into tblSexo (sigla, descricao) values ('M', 'masculino');
insert into tblSexo (sigla, descricao) values ('F', 'feminino');
insert into tblSexo (sigla, descricao) values ('O', 'outro');
update tblsexo set sigla = "O", descricao = "outro" where idSexo = 3; 

##################################################################################

###################################
##CRUD tblPrestadores
###################################

create table tblPrestadores (
	idPrestador int not null auto_increment primary key,
    idProfissao int not null,
    idSexo int not null,
    nome varchar (255) not null,
    email varchar (255) not null,
    senha varchar (255) not null,
    descricao varchar(500) not null,
    telefone varchar (15) not null,
    dataNascimento date not null,
    foto text,
    unique key (idPrestador),
    
    constraint FK_idPrrofissao_tblPrestadores
    foreign key (idProfissao)
    references tblProfissao (idProfissao),
    
    constraint FK_Sexo_Prestadores
    foreign key (idSexo)
    references tblSexo (idSexo)
);

#Inserção

insert into tblprestadores (idProfissao, idSexo, nome, email, senha, descricao, telefone, dataNascimento, foto)
values (1, 1, 'Jonatan Vinicius Valdivia', 'jonatan.viniciusvaldivia@outlook.com', '', 
'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud 
exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
'(11)94026-4454', '2003-11-18', 01010100);

##################################################################################

###################################
##CRUD tblProfissao
###################################

create table tblProfissao (
	idProfissao int not null auto_increment primary key,
    nomeProfissao varchar (100) not null,
    unique key (idProfissao)
);

/**
	INSERTS PARA A TBLPROFISSAO
*/

insert into tblProfissao (nomeProfissao) values ('Acupuntor ');
insert into tblProfissao (nomeProfissao) values ('Administrador');
insert into tblProfissao (nomeProfissao) values ('Advogado');
insert into tblProfissao (nomeProfissao) values ('Alfaiate');
insert into tblProfissao (nomeProfissao) values ('Analista');
insert into tblProfissao (nomeProfissao) values ('Analista');
insert into tblProfissao (nomeProfissao) values ('Animador');
insert into tblProfissao (nomeProfissao) values ('Anotador');
insert into tblProfissao (nomeProfissao) values ('Apresentador');
insert into tblProfissao (nomeProfissao) values ('Arlegista');
insert into tblProfissao (nomeProfissao) values ('Artezao');
insert into tblProfissao (nomeProfissao) values ('Astrologo');
insert into tblProfissao (nomeProfissao) values ('Astronomo');
insert into tblProfissao (nomeProfissao) values ('Ator');
insert into tblProfissao (nomeProfissao) values ('Barbeiro');
insert into tblProfissao (nomeProfissao) values ('Bibliotecario');
insert into tblProfissao (nomeProfissao) values ('Botanico');
insert into tblProfissao (nomeProfissao) values ('Cabalaireiro');
insert into tblProfissao (nomeProfissao) values ('Calista');
insert into tblProfissao (nomeProfissao) values ('Cantor');
insert into tblProfissao (nomeProfissao) values ('Cardiologista');
insert into tblProfissao (nomeProfissao) values ('Carpinteiro');
insert into tblProfissao (nomeProfissao) values ('Compositor');
insert into tblProfissao (nomeProfissao) values ('Cozinheiro');
insert into tblProfissao (nomeProfissao) values ('Cuidador');
insert into tblProfissao (nomeProfissao) values ('Decorador');
insert into tblProfissao (nomeProfissao) values ('Dentista');
insert into tblProfissao (nomeProfissao) values ('Desenhista');
insert into tblProfissao (nomeProfissao) values ('Design');
insert into tblProfissao (nomeProfissao) values ('Destrador');
insert into tblProfissao (nomeProfissao) values ('Developer');
insert into tblProfissao (nomeProfissao) values ('Diarista');
insert into tblProfissao (nomeProfissao) values ('Eletricista');
insert into tblProfissao (nomeProfissao) values ('Engenheiro ');
insert into tblProfissao (nomeProfissao) values ('Escritor');
insert into tblProfissao (nomeProfissao) values ('Estilista');
insert into tblProfissao (nomeProfissao) values ('Faxineira');
insert into tblProfissao (nomeProfissao) values ('Figurinista');
insert into tblProfissao (nomeProfissao) values ('Fisico');
insert into tblProfissao (nomeProfissao) values ('Florista');
insert into tblProfissao (nomeProfissao) values ('Forjador');
insert into tblProfissao (nomeProfissao) values ('Fotógrafo');
insert into tblProfissao (nomeProfissao) values ('Gerente');
insert into tblProfissao (nomeProfissao) values ('Gestor');
insert into tblProfissao (nomeProfissao) values ('Historiador');
insert into tblProfissao (nomeProfissao) values ('Homeopata');
insert into tblProfissao (nomeProfissao) values ('Jardineiro');
insert into tblProfissao (nomeProfissao) values ('Joalheiro');
insert into tblProfissao (nomeProfissao) values ('Locutor');
insert into tblProfissao (nomeProfissao) values ('Maestro');
insert into tblProfissao (nomeProfissao) values ('Magico');
insert into tblProfissao (nomeProfissao) values ('Maquiador');
insert into tblProfissao (nomeProfissao) values ('Maquinista');
insert into tblProfissao (nomeProfissao) values ('Marceneiro');
insert into tblProfissao (nomeProfissao) values ('Matematico');
insert into tblProfissao (nomeProfissao) values ('Medico');
insert into tblProfissao (nomeProfissao) values ('Mergulhador');
insert into tblProfissao (nomeProfissao) values ('Modelo');
insert into tblProfissao (nomeProfissao) values ('Motorista');
insert into tblProfissao (nomeProfissao) values ('Músico');
insert into tblProfissao (nomeProfissao) values ('Numerologo');
insert into tblProfissao (nomeProfissao) values ('Nutricionista ');
insert into tblProfissao (nomeProfissao) values ('Obstreta');
insert into tblProfissao (nomeProfissao) values ('Oleiro');
insert into tblProfissao (nomeProfissao) values ('Operador');
insert into tblProfissao (nomeProfissao) values ('Ortopedista');
insert into tblProfissao (nomeProfissao) values ('Padeiro');
insert into tblProfissao (nomeProfissao) values ('Palhaço');
insert into tblProfissao (nomeProfissao) values ('Pedreiro');
insert into tblProfissao (nomeProfissao) values ('Pedreiro');
insert into tblProfissao (nomeProfissao) values ('Perfumista');
insert into tblProfissao (nomeProfissao) values ('Personal');
insert into tblProfissao (nomeProfissao) values ('Pianista');
insert into tblProfissao (nomeProfissao) values ('Polidor');
insert into tblProfissao (nomeProfissao) values ('Porteiro');
insert into tblProfissao (nomeProfissao) values ('Produtor');
insert into tblProfissao (nomeProfissao) values ('Professor');
insert into tblProfissao (nomeProfissao) values ('Programador');
insert into tblProfissao (nomeProfissao) values ('Psicologo');
insert into tblProfissao (nomeProfissao) values ('Psiquiatra');
insert into tblProfissao (nomeProfissao) values ('Queijeiro');
insert into tblProfissao (nomeProfissao) values ('Restaurador');
insert into tblProfissao (nomeProfissao) values ('Roteirista');
insert into tblProfissao (nomeProfissao) values ('Sapateiro');
insert into tblProfissao (nomeProfissao) values ('Seguranca');
insert into tblProfissao (nomeProfissao) values ('Serralheiro');
insert into tblProfissao (nomeProfissao) values ('Soldador');
insert into tblProfissao (nomeProfissao) values ('Tarologo');
insert into tblProfissao (nomeProfissao) values ('Terapeuta');
insert into tblProfissao (nomeProfissao) values ('Tradutor');
insert into tblProfissao (nomeProfissao) values ('Treinador');
insert into tblProfissao (nomeProfissao) values ('Ui');
insert into tblProfissao (nomeProfissao) values ('Ux');
insert into tblProfissao (nomeProfissao) values ('Vendedor');
insert into tblProfissao (nomeProfissao) values ('Veterinario');
insert into tblProfissao (nomeProfissao) values ('Vigilante');
insert into tblProfissao (nomeProfissao) values ('Zelador');

##################################################################################

###################################
##CRUD tblEnderecoPrestadores
###################################

create table tblEnderecoPrestadores (
	idEnderecoPrestador int not null auto_increment primary key,
    idPrestador int not null,
    uf varchar (2) not null,
    cidade varchar (100) not null,
    bairro varchar (100) not null,
    rua varchar (100) not null,
    numero int not null,
    complemento varchar (25),
    cep varchar (9) not null,
    unique key (idEnderecoPrestador),
    
    constraint FK_idPrestador_tblEndereco
    foreign key (idPrestador)
    references tblprestadores (idPrestador)
);

##################################################################################

###################################
##CRUD tblClientes
###################################

create table tblClientes (
	idCliente int not null auto_increment primary key,
    idSexo int not null,
    nome varchar (255) not null,
    email varchar (255) not null,
    senha varchar (255) not null,
    descricao varchar(500),
    telefone varchar (15) not null,
    dataNascimento date not null,
    foto varchar(500),
    unique key (idCliente),
    
    constraint FK_Sexo_Clientes
    foreign key (idSexo)
    references tblSexo (idSexo)
);

##################################################################################

###################################
##CRUD tblEnderecoClientes
###################################

create table tblEnderecoClientes (
	idEnderecoCliente int not null auto_increment primary key,
    idCliente int not null,
    uf varchar (2) not null,
    cidade varchar (100) not null,
    bairro varchar (100) not null,
    rua varchar (100) not null,
    numero int not null,
    complemento varchar (25),
    cep varchar (9) not null,
    unique key (idEnderecoCliente),
    
    constraint FK_idCliente_tblEndereco
    foreign key (idCliente)
    references tblClientes (idCliente)
);

###################################
##CRUD tblServicosPrestador
###################################

create table tblServicosPrestador(
	idServicoPrestador int not null auto_increment primary key,
    unique key (idServicoPrestador),
    idPrestador int not null, 
    idCliente int not null,
    descricao varchar(500),
    statusServico enum ('aceitar','pendente','concluido'),
    
    constraint FK_idPrestador_tblServicosPrestador
    foreign key (idPrestador)
    references tblprestadores (idPrestador),
    
    constraint FK_idCliente_tblServicosPrestador
    foreign key (idCliente)
    references tblClientes (idCliente)
);

##################
##Todos os selects e descs
##################

select * from tblEnderecoPrestadores;
select * from tblprestadores;
select * from tblprofissao;
select * from tblsexo;
select * from tblClientes;
select * from tblEnderecoClientes;
select * from tblServicosPrestador;

desc tblsexo;
desc tblprestadores;
desc tblprofissao;
desc tblenderecoprestadores;
desc tblclientes;
desc tblenderecoclientes;
desc tblservicosprestador;

///////////////////////////////////////////
///////////////////////////////////////////
/////////Alterações necessárias////////////
///////////////////////////////////////////
///////////////////////////////////////////

RENAME TABLE tblEndereco TO tblEnderecoPrestadores;

ALTER TABLE tblCLientes
CHANGE senha senha VARCHAR(255);

ALTER TABLE tblprestadores
CHANGE senha senha VARCHAR(255);

ALTER TABLE tblprestadores
CHANGE foto foto text;

ALTER TABLE tblclientes
CHANGE foto foto VARCHAR(500);

ALTER TABLE tblclientes ADD COLUMN descricao VARCHAR(500) after senha;

ALTER TABLE tblclientes ADD COLUMN registro TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP after foto;

ALTER TABLE tblprestadores ADD COLUMN registro TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP after foto;

