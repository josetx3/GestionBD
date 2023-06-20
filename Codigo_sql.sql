--Tabla Titulo de Empleado

CREATE TABLE public.employees_title(
Emti_Id SERIAL, -- Id de la tabla
Emti_Name VARCHAR(50),--nombre del cargo
Emti_Description VARCHAR(200), --descripcion del cargo
CONSTRAINT nn_Emti_Name CHECK (Emti_Name IS NOT NULL), 
CONSTRAINT uc_Emti_Name UNIQUE (Emti_Name),
CONSTRAINT nn_Emti_Description CHECK (Emti_Description IS NOT NULL),
CONSTRAINT pk_employees_title PRIMARY KEY (Emti_Id)
);

SELECT * FROM public.employees_title;

INSERT INTO public.employees_title(emti_id, emti_name, emti_description)
VALUES (default, 'ADMINISTRADOR', 'ENCARGADO DE LA ORGANIZACIÓN, DIRECCIÓN Y CONTROL DE LA EMPRESA');
INSERT INTO public.employees_title(emti_id, emti_name, emti_description)
VALUES (default, 'GERENTE', 'ENCARGADO DEL NEGOCIO');
INSERT INTO public.employees_title(emti_id, emti_name, emti_description)
VALUES (default, 'BODEGUERO', 'ENCARGADO DE LA PARTE DEL INVENTARIO');
INSERT INTO public.employees_title(emti_id, emti_name, emti_description)
VALUES (default, 'VENDEDOR', 'NO HACE NADA');



--Tabla Usuario

CREATE TABLE public.access(
Acce_Document VARCHAR(20),
Acce_Name1 VARCHAR(30),--nombres
Acce_Name2 VARCHAR(30),
Acce_Lastname1 VARCHAR(30),--apellidos
Acce_Lastname2 VARCHAR(30),
Acce_Address VARCHAR(50),--direccion
Acce_Sex CHAR(1),--sexo
Acce_Telephone_Number VARCHAR(20),--numero de telefono
Acce_Email VARCHAR(30),
Acce_Password VARCHAR(250),
Acce_State CHAR(2),--estado del empleado 
Emti_Id INTEGER, --llave foranea de la tabla de cargo de empleado
CONSTRAINT ck_Acce_Sex CHECK (Acce_Sex IN ('M','F','I')),
CONSTRAINT nn_Acce_Sex CHECK (Acce_Sex IS NOT NULL),
CONSTRAINT nn_Acce_Document CHECK (Acce_Document IS NOT NULL),
CONSTRAINT nn_Acce_Name1 CHECK (Acce_Name1 IS NOT NULL),
CONSTRAINT nn_Acce_Lastname1 CHECK (Acce_Lastname1 IS NOT NULL),
CONSTRAINT nn_Acce_Telephone_Number CHECK (Acce_Telephone_Number IS NOT NULL),
CONSTRAINT nn_Acce_Email CHECK (Acce_Email IS NOT NULL),
CONSTRAINT nn_Acce_Password CHECK (Acce_Password IS NOT NULL),
CONSTRAINT nn_Acce_State CHECK (Acce_State IS NOT NULL),
CONSTRAINT fk_employees_title_access FOREIGN KEY (Emti_Id) 
REFERENCES public.employees_title (Emti_Id),
CONSTRAINT pk_access PRIMARY KEY (Acce_Document)
);

SELECT * FROM public.access;

INSERT INTO public.access(acce_document, acce_name1, acce_name2, acce_lastname1, 
acce_lastname2, acce_address, acce_sex, acce_telephone_number, acce_email, acce_password,
acce_state, emti_id)
VALUES ('1004945023', 'JOSE', 'LEONARDO', 'QUINTERO', 'LEON', 'CRA 16 # 6A - 63', 'M', '3183843124', 
		'jose@gmail.com', 'jose123','EA' ,1),
		('1193223063', 'ANDRES', 'FELIPE', 'GUAGLIANONI', '', 'CALLE 1 # 4-32', 'M', '3167863081', 
		'felipe@gmail.com', 'ADMIN123','EA',2),
		('1193223062', 'JHON', 'DEIVY', 'RIVAS', 'OJEDA', 'CALLE 7 # 40-58', 'M', '3167863081', 
		'rivas@gmail.com', 'rivas123', 'EA' ,3),
		('1004892245', 'FERNANDO', 'JAVIER', 'ARENAZ', '', 'CALLE 2 # 54-21', 'M', '3145272741', 
		'fernando@gmail.com', 'fernando123','EA',4);


--Tabla Auditoria_Usuario

CREATE TABLE public.audi_access(
	audi_Acce_Document VARCHAR(20),
	audi_Acce_Name1 VARCHAR(30),--nombres
	audi_Acce_Name2 VARCHAR(30),
	audi_Acce_Lastname1 VARCHAR(30),--apellidos
	audi_Acce_Lastname2 VARCHAR(30),
	audi_Acce_Address VARCHAR(50),--direccion
	audi_Acce_Sex CHAR(1),--sexo
	audi_Acce_Telephone_Number VARCHAR(20),--numero de telefono
	audi_Acce_Email VARCHAR(30),
	audi_Acce_Password VARCHAR(250),
	audi_Acce_State CHAR(2),--estado del empleado 
	audi_Emti_Id INTEGER, --llave foranea de la tabla de cargo de empleado
	audi_modification_date TIMESTAMP,
	audi_Acce_user VARCHAR(45),
	audi_Acce_accion char(1),
	CONSTRAINT ck_audi_Acce_Sex CHECK (audi_Acce_Sex IN ('M','F','I')),
	CONSTRAINT fk_audi_employees_title_access FOREIGN KEY (audi_Emti_Id) 
	REFERENCES public.employees_title (Emti_Id)
);	

-- FUNCION PARA LA AUDITORIA USUARIO
CREATE FUNCTION PUBLIC.AUDI_ACCESS_FUNC() RETURNS TRIGGER AS $TRG_GRABAR_AUDI_ACCESS$
DECLARE
	BEGIN
		IF (TG_OP = 'UPDATE') THEN
			INSERT INTO PUBLIC.audi_access (audi_Acce_Document,audi_Acce_Name1,audi_Acce_Name2,audi_Acce_Lastname1,audi_Acce_Lastname2,audi_Acce_Address,audi_Acce_Sex,audi_Acce_Telephone_Number,audi_Acce_Email,audi_Acce_Password,audi_Acce_State,audi_Emti_Id,audi_modification_date,audi_Acce_user,audi_Acce_accion)
			VALUES (OLD.Acce_Document,OLD.Acce_Name1,OLD.acce_name2,OLD.Acce_Lastname1,OLD.Acce_Lastname2,OLD.Acce_Address,OLD.Acce_Sex,OLD.Acce_Telephone_Number,OLD.Acce_Email,OLD.Acce_Password,OLD.Acce_State,OLD.Emti_Id,CURRENT_TIMESTAMP(0),CURRENT_USER,'U');
			RETURN NEW;
		ELSIF(TG_OP = 'DELETE') THEN
			INSERT INTO PUBLIC.audi_access (audi_Acce_Document,audi_Acce_Name1,audi_Acce_Name2,audi_Acce_Lastname1,audi_Acce_Lastname2,audi_Acce_Address,audi_Acce_Sex,audi_Acce_Telephone_Number,audi_Acce_Email,audi_Acce_Password,audi_Acce_State,audi_Emti_Id,audi_modification_date,audi_Acce_user,audi_Acce_accion)
			VALUES (OLD.Acce_Document,OLD.Acce_Name1,OLD.acce_name2,OLD.Acce_Lastname1,OLD.Acce_Lastname2,OLD.Acce_Address,OLD.Acce_Sex,OLD.Acce_Telephone_Number,OLD.Acce_Email,OLD.Acce_Password,OLD.Acce_State,OLD.Emti_Id,CURRENT_TIMESTAMP(0),CURRENT_USER,'D');
			RETURN OLD;
		END IF;
	END;
$TRG_GRABAR_AUDI_ACCESS$ LANGUAGE PLPGSQL;		

CREATE TRIGGER TRG_GRABAR_AUDI_ACCESS BEFORE UPDATE OR DELETE ON PUBLIC.access
	FOR EACH ROW EXECUTE PROCEDURE PUBLIC.AUDI_ACCESS_FUNC();

		
--Tabla Producto

CREATE TABLE public.produc(
	Prod_reference INT,
	Prod_Code_Plu VARCHAR(30),--Codigo plu
	Prod_Description VARCHAR(200),--descripcion del producto
	Prod_Available_Quantity INT,--cantidad disponible
	Prod_Arrival_Price DECIMAL,--precio de llegada
	Prod_Selling_Price DECIMAL,--precio de venta
	prod_iva DECIMAL,-- precio del iva
	CONSTRAINT nn_prod_reference CHECK (Prod_reference IS NOT NULL),
	CONSTRAINT nn_Prod_Code_Plu CHECK (Prod_Code_Plu IS NOT NULL),
	CONSTRAINT nn_Prod_Description CHECK (Prod_Description IS NOT NULL),
	CONSTRAINT nn_Prod_Arrival_Price CHECK (Prod_Arrival_Price IS NOT NULL),
	CONSTRAINT nn_Prod_Selling_Price CHECK (Prod_Selling_Price IS NOT NULL),
	CONSTRAINT nn_Prod_iva CHECK (Prod_iva IS NOT NULL),
	CONSTRAINT pk_produc PRIMARY KEY (Prod_reference,Prod_Code_Plu)
);

select * from public.produc;

INSERT INTO public.produc (Prod_reference, prod_code_plu, prod_description,
prod_available_quantity, prod_arrival_price, prod_selling_price, prod_iva)
VALUES 	('2452','P01','POPETAS CARAMELO',7,2500,3000,1.19),
		('2453','PO2','POPETAS MANTEQUILLA',10,2500,3500,1.19),
		('2454','PO3','POPETAS BBQ',10,2500,3500,1.19),
		('2455','PO4','POPETAS MIXTAS',10,2500,3500,1.19),
		('2456','PO5','POPETAS BBQ FAMILIAR',10,3500,4500,1.19),
		('2457','PO6','POPETAS CARAMELO FAMILIAR',10,3500,4500,1.19),
		('2458','PO7','POPETAS MIXTAS FAMILIAR',10,3500,4500,1.19),
		('2459','PO8','POPETAS MANTEQUILLA FAMILIAR',10,3500,4500,1.19)
	;

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

CREATE TABLE public.cliente(
	cliente_documento VARCHAR(20),
	cliente_nombre VARCHAR(80),
	cliente_correo VARCHAR(30),
	cliente_sexo CHAR(1),
	cliente_telefono VARCHAR(20),
	cliente_direccion VARCHAR(40),
	cliente_barrio VARCHAR(30),
	cliente_nombre_negocio VARCHAR(50),
	cliente_nit_negocio VARCHAR(30),
	cliente_estado CHAR(2),
	CONSTRAINT nn_cliente_documento CHECK (cliente_documento IS NOT NULL),
	CONSTRAINT nn_cliente_nombre CHECK (cliente_nombre IS NOT NULL),
	CONSTRAINT nn_cliente_correo CHECK (cliente_correo IS NOT NULL),
	CONSTRAINT nn_cliente_sexo CHECK (cliente_sexo IS NOT NULL),
	CONSTRAINT nn_cliente_telefono CHECK (cliente_telefono IS NOT NULL),
	CONSTRAINT nn_cliente_direccion CHECK (cliente_direccion IS NOT NULL),
	CONSTRAINT nn_cliente_barrio CHECK (cliente_barrio IS NOT NULL),
	CONSTRAINT nn_cliente_nombre_negocio CHECK (cliente_nombre_negocio IS NOT NULL),
	CONSTRAINT nn_cliente_nit_negocio CHECK (cliente_nit_negocio IS NOT NULL),
	CONSTRAINT nn_cliente_estado CHECK (cliente_estado IS NOT NULL),
	CONSTRAINT ck_cliente_sexo CHECK (cliente_sexo IN ('M','F','I')),
	CONSTRAINT ck_cliente_estado CHECK (cliente_estado IN ('EA','ED')),
	CONSTRAINT pk_cliente PRIMARY KEY(cliente_documento)
);

INSERT INTO public.cliente(cliente_documento,cliente_nombre,cliente_correo,cliente_sexo,cliente_telefono,cliente_direccion,cliente_barrio,cliente_nombre_negocio,cliente_nit_negocio,cliente_estado) 
					VALUES	('165','JUAN SEBASTIAN ANGARITA','jsangarita@gmail.com','M','314758808','cra 16 # 6a - 63','el llano','Tienda la estrella','128756','EA'),
							('1004563451','DIEGO ARMANDO','diegoarmando@gmail.com','M','3124576123','cra 13 # 4A-54','el landia','Tienda la pepita','5426234','EA'),
							('1004899200','DIANY ISABEL GARCIA','dgarciac@gmail.com','F','31678921450','kda 32 $ 65 - 5B','el dorado','Tienda la esquina','2365234','EA')
							;


--tabla detalle pedido
CREATE TABLE public.order_detail(
	orde_code_order SERIAL, --codigo del pedido
	orde_route_name VARCHAR(50), --nombre de la ruta
	orde_customer_name VARCHAR(80), --nombre del cliente
	orde_produc_description VARCHAR(200), --descripcion del producto
	orde_quantity INT, --cantidad del producto a solicitar 
	orde_date DATE, --fecha
	orde_selling_price DECIMAL, --precio de venta
	orde_total_price DECIMAL, --precio total
	orde_state CHAR(2), --estado del pedido
	prod_reference INT, --llave foranea de la tabla producto
	prod_code_plu VARCHAR(30), --llave foranea de la tabla producto
	acce_document VARCHAR(20), --llave foranea de la tabla acceso
	cliente_documento VARCHAR(20), --llave foranea de la tabla cliente 
	CONSTRAINT nn_orde_code_order CHECK (orde_code_order IS NOT NULL),
	CONSTRAINT nn_orde_route_name CHECK (orde_route_name IS NOT NULL),
	CONSTRAINT nn_orde_customer_name CHECK (orde_customer_name IS NOT NULL),
	CONSTRAINT nn_orde_produc_description CHECK (orde_produc_description IS NOT NULL),
	CONSTRAINT nn_orde_quantity CHECK (orde_quantity IS NOT NULL),
	CONSTRAINT nn_orde_date CHECK (orde_date IS NOT NULL),
	CONSTRAINT nn_orde_selling_price CHECK (orde_selling_price IS NOT NULL),
	CONSTRAINT nn_orde_total_price CHECK (orde_total_price IS NOT NULL),
	CONSTRAINT nn_orde_state CHECK (orde_state IS NOT NULL),
	CONSTRAINT ck_orde_quantity CHECK (orde_quantity > 0),
	CONSTRAINT ck_orde_state CHECK (orde_state IN ('EA','ED')),
	CONSTRAINT fk_produc_order_detail FOREIGN KEY (prod_reference,prod_code_plu) 
	REFERENCES public.produc (prod_reference,prod_code_plu),
	CONSTRAINT fk_access_order_detail FOREIGN KEY (acce_document) 
	REFERENCES public.access (acce_document),
	CONSTRAINT fk_customer_order_detail FOREIGN KEY (cliente_documento) 
	REFERENCES public.cliente (cliente_documento),
	CONSTRAINT pk_order_detail PRIMARY KEY (orde_code_order)
);

select * from public.order_detail;









CREATE TABLE FACTURA(
	COD_FACTURA SERIAL,
	FECHA_FACTURA DATE NOT NULL,
	TOTAL_FACTURA DECIMAL,
	cliente_documento VARCHAR(20),
	CONSTRAINT PK_COD_FACTURA PRIMARY KEY(COD_FACTURA),
	CONSTRAINT FK_CLIENTE_VENTA FOREIGN KEY (cliente_documento) REFERENCES cliente (cliente_documento)

);

------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

CREATE TABLE DETALLE(
	ORDINAL VARCHAR(3),
	CANT_DETALLE INTEGER NOT NULL,
	PRECIO_VENTA DECIMAL,
	SUBTOTAL DECIMAL,
	FECHA_DETALLE TIMESTAMP NOT NULL,
	prod_reference INTEGER,
	Prod_Code_Plu VARCHAR(10),
	COD_FACTURA INTEGER,
	CONSTRAINT FK_COD_PRODUCTO FOREIGN KEY (prod_reference,Prod_Code_Plu) REFERENCES produc (prod_reference,Prod_Code_Plu), 
	CONSTRAINT FK_COD_FACTURA FOREIGN KEY (COD_FACTURA) REFERENCES FACTURA(COD_FACTURA)ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT PK_COD_DETALLE PRIMARY KEY (COD_FACTURA, ORDINAL)

);




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

--------------------------------------------------------------------------------------------------------------------------------



CREATE FUNCTION SUB_TOTAL() RETURNS TRIGGER AS $SUB_TOTAL$
DECLARE
	P NUMERIC;
	SU NUMERIC;
	BEGIN 
		IF NEW.CANT_DETALLE IS NULL THEN
			RAISE EXCEPTION '%LA CANTIDAD NO PUEDE SER NULA', NEW.COD_PRODUCTO;
		END IF;
			SELECT prod_selling_price INTO P FROM produc WHERE cod_producto = NEW.cod_producto;
			SU = P*NEW.CANT_DETALLE;
			NEW.prod_selling_price := P;
			NEW.SUBTOTAL = SU;
			RETURN NEW;
	END
$SUB_TOTAL$ LANGUAGE plpgsql;

CREATE TRIGGER SUB_TOTAL BEFORE INSERT OR UPDATE ON DETALLE
FOR EACH ROW EXECUTE PROCEDURE SUB_TOTAL();




















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

--------------------------------------------------------------------------------------------------------------------------------



CREATE FUNCTION SUB_TOTAL() RETURNS TRIGGER AS $SUB_TOTAL$
DECLARE
	P NUMERIC;
	SU NUMERIC;
	BEGIN 
		IF NEW.CANT_DETALLE IS NULL THEN
			RAISE EXCEPTION '%LA CANTIDAD NO PUEDE SER NULA', NEW.COD_PRODUCTO;
		END IF;
			SELECT PRECIO INTO P FROM producto_terminado WHERE cod_producto = NEW.cod_producto;
			SU = P*NEW.CANT_DETALLE;
			NEW.SUBTOTAL = SU;
			RETURN NEW;
	END
$SUB_TOTAL$ LANGUAGE plpgsql;

CREATE TRIGGER SUB_TOTAL BEFORE INSERT OR UPDATE ON DETALLE
FOR EACH ROW EXECUTE PROCEDURE SUB_TOTAL();
















--tabla factura pedido
CREATE TABLE public.invoice(
	invo_consecutivo SERIAL, --codigo de la factura 
	invo_date DATE, --fecha
	invo_total DECIMAL, --precio total a pagar
	acce_document VARCHAR(20), --llave foranea de acceso del empleado
	cliente_documento VARCHAR(20), --llave foranea de la tabla cliente 
	CONSTRAINT nn_invo_date CHECK (invo_date IS NOT NULL),
	CONSTRAINT fk_access_acce_document FOREIGN KEY (acce_document) 
	REFERENCES public.access (acce_document),
	CONSTRAINT fk_invoice_cliente FOREIGN KEY (cliente_documento) 
	REFERENCES public.customer (cliente_documento),
	CONSTRAINT pk_invo_consecutivo PRIMARY KEY (invo_consecutivo)
);


