/* Importar los agentes */

INSERT INTO yacare.Base_Persona
    (Apellido, Nombre, NombreVisible, 
		DomicilioCalle, FechaNacimiento, DocumentoTipo, DocumentoNumero, Genero, TelefonoNumero, Email, Salt,
		ImportSrc, ImportId, ImportedAt, CreatedAt, UpdatedAt, Version)
    SELECT yacare.tcase(TRIM(SUBSTRING_INDEX(nombre, ' ', 1))), yacare.tcase(TRIM(TRIM(LEADING TRIM(SUBSTRING_INDEX(nombre, ' ', 1)) FROM nombre))), yacare.tcase(nombre),
		yacare.tcase(domicilio), fechanacim, tipodoc, nrodoc, sexo, telefono, email, MD5(RAND()),
		'rr_hh.agentes', legajo, NOW(), NOW(), NOW(), 1 FROM rr_hh.agentes
	ON DUPLICATE KEY UPDATE 
		Apellido=VALUES(Apellido), Nombre=VALUES(Nombre), NombreVisible=VALUES(NombreVisible),
		DomicilioCalle=VALUES(DomicilioCalle), FechaNacimiento=VALUES(FechaNacimiento), DocumentoNumero=VALUES(DocumentoNumero),
		TelefonoNumero=VALUES(TelefonoNumero), Email=VALUES(Email)
;

UPDATE Base_Persona SET salt=MD5(RAND()) WHERE salt='';

UPDATE yacare.Base_Persona SET
    Apellido=REPLACE(Apellido, ',', ''), NombreVisible=REPLACE(NombreVisible, ',,', ',');

INSERT INTO yacare.Rrhh_Agente
    (id, Persona_id, Categoria,
        Situacion, Funcion, FechaIngreso, Departamento_id,
        ImportSrc, ImportId, ImportedAt, CreatedAt, UpdatedAt, Version)
    SELECT legajo, (SELECT id FROM Base_Persona WHERE ImportSrc='rr_hh.agentes' AND ImportId=legajo), categoria,
        situacion, yacare.tcase(funcion), fechaingre, (SELECT id FROM Organizacion_Departamento WHERE ImportSrc='rr_hh.direcciones' AND ImportId=CONCAT(secretaria, '.', direccion)),
        'rr_hh.agentes', legajo, NOW(), NOW(), NOW(), 1 FROM rr_hh.agentes
	ON DUPLICATE KEY UPDATE
        Categoria=VALUES(Categoria), Situacion=VALUES(Situacion), Funcion=VALUES(Funcion), FechaIngreso=VALUES(FechaIngreso),
        Departamento_id=VALUES(Departamento_id)
;


INSERT IGNORE INTO yacare.Base_Persona_PersonaGrupo (persona_id, personagrupo_id)
	SELECT id, 1 FROM yacare.Base_Persona WHERE ImportSrc='rr_hh.agentes';


/* Triggers */

/* Llevar direcciones y secretarías actualizaciones */

DROP TRIGGER IF EXISTS yacare.Organizacion_Departamento_AU;
DROP TRIGGER IF EXISTS yacare.Organizacion_Departamento_AI;
DROP TRIGGER IF EXISTS yacare.Organizacion_Departamento_BI;
DROP TRIGGER IF EXISTS rr_hh.secretarias_AU;
DROP TRIGGER IF EXISTS rr_hh.secretarias_AI;
DROP TRIGGER IF EXISTS rr_hh.direcciones_AU;
DROP TRIGGER IF EXISTS rr_hh.direcciones_AI;

delimiter //
CREATE TRIGGER yacare.Organizacion_Departamento_AU AFTER UPDATE ON yacare.Organizacion_Departamento
FOR EACH ROW
BEGIN
    IF @DISABLE_TRIGGER_CHECKS <> 33 THEN
        SET @DISABLE_TRIGGER_CHECKS = 33;

        IF NEW.ImportSrc='rr_hh.secretarias' THEN
            UPDATE rr_hh.secretarias SET detalle=NEW.Nombre WHERE codigo=NEW.ImportId;
        ELSEIF NEW.ImportSrc='rr_hh.direcciones' THEN
            SET @SecId = SUBSTRING_INDEX(NEW.ImportId, '.', 1);
            SET @DirId = SUBSTRING_INDEX(NEW.ImportId, '.', -1);
            UPDATE rr_hh.direcciones SET detalle=NEW.Nombre WHERE secretaria=@SecId AND direccion=@DirId;
        END IF;

        SET @DISABLE_TRIGGER_CHECKS = 0;
    END IF;
END;//
delimiter ;

/* Llevar direcciones y secretarías nuevas */

delimiter //
CREATE TRIGGER yacare.Organizacion_Departamento_BI BEFORE INSERT ON yacare.Organizacion_Departamento
FOR EACH ROW
BEGIN
    IF @DISABLE_TRIGGER_CHECKS <> 33 THEN
        SET @DISABLE_TRIGGER_CHECKS = 33;

        IF NEW.Rango = 30 THEN
            SET @SecId = (SELECT MAX(codigo)+1 FROM rr_hh.secretarias);
            INSERT INTO rr_hh.secretarias (codigo, detalle) VALUES (@SecId, NEW.Nombre);
            SET NEW.ImportSrc='rr_hh.secretarias';
            SET NEW.ImportedAt=NOW();
            SET NEW.ImportId=@SecId;
        ELSEIF NEW.Rango = 50 THEN
            SET @SecId = (SELECT ImportId FROM yacare.Organizacion_Departamento WHERE id=NEW.DependeDe_id);
            SET @DirId = (SELECT MAX(direccion)+1 FROM rr_hh.direcciones WHERE secretaria=@SecId);
            IF @DirId IS NULL THEN
                SET @DirId = 1;
            END IF;
            INSERT INTO rr_hh.direcciones (secretaria, direccion, detalle) VALUES (@SecId, @DirId, NEW.Nombre);
            SET NEW.ImportSrc='rr_hh.direcciones';
            SET NEW.ImportedAt=NOW();
            SET NEW.ImportId=CONCAT(@SecId, '.', @SecId);
        END IF;

        SET @DISABLE_TRIGGER_CHECKS = 0;
    END IF;
END;//
delimiter ;

