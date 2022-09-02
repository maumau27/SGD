CREATE TRIGGER DisciplinaPreReq_before_insert 
BEFORE INSERT ON DisciplinaPreReq 
FOR EACH ROW 
SET new.idDisciplina := (select id from Disciplina where codigo=new.codigoDisciplina);

CREATE TRIGGER CurriculoDisciplina_before_insert 
BEFORE INSERT ON CurriculoDisciplina 
FOR EACH ROW 
SET new.idDisciplina := (select id from Disciplina where codigo=new.codigoDisciplina);