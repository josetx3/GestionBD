class InvoiceJs {

    consultClientInvoice() {
        ordinal = 0;
        array_pagado = [];
        array_cantidad = [];
        var boton_factura = document.getElementById("boton_factura");
        var cl_nombre = document.querySelector('#cliente_nombre');
        var cl_documento = document.querySelector('#cliente_documento');
        var cl_nit_negocio = document.querySelector('#cliente_nit_negocio');
        var cl_nombre_negocio = document.querySelector('#cliente_nombre_negocio');
        var documento = document.getElementById("consult_client_invoice").value;
        var object = new FormData();
        object.append("documento", documento);
        fetch("InvoiceController/consultClientInvoice", {
            method: "POST",
            body: object,
        })
            .then((respuesta) => respuesta.text())
            .then(function (response) {
                //alert(response);
                if (response != "NO SE ENCUENTRA REGISTRADO O ESTAN MAL LOS VALORES") {
                    try {
                        object = JSON.parse(response);
                        var cliente_nombre = "";
                        var cliente_documento = "";
                        var cliente_nit_negocio = "";
                        var cliente_nombre_negocio = "";
                        object.forEach(cliente => {
                            cliente_nombre = '<input type="text" class="form-control" value= "' + cliente.cliente_nombre + '" required readOnly>'
                            cliente_documento = '<input type="text" class="form-control" value= "' + cliente.cliente_documento + '" required readOnly>'
                            cliente_nit_negocio = '<input type="text" class="form-control" value= "' + cliente.cliente_nit_negocio + '" required readOnly>'
                            cliente_nombre_negocio = '<input type="text" class="form-control" value= "' + cliente.cliente_nombre_negocio + '" required readOnly>'
                        });
                        cl_nombre.innerHTML = cliente_nombre;
                        cl_documento.innerHTML = cliente_documento;
                        cl_nit_negocio.innerHTML = cliente_nit_negocio;
                        cl_nombre_negocio.innerHTML = cliente_nombre_negocio;
                        console.log(cliente_nombre + " |-|-|-| " + cliente_documento + " |-|-|-| " + cliente_nit_negocio + " |-|-|-| " + cliente_nombre_negocio);
                        boton_factura.disabled = false;
                    } catch (error) {
                        //document.querySelector("#content").innerHTML = response;
                        Swal.fire({
                            icon: "error",
                            title: "ERROR CAMPOS",
                            text: object.message,
                        });
                    }
                } else {

                }
            })
            .catch(function (error) {
                console.log(error);
            });

    }

    aggDetalle() {
        ordinal = ordinal + 1;
        var cantidad = document.getElementById("cantidad").value;
        var cod_producto = document.getElementById("cod_producto").value;
        var boton_detalle_pagar = document.getElementById("boton_detalle_pagar");
        var boton_detalle_cancelar = document.getElementById("boton_detalle_cancelar");
        //alert(cantidad);
        //alert(cod_producto);
        var object = new FormData();
        var tabla = "";
        object.append("cantidad", cantidad);
        object.append("cod_producto", cod_producto);
        object.append("ordinal", ordinal);
        array_pagado.push(cod_producto);
        //alert("PAGO" + array_pagado);
        array_cantidad.push(cantidad);
        //alert("CANTIDAD" + array_cantidad);
        fetch("InvoiceController/RegistrarDetalle", {
            method: "POST",
            body: object,
        })
            .then((respuesta) => respuesta.text())
            .then(function (response) {
                const Detalle = JSON.parse(response);
                //alert(Detalle.message);
                if (Detalle.message == "NO TIENE SUFICIENTE STOCK") {
                    Swal.fire({
                        icon: "error",
                        title: "NO TIENE SUFICIENTE STOCK",
                    });
                } else {



                    //console.log(response);
                    Detalle.forEach(asd => {
                        //alert(asd.fecha_detalle);
                        //template += "<option value=" + departa.cod_departamento + ">" + departa.nombre_departamento + "</option>"
                        tabla += `
                        <tr class="text-center">
                        <td>${asd.ordinal}</td>
                        <td>${asd.cant_detalle}</td>
                        <td>${asd.precio_venta}</td>
                        <td>${asd.subtotal}</td>
                        <td>${asd.fecha_detalle}</td>
                        <td>${asd.prod_reference}</td>
                        <td>${asd.prod_code_plu}</td>
                        <td>${asd.cod_factura}</td>
                        </tr>
                    `;
                    });
                    boton_detalle_pagar.disabled = false;
                    boton_detalle_cancelar.disabled = false;
                    document.getElementById("tabla_detalle").innerHTML = tabla;
                }
            })
    }

    PagarFactura() {
        var boton_factura = document.getElementById("boton_factura");
        var pagado = document.getElementById("boton_detalle_pagar").value;
        //alert(pagado);
        var object = new FormData();
        object.append("estado", pagado);
        object.append("array", array_pagado);
        object.append("array_cantidad", array_cantidad);
        fetch("InvoiceController/pagarFactura", {
            method: "POST",
            body: object,
        })
            .then((respuesta) => respuesta.text())
            .then(function (response) {

            })
        boton_detalle_pagar.disabled = true;
        boton_detalle_cancelar.disabled = true;
        boton_factura.disabled = true;
        document.getElementById("tabla_detalle").innerHTML = "";
    }

    cancelarFactura() {
        var boton_factura = document.getElementById("boton_factura");
        var cancelado = document.getElementById("boton_detalle_cancelar").value;
        var object = new FormData();
        alert(cancelado);
        object.append("estado", cancelado);
        object.append("array", array_pagado);
        object.append("array_cantidad", array_cantidad);
        fetch("InvoiceController/pagarFactura", {
            method: "POST",
            body: object,
        })
            .then((respuesta) => respuesta.text())
            .then(function (response) {

            })
        boton_detalle_pagar.disabled = true;
        boton_detalle_cancelar.disabled = true;
        boton_factura.disabled = true;
        document.getElementById("tabla_detalle").innerHTML = "";
    }





}
var Invoice = new InvoiceJs();
var cont_factura = "";
var ordinal = 0;
var array_pagado = [];
var array_cantidad = [];