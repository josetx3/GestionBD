//! ------------------------------CONEXION----------------------------- !\\
mongodb+srv://leon:leon@leondistribuciones.spok4zo.mongodb.net/?retryWrites=true&w=majority
//! ------------------------------CONEXION----------------------------- !\\

//!  CREAMOS LAS COLECCIONES DE EMPLOYEES_TITLE | CLIENT !\\
use leon
db.createcollection("employees_title");
db.createcollection("client");

//? HACEMOS UN INSERT EN EMPLOYEES_TITLE    ?\\
db.employees_title.insertMany([
  {
    emti_name: "Administrador",
    emti_description: "Administra",
    acces: {
      acce_document: "1004945023",
      acce_name1: "Jose",
      acce_name2: "Leonardo",
      acce_lastname1: "Quintero",
      acce_lastname2: "Leon",
      acce_address: "cra 16 # 6a - 63",
      acce_sex: "Masculino",
      acce_telephone_number: "3183843124",
      acce_email: "jose@gmail.com",
      acce_password: "jose123",
      acce_state: "Activo"
    }
  },
  {
    emti_name: "Administrador",
    emti_description: "Administra el software",
    acces: {
      acce_document: "1004899200",
      acce_name1: "Diany",
      acce_name2: "Isabel",
      acce_lastname1: "Garcia",
      acce_lastname2: "Carrascal",
      acce_address: "cra 19 # 14 - 21",
      acce_sex: "Femenino",
      acce_telephone_number: "3183843124",
      acce_email: "diany@gmail.com",
      acce_password: "diany123",
      acce_state: "Activo"
    }
  },
]);


//? HACEMOS UN INSERT PARA CLIENT
db.client.insertOne(
  {
    client_document: "1004945022",
    client_name: "Diego",
    client_email: "diego@gmail.com",
    client_sex: "Masculino",
    client_telephone: "3183843125",
    client_address: "Cra 15 # 12 - 4F",
    client_neighborhood: "El llano",
    client_name_business: "Tienda el llano",
    client_nit_business: "12abc456",
    client_satus: "AU",
    invoice: {
      cod_invoice: "123456",
      date_invoice: "2023-11-10",
      total_invoice: 5000,
      status: "Pagada"
    },
    details:{
      ordinal:"123abc",
      cant_detalle: 5,
      precio_venta: 10000,
      subtotal:8000,
      fecha_detalle:"2023-06-12",
    }
  }
);


//? INSERTAR UN PRODUCTO
db.product.insertOne(
  {
    prod_reference: "12345abcd",
    prod_code_plu: "P001",
    prod_description: "Popetas de caramelo",
    prod_available_quantity: 100,
    prod_arrival_price: 2500,
    value:3000,
    prod_iva: 1500
  }
);

db.product.insertOne(
  {
    prod_reference: "12345abcd",
    prod_code_plu: "P002",
    prod_description: "Popetas de mantequilla",
    prod_available_quantity: 60,
    prod_arrival_price: 2000,
    value:2500,
    prod_iva: 1500
  }
);