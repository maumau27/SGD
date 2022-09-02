/*UPDATE DisciplinaPreReq
SET idDisciplina = (
SELECT id
FROM Disciplina
WHERE Disciplina.Codigo = DisciplinaPreReq.codigoDisciplina);

UPDATE CurriculoDisciplina
SET idDisciplina = (
SELECT id
FROM Disciplina
WHERE Disciplina.Codigo = CurriculoDisciplina.codigoDisciplina);*/

#atualiza idDisciplina em DisciplinaPreReq, requer safe_update = 0
UPDATE DisciplinaPreReq
JOIN Disciplina ON DisciplinaPreReq.codigoDisciplina = Disciplina.Codigo
SET DisciplinaPreReq.idDisciplina = Disciplina.id;

#atualiza idDisciplina em CurriculoDisciplina, requer safe_update = 0
UPDATE CurriculoDisciplina
JOIN Disciplina ON CurriculoDisciplina.codigoDisciplina = Disciplina.Codigo
SET CurriculoDisciplina.idDisciplina = Disciplina.id;

#atualiza idDisciplina em DisciplinaOptativa, requer safe_update = 0
UPDATE DisciplinaOptativa
JOIN Disciplina ON DisciplinaOptativa.codigoDisciplina = Disciplina.Codigo
SET DisciplinaOptativa.idDisciplinaGrupo = Disciplina.id;

#atualiza lista de codigos de PreReq
UPDATE prereq
SET ListaCodigos = (
SELECT GROUP_CONCAT(codigoDisciplina)
FROM disciplinaprereq
WHERE prereq.id = disciplinaprereq.idPreReq);

#Atualiza numero de creditos em disciplinas optativas
update disciplina as discOpt join disciplinaoptativa on discOpt.id = idDisciplinaOptativa
join disciplina as discGrupo on discGrupo.id = idDisciplinaGrupo
set discOpt.creditos = discGrupo.creditos;

SET SQL_SAFE_UPDATES = 1;