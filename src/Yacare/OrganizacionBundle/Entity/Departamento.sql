/* Importar secretarías y departamentos que no existen y actualizar los que ya existen */

INSERT INTO yacare.Organizacion_Departamento
    (Nombre, Rango, DependeDe_id, Eliminado, ImportSrc, ImportId, ImportedAt)
    SELECT yacare.tcase(detalle), 30, 1, 0, 'rr_hh.secretarias', codigo, NOW() FROM rr_hh.secretarias
	ON DUPLICATE KEY UPDATE Nombre=VALUES(Nombre)
;

INSERT INTO yacare.Organizacion_Departamento
    (Nombre, Rango, DependeDe_id, Eliminado, ImportSrc, ImportId, ImportedAt)
    SELECT yacare.tcase(detalle), 50, (SELECT id FROM yacare.Organizacion_Departamento WHERE ImportSrc='rr_hh.secretarias' AND ImportId=rr_hh.direcciones.secretaria), 0, 'rr_hh.direcciones', CONCAT(secretaria, '.', direccion), NOW() FROM rr_hh.direcciones
	ON DUPLICATE KEY UPDATE Nombre=VALUES(Nombre)
;

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
