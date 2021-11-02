create table tblSexo(
	idSexo int not null auto_increment primary key,
    sigla varchar(2) not null,
    descricao varchar(45) not null,
    unique key(idSexo)
);

###################################
##CRUD tblSexo
###################################

#Inserção

insert into tblSexo (sigla, descricao) values ('M', 'masculino');
insert into tblSexo (sigla, descricao) values ('F', 'feminino');
insert into tblSexo (sigla, descricao) values ('O', 'outro');
update tblsexo set sigla = "O", descricao = "outro" where idSexo = 3; 

##################################################################################

create table tblPrestadores (
	idPrestador int not null auto_increment primary key,
    idProfissao int not null,
    idSexo int not null,
    nome varchar (100) not null,
    email varchar (100) not null,
    senha varchar (45) not null,
    descricao varchar(500) not null,
    telefone varchar (15) not null,
    dataNascimento date not null,
    foto blob not null,
    unique key (idPrestador),
    
    constraint FK_idPrrofissao_tblPrestadores
    foreign key (idProfissao)
    references tblProfissao (idProfissao),
    
    constraint FK_Sexo_Prestadores
    foreign key (idSexo)
    references tblSexo (idSexo)
);

###################################
##CRUD tblPrestadores
###################################

#Inserção

insert into tblprestadores (idProfissao, idSexo, nome, email, senha, descricao, telefone, dataNascimento, foto)
values (1, 1, 'Jonatan Vinicius Valdivia', 'jonatan.viniciusvaldivia@outlook.com', '', 
'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud 
exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
'(11)94026-4454', '2003-11-18', 01010100);

update tblprestadores set idProfissao = 1 where idPrestador = 20;

#Seleção

select tblprestadores.idPrestador as idPrestador,
tblprestadores.nome as nome,
tblsexo.descricao as sexo, 
date_format(dataNascimento, '%d/%m/%Y') as dataNascimento, 
YEAR(CURDATE()) - YEAR(dataNascimento) as idade,
tblprestadores.email as email,
tblprestadores.telefone as telefone,
tblEnderecoPrestadores.uf as uf, 
tblEnderecoPrestadores.cidade as cidade, 
tblEnderecoPrestadores.bairro as bairro, 
tblEnderecoPrestadores.rua as rua, 
tblEnderecoPrestadores.numero as numero, 
tblEnderecoPrestadores.complemento as complemento, 
tblEnderecoPrestadores.cep as CEP,
tblprofissao.nomeProfissao as profissao,
tblprestadores.descricao as descricao,
tblPrestadores.foto as foto
from tblprestadores 
inner join tblsexo
on tblsexo.idSexo = tblprestadores.idSexo
inner join tblEnderecoPrestadores
on tblprestadores.idPrestador = tblEnderecoPrestadores.idPrestador
inner join tblprofissao
on tblprofissao.idprofissao = tblprestadores.idProfissao;

##Pelo id

select tblprestadores.idPrestador as idPrestador,
tblprestadores.nome as nome,
tblsexo.descricao as sexo, 
date_format(dataNascimento, '%d/%m/%Y') as dataNascimento, 
YEAR(CURDATE()) - YEAR(dataNascimento) as idade,
tblprestadores.email as email,
tblprestadores.telefone as telefone,
tblEnderecoPrestadores.uf as uf, 
tblEnderecoPrestadores.cidade as cidade, 
tblEnderecoPrestadores.bairro as bairro, 
tblEnderecoPrestadores.rua as rua, 
tblEnderecoPrestadores.numero as numero, 
tblEnderecoPrestadores.complemento as complemento, 
tblEnderecoPrestadores.cep as CEP,
tblprofissao.nomeProfissao as profissao,
tblprestadores.descricao as descricao,
tblPrestadores.foto as foto
from tblprestadores 
inner join tblsexo
on tblsexo.idSexo = tblprestadores.idSexo
inner join tblEnderecoPrestadores
on tblprestadores.idPrestador = tblEnderecoPrestadores.idPrestador
inner join tblprofissao
on tblprofissao.idprofissao = tblprestadores.idProfissao
where tblprestadores.idPrestador = 1;

## seleção pela profissão que exerce

SELECT tblprestadores.nome as nome, 
    date_format(dataNascimento, '%d/%m/%Y') as dataNascimento, 
	YEAR(CURDATE()) - YEAR(dataNascimento) as idade,
    tblsexo.descricao as sexo,
    tblEnderecoPrestadores.uf as estado,
    tblEnderecoPrestadores.cidade as cidade,
    tblEnderecoPrestadores.bairro as bairro, 
    tblEnderecoPrestadores.rua as rua, 
    tblEnderecoPrestadores.numero as numero, 
    tblEnderecoPrestadores.complemento as complemento,
    tblEnderecoPrestadores.cep as CEP, 
    tblprestadores.email as email,
    tblprestadores.telefone as Telefone,
    tblprofissao.nomeProfissao as nomeProfissao,
    tblPrestadores.descricao as descricao,
    tblprestadores.foto as foto
    from tblprestadores left join tblprofissao
	on tblprofissao.idProfissao = tblPrestadores.idProfissao
    left join tblEnderecoPrestadores 
    on tblprestadores.idPrestador = tblEnderecoPrestadores.idPrestador
    left join tblsexo
    on tblprestadores.idsexo = tblsexo.idsexo
    where tblprofissao.nomeProfissao like '%A%';

##################################################################################

create table tblProfissao (
	idProfissao int not null auto_increment primary key,
    nomeProfissao varchar (100) not null,
    unique key (idProfissao)
);

#Selecioar todas as profissoes
SELECT idProfissao, nomeProfissao from tblprofissao;

#Selecionar profissao pelo id
select tblprestadores.nome as nome, 
tblprofissao.nomeProfissao as profissao 
from tblprofissao inner join tblprestadores 
on tblprestadores.idPrestador = tblprofissao.idPrestador
where idProfissao = 2;  

SELECT tblProfissao.idProfissao as idProfissao, 
    tblprofissao.nomeProfissao as nomeProfissao, 
    tblprestadores.nome as nomePrestador 
    from tblprofissao inner join tblprestadores 
    on tblprestadores.idPrestador = tblprofissao.idPrestador 
    where idProfissao = 2; 


###################################
##CRUD tblProfissao
###################################

SELECT tblProfissao.idProfissao as idProfissao, 
    tblprofissao.nomeProfissao as nomeProfissao, 
    tblprestadores.nome as nomePrestador 
    from tblprofissao inner join tblprestadores 
    on  tblprofissao.idProfissao = tblprestadores.idProfissao 
    where tblprofissao.idProfissao = 1; 

#Inserção

insert into tblprofissao (nomeProfissao) values ('Pintor');

#Atualização



##################################################################################

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

###################################
##CRUD tblEndereco
###################################

#Inserção

insert into tblEnderecoPrestadores (idPrestador, uf, cidade, bairro, rua, numero, complemento, cep) values 
(1,'SP', 'Jandira', 'Vila Eunice', 'Júpiter', '174', '', '06602170');
insert into tblEnderecoPrestadores (idPrestador, uf, cidade, bairro, rua, numero, complemento, cep) values 
(2,'SP', 'Tatuí', 'Vila Monte Verde', 'Maria Ordália Teles', '49', '', '18279692');

#seleção

select tblEnderecoPrestadores.idEndereco, 
tblEnderecoPrestadores.idPrestador, 
tblprestadores.nome as nomePrestador, 
tblEnderecoPrestadores.uf, 
tblEnderecoPrestadores.cidade,
tblEnderecoPrestadores.bairro, 
tblEnderecoPrestadores.rua,
tblEnderecoPrestadores.numero,
tblEnderecoPrestadores.complemento,
tblEnderecoPrestadores.cep
from tblEnderecoPrestadores inner join tblprestadores
on tblEnderecoPrestadores.idPrestador = tblprestadores.idPrestador;


select idEnderecoPrestador, idPrestador, uf, cidade, bairro, rua, numero, complemento, cep from tblEnderecoPrestadores;

select uf, cidade, bairro, rua, numero, complemento, cep from tblendereco where idEndereco = 1;

INSERT into tblEnderecoPrestadores (idPrestador, uf, cidade, bairro, rua, numero, complemento, cep) 
    values (2, 'SP', 'Tatuí', 'Vila Monte Verde', 'Maria Ordália Teles', '174', '', '18279692');

#Atualização


##################################################################################

create table tblClientes (
	idCliente int not null auto_increment primary key,
    idSexo int not null,
    nome varchar (100) not null,
    email varchar (100) not null,
    senha varchar (45) not null,
    telefone varchar (15) not null,
    dataNascimento date not null,
    foto blob not null,
    unique key (idCliente),
    
    constraint FK_Sexo_Clientes
    foreign key (idSexo)
    references tblSexo (idSexo)
);

###################################
##CRUD tblClientes
###################################

#seleção

select tblclientes.idCliente, 
tblclientes.nome,
tblsexo.descricao as sexo,  
date_format(dataNascimento, '%d/%m/%Y') as dataNascimento, 
YEAR(CURDATE()) - YEAR(dataNascimento) as idade,
tblclientes.email, 
tblclientes.senha, 
tblclientes.telefone, 
tblEnderecoClientes.uf as uf, 
tblEnderecoClientes.cidade as cidade, 
tblEnderecoClientes.bairro as bairro, 
tblEnderecoClientes.rua as rua, 
tblEnderecoClientes.numero as numero, 
tblEnderecoClientes.complemento as complemento, 
tblEnderecoClientes.cep as CEP,
tblclientes.foto from tblclientes inner join tblSexo on
tblclientes.idSexo = tblsexo.idSexo
inner join tblenderecoclientes on 
tblenderecoclientes.idCliente = tblclientes.idCliente;


#Busca pelo id

select tblclientes.idCliente, 
tblclientes.nome,
tblsexo.descricao as sexo,  
date_format(dataNascimento, '%d/%m/%Y') as dataNascimento, 
YEAR(CURDATE()) - YEAR(dataNascimento) as idade,
tblclientes.email, 
tblclientes.senha, 
tblclientes.telefone, 
tblEnderecoClientes.uf as uf, 
tblEnderecoClientes.cidade as cidade, 
tblEnderecoClientes.bairro as bairro, 
tblEnderecoClientes.rua as rua, 
tblEnderecoClientes.numero as numero, 
tblEnderecoClientes.complemento as complemento, 
tblEnderecoClientes.cep as CEP,
tblclientes.foto from tblclientes inner join tblSexo on
tblclientes.idSexo = tblsexo.idSexo
inner join tblenderecoclientes on 
tblenderecoclientes.idCliente = tblclientes.idCliente
where tblClientes.idCliente = 1;
#Inserção 

insert into tblclientes (idSexo, nome, email, senha, telefone, dataNascimento, foto) values 
(1, 'Jonatan Vinicius Valdivia', 'jonatan.viniciusvaldivia@outlook.com', 'JJ1974vv', '(11)94026-4454', '2003-11-18', 01010101);
#update

update tblclientes set idSexo = '2', nome = 'TESTE2', email = 'TESTE@OUTLOOK.COM', senha = md5('TESTE'),
telefone = '(11)99999-9999', dataNascimento = '1980-10-10', foto = 1010101 where idCliente = 2;

##################################################################################

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
##CRUD tblEnderecoClientes
###################################

#seleção
select tblEnderecoClientes.idEnderecoCliente, 
tblEnderecoClientes.idCliente, 
tblClientes.nome, 
tblEnderecoClientes.uf, 
tblEnderecoClientes.cidade,
tblEnderecoClientes.bairro, 
tblEnderecoClientes.rua,
tblEnderecoClientes.numero,
tblEnderecoClientes.complemento,
tblEnderecoClientes.cep
from tblEnderecoClientes inner join tblClientes
on tblEnderecoClientes.idCliente = tblClientes.idCliente;

select tblEnderecoClientes.idEnderecoCliente, 
tblEnderecoClientes.idCliente, 
tblClientes.nome, 
tblEnderecoClientes.uf, 
tblEnderecoClientes.cidade,
tblEnderecoClientes.bairro, 
tblEnderecoClientes.rua,
tblEnderecoClientes.numero,
tblEnderecoClientes.complemento,
tblEnderecoClientes.cep
from tblEnderecoClientes inner join tblClientes
on tblEnderecoClientes.idCliente = tblClientes.idCliente
where tblenderecoclientes.idEnderecoCliente = 1;


#inserção

insert into tblenderecoclientes (idCliente, uf, cidade, bairro, rua, numero, complemento, cep) values
(1, 'SP', 'Jandira', 'Vila Eunice', 'Júpiter', '174', '', '06602170');

#Atualização

update tblEnderecoClientes set uf = 'SP', cidade = 'TESTEAEEE', bairro = 'TESTEAEEE',
 rua = 'TESTEAEEE', numero = 18, complemento = 'TESTEAEEE', cep = 'TESTEAEEE' 
 where idEnderecoCliente = 2;

##################################################################################

##################
##Todos os selects
##################
select * from tblEnderecoPrestadores;
select * from tblprestadores;
desc tblprestadores;
select * from tblprofissao;
select * from tblsexo;
select * from tblClientes;
select * from tblEnderecoClientes;

delete from tblprestadores where idPrestador = 17;
delete from tblEnderecoPrestadores where idPrestador = 17;

SELECT * from tblClientes where email = 'precisavaDesteTeste@gmail.com';

SELECT idCliente from tblclientes where email = 'teste@outlook.com';

#todos os desc de todas as tabelas
desc tblClientes;
desc tblprestadores;

#Alterações necessárias
RENAME TABLE tblEndereco TO tblEnderecoPrestadores;
ALTER TABLE tblCLientes
CHANGE senha senha VARCHAR(255);
ALTER TABLE tblprestadores
CHANGE senha senha VARCHAR(255);
ALTER TABLE tblprestadores
CHANGE foto foto text;
ALTER TABLE tblclientes
CHANGE foto foto VARCHAR(500);
