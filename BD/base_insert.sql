-- Permissoes
insert into Permissoes (Nome, Controller, Action) values ('Dashboard','Dashboard', 'index');

insert into Permissoes (Nome, Controller, Action) values ('Ver usuarios','Usuarios', 'index');
insert into Permissoes (Nome, Controller, Action) values ('Adicionar usuarios','Usuarios', 'add');
insert into Permissoes (Nome, Controller, Action) values ('Editar usuarios','Usuarios', 'edit');
insert into Permissoes (Nome, Controller, Action) values ('Apagar usuarios','Usuarios', 'delete');

insert into Permissoes (Nome, Controller, Action) values ('Ver Perfil','Perfil', 'index');
insert into Permissoes (Nome, Controller, Action) values ('Adicionar Perfil','Perfil', 'add');
insert into Permissoes (Nome, Controller, Action) values ('Editar Perfil','Perfil', 'edit');
insert into Permissoes (Nome, Controller, Action) values ('Apagar Perfil','Perfil', 'delete');

insert into Permissoes (Nome, Controller, Action) values ('Ver Permissoes','Permissoes', 'index');
insert into Permissoes (Nome, Controller, Action) values ('Adicionar Permissoes','Permissoes', 'add');
insert into Permissoes (Nome, Controller, Action) values ('Editar Permissoes','Permissoes', 'edit');
insert into Permissoes (Nome, Controller, Action) values ('Apagar Permissoes','Permissoes', 'delete');

insert into Permissoes (Nome, Controller, Action) values ('Ver Item Menu','ItemMenu', 'index');
insert into Permissoes (Nome, Controller, Action) values ('Adicionar Item Menu','ItemMenu', 'add');
insert into Permissoes (Nome, Controller, Action) values ('Editar Item Menu','ItemMenu', 'edit');
insert into Permissoes (Nome, Controller, Action) values ('Apagar Item Menu','ItemMenu', 'delete');

insert into Permissoes (Nome, Controller, Action) values ('Ver Disciplinas','disciplina', 'index');

insert into Permissoes (Nome, Controller, Action) values ('Ver Bibliografias','bibliografia', 'index');
insert into Permissoes (Nome, Controller, Action) values ('Adicionar Bibliografias','bibliografia', 'add');
insert into Permissoes (Nome, Controller, Action) values ('Editar Bibliografias','bibliografia', 'edit');
insert into Permissoes (Nome, Controller, Action) values ('Apagar Bibliografias','bibliografia', 'delete');

insert into Permissoes (Nome, Controller, Action) values ('Ver Professores','professor', 'index');
insert into Permissoes (Nome, Controller, Action) values ('Adicionar Professor','professor', 'add');
insert into Permissoes (Nome, Controller, Action) values ('Editar Professor','professor', 'edit');
insert into Permissoes (Nome, Controller, Action) values ('Apagar Professor','professor', 'delete');

insert into Permissoes (Nome, Controller, Action) values ('Ver Curriculos','curriculo', 'index');
insert into Permissoes (Nome, Controller, Action) values ('Adicionar Curriculos','curriculo', 'add');
insert into Permissoes (Nome, Controller, Action) values ('Editar Curriculos','curriculo', 'edit');
insert into Permissoes (Nome, Controller, Action) values ('Apagar Curriculos','curriculo', 'delete');

-- Perfis
insert into Perfil (Nome, Codigo) values ('Administrador', 'Admin');
insert into Perfil (Nome, Codigo) values ('Usuario', 'User');

-- ItemMenu
insert into ItemMenu (Item, IdPermissoes) values ('Home', 1);
insert into ItemMenu (Menu, Item, IdPermissoes) values ('Admin', 'Usuarios', 2);
insert into ItemMenu (Menu, Item, IdPermissoes) values ('Admin', 'Perfis', 6);
insert into ItemMenu (Menu, Item, IdPermissoes) values ('Admin', 'Permissoes', 10);
insert into ItemMenu (Menu, Item, IdPermissoes) values ('Admin', 'Item Menu', 14);

-- PerfilPermissoes
insert into PerfilPermissoes (idPerfil, idPermissoes) values (1, 1);
insert into PerfilPermissoes (idPerfil, idPermissoes) values (1, 2);
insert into PerfilPermissoes (idPerfil, idPermissoes) values (1, 3);
insert into PerfilPermissoes (idPerfil, idPermissoes) values (1, 4);
insert into PerfilPermissoes (idPerfil, idPermissoes) values (1, 5);
insert into PerfilPermissoes (idPerfil, idPermissoes) values (1, 6);
insert into PerfilPermissoes (idPerfil, idPermissoes) values (1, 7);
insert into PerfilPermissoes (idPerfil, idPermissoes) values (1, 8);
insert into PerfilPermissoes (idPerfil, idPermissoes) values (1, 9);
insert into PerfilPermissoes (idPerfil, idPermissoes) values (1, 10);
insert into PerfilPermissoes (idPerfil, idPermissoes) values (1, 11);
insert into PerfilPermissoes (idPerfil, idPermissoes) values (1, 12);
insert into PerfilPermissoes (idPerfil, idPermissoes) values (1, 13);
insert into PerfilPermissoes (idPerfil, idPermissoes) values (1, 14);
insert into PerfilPermissoes (idPerfil, idPermissoes) values (1, 15);
insert into PerfilPermissoes (idPerfil, idPermissoes) values (1, 16);
insert into PerfilPermissoes (idPerfil, idPermissoes) values (1, 17);
insert into PerfilPermissoes (idPerfil, idPermissoes) values (2, 1);
