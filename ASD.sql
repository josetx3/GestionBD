----------------------------------------------------------------------------------------

INSERT INTO public.factura(
	cod_factura, fecha_factura, cliente_documento)
	VALUES (DEFAULT, '03/05/2001', '1004945023');
	
select * from factura;

----------------------------------------------------------------------------------------

INSERT INTO public.detalle(
	ordinal, cant_detalle, fecha_detalle, prod_reference, prod_code_plu, cod_factura)
	VALUES ('03', 10, '03/02/2002', 2454, 'PO3', '1');
	
	
	
select * from factura order by cod_factura;

select * from detalle;

select * from produc;

----------------------------------------------------------------------------------------

CREATE FUNCTION LLENAR_TOTAL() RETURNS TRIGGER AS $LLENAR_TOTAL$
DECLARE 
	SB NUMERIC;
	BEGIN 
		SELECT SUM(SUBTOTAL) INTO SB FROM DETALLE WHERE cod_factura = new.cod_factura;
		UPDATE factura SET TOTAL_FACTURA = SB WHERE cod_factura = new.cod_factura;
		RETURN NEW;
	END;
$LLENAR_TOTAL$ LANGUAGE plpgsql;


CREATE TRIGGER LLENAR_TOTAL AFTER INSERT OR UPDATE ON DETALLE
FOR EACH ROW EXECUTE PROCEDURE LLENAR_TOTAL();

----------------------------------------------------------------------------------------



CREATE FUNCTION SUB_TOTAL() RETURNS TRIGGER AS $SUB_TOTAL$
DECLARE
	P NUMERIC;
	SU NUMERIC;
	BEGIN 
		IF NEW.CANT_DETALLE IS NULL THEN
			RAISE EXCEPTION '%LA CANTIDAD NO PUEDE SER NULA', NEW.COD_PRODUCTO;
		END IF;
			SELECT valor INTO P FROM produc WHERE prod_reference = NEW.prod_reference AND prod_code_plu = new.prod_code_plu;
			SU = P*NEW.CANT_DETALLE;
			NEW.precio_venta := P;
			NEW.SUBTOTAL = SU;
			RETURN NEW;
	END
$SUB_TOTAL$ LANGUAGE plpgsql;

CREATE TRIGGER SUB_TOTAL BEFORE INSERT OR UPDATE ON DETALLE
FOR EACH ROW EXECUTE PROCEDURE SUB_TOTAL();

----------------------------------------------------------------------------------------

--Tabla audi_Producto
CREATE TABLE public.audi_produc(
	audi_Prod_reference INT,
	audi_Prod_Code_Plu VARCHAR(30),--Codigo plu
	audi_Prod_Description VARCHAR(200),--descripcion del producto
	audi_Prod_Available_Quantity INT,--cantidad disponible
	audi_Prod_Arrival_Price DECIMAL,--precio de llegada
	audi_valor DECIMAL,--precio de venta
	audi_prod_iva DECIMAL,-- precio del iva
	audi_modification_date TIMESTAMP,
	audi_prod_user VARCHAR(45),
	audi_prod_accion char(1)
);

-- FUNCION PARA LA AUDITORIA USUARIO
CREATE FUNCTION PUBLIC.AUDI_PRODUC_FUNC() RETURNS TRIGGER AS $TRG_GRABAR_AUDI_PRODUC$
DECLARE
	BEGIN
		IF (TG_OP = 'UPDATE') THEN
			INSERT INTO PUBLIC.audi_produc (audi_Prod_reference,audi_Prod_Code_Plu,audi_Prod_Description,audi_Prod_Available_Quantity,audi_Prod_Arrival_Price,audi_valor,audi_prod_iva,audi_modification_date,audi_prod_user,audi_prod_accion)
			VALUES (OLD.Prod_reference,OLD.Prod_Code_Plu,OLD.Prod_Description,OLD.Prod_Available_Quantity,OLD.Prod_Arrival_Price,OLD.valor,OLD.prod_iva,CURRENT_TIMESTAMP(0),CURRENT_USER,'U');
			RETURN NEW;
		ELSIF(TG_OP = 'DELETE') THEN
			INSERT INTO PUBLIC.audi_produc (audi_Prod_reference,audi_Prod_Code_Plu,audi_Prod_Description,audi_Prod_Available_Quantity,audi_Prod_Arrival_Price,audi_valor,audi_prod_iva,audi_modification_date,audi_prod_user,audi_prod_accion)
			VALUES (OLD.Prod_reference,OLD.Prod_Code_Plu,OLD.Prod_Description,OLD.Prod_Available_Quantity,OLD.Prod_Arrival_Price,OLD.valor,OLD.prod_iva,CURRENT_TIMESTAMP(0),CURRENT_USER,'D');
			RETURN OLD;
		END IF;
	END;
$TRG_GRABAR_AUDI_PRODUC$ LANGUAGE PLPGSQL;		

CREATE TRIGGER TRG_GRABAR_AUDI_PRODUC BEFORE UPDATE OR DELETE ON PUBLIC.produc
	FOR EACH ROW EXECUTE PROCEDURE PUBLIC.AUDI_PRODUC_FUNC();