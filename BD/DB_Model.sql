
-- drop table Log;
create table Log
(
	id int not null auto_increment,
    constraint PK_Log primary key (id)
);

-- drop table Usuarios;
create table Usuarios
(
	id int not null auto_increment,
	Login varchar(255) unique not null,
    Senha varchar(255) not null,
    Email varchar(255) unique not null,
	Nome varchar(255),
    DT_criado datetime not null default now(),
    DT_ultima_senha datetime not null default now(),
    constraint PK_Usuarios primary key (id)
);

-- drop table Perfil;
create table Perfil
(
	id int not null auto_increment,
	Nome varchar(100) not null,
    Codigo varchar(30) not null,
    constraint PK_Perfil primary key (id)
);

-- drop table Permissoes;
create table Permissoes
(
	id int not null auto_increment,
	Nome varchar(255) not null,
	Controller varchar(80) not null,
    Action varchar(80) not null,
    constraint PK_Permissoes primary key (id)
);

-- drop table ItemMenu;
create table ItemMenu
(
	Menu varchar(80),
    Item varchar(80) not null,
	id int not null auto_increment,
    idPermissoes int,
    constraint PK_ItemMenu primary key (id),
    constraint FK_ItemMenu_Permissoes foreign key (idPermissoes) references Permissoes(id)
);

-- drop table UsuarioPerfil;
create table UsuarioPerfil
(
	idUsuario int not null,
    idPerfil int not null,
    constraint FK_UsuarioPerfil_Usuario foreign key (idUsuario) references Usuarios(id),
    constraint FK_UsuarioPerfil_Perfil foreign key (idPerfil) references Perfil(id)
);

-- drop table PerfilPermissoes;
create table PerfilPermissoes
(
    idPerfil int not null,
    idPermissoes int not null,
    constraint FK_PerfilPermissoes_Perfil foreign key (idPerfil) references Perfil(id),
    constraint FK_PerfilPermissoes_Permissoes foreign key (idPermissoes) references Permissoes(id)
);

-- drop table PermissoesItemMenu;
create table PermissoesItemMenu
(
	idItemMenu int not null,
    idPermissoes int not null,
    constraint FK_PermissoesItemMenu_ItemMenu foreign key (idItemMenu) references ItemMenu(id),
    constraint FK_PermissoesItemMenu_Permissoes foreign key (idPermissoes) references Permissoes(id)
);

create table Professor 
(
	id int not null auto_increment, 
    Nome varchar(255) not null, 
    Bio text, 
    MiniBio text,
    Cargo varchar(255),
    BolsaProdutividade varchar(255),
    Telefone varchar(50),
    Sala varchar(25), 
    Site varchar(255),
    Email varchar(255),
    Lattes varchar(255),
    Linkedin varchar(255),
    Scholar varchar(255),
    DBPL varchar(255),
    ORCID varchar(255),
    Publons varchar(255),
	constraint PK_Professor primary key (id)
);

create table Curriculo 
(
	id int not null auto_increment, 
    Nome varchar(255) not null, 
	constraint PK_Curriculo primary key (id)
);

create table Turma
(
	id int not null auto_increment,
    Codigo varchar(255) not null,
    MaximoAlunos int,
    Ano int, 
    Semestre int,
    codigoDisciplina varchar(10) not null,
    idDisciplina int,
    idProfessor int,
    idDisciplinaCache int,
    idProfessorCache int,
    constraint PK_Turma primary key (id), 
    constraint FK_Disc_Codigo foreign key (codigoDisciplina) references Disciplina(Codigo),
    constraint FK_Turma_Disciplina foreign key (idDisciplina) references Disciplina(id),
    constraint FK_Turma_Professor foreign key (idProfessor) references Professor(id),
    constraint FK_Turma_DisciplinaCache foreign key (idDisciplinaCache) references DisciplinaTurmaCache(id),
    constraint FK_Turma_ProfessorCache foreign key (idProfessorCache) references ProfessorTurmaCache(id) 
);

create table ProfessorTurmaCache
(
	id int not null auto_increment,
    Nome varchar(255) not null, 
    Bio text, 
    MiniBio text,
    Cargo varchar(255),
    BolsaProdutividade varchar(255),
    Telefone varchar(50),
    Sala varchar(25), 
    Site varchar(255),
    Email varchar(255),
    Lattes varchar(255),
    Linkedin varchar(255),
    Scholar varchar(255),
    DBPL varchar(255),
    ORCID varchar(255),
    Publons varchar(255),
    idTurma int, 
    constraint PK_ProfessorTurmaCache primary key (id),
    constraint FK_ProfessorTurmaCache_Turma foreign key (idTurma) references Turma(id)
);

create table DisciplinaTurmaCache
(
	id int not null auto_increment,
	Codigo varchar(10),
    Titulo varchar(255),
    Creditos int, 
    Ementa text,
    Optativa bool default false,
    idTurma int, 
    constraint PK_DisciplinaTurmaCache primary key (id),
	constraint FK_DisciplinaTurmaCache_Turma foreign key (idTurma) references Turma(id)
);

/*create table ProfessorTurma
(
    idProfessor int not null,
    idTurma int not null,
    constraint FK_ProfessorTurma_Professor foreign key (idProfessor) references Professor(id),
    constraint FK_ProfessorTurma_Turma foreign key (idTurma) references Turma(id)
);*/

create table CurriculoDisciplina
(
	codigoDisciplina varchar(10) not null,
    idCurriculo int not null,
    idDisciplina int,
    PeriodoNumero int,
    PeriodoNome varchar(255),
	constraint FK_Disc_Codigo foreign key (codigoDisciplina) references Disciplina(Codigo),
    constraint FK_CurriculoDisciplina_Curriculo foreign key (idCurriculo) references Curriculo(id),
    constraint FK_CurriculoDisciplina_Disciplina foreign key (idDisciplina) references Disciplina(id)
);