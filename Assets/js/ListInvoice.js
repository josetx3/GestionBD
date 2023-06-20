class ListInvoiceJs{

    consultFactura() {
        var object = new FormData(document.querySelector("#form_consulta_factura"));
        fetch("ListInvoiceController/consultFactura", {
            method: "POST",
            body: object,
        })
            .then((respuesta) => respuesta.text())
            .then(function (response) {
                try {
                    object = JSON.parse(response);
                    Swal.fire({
                        icon: "error",
                        title: "ERROR",
                        text: object.message,
                    });
                } catch (error) {
                    document.querySelector("#content").innerHTML = response;
                    let timerInterval
                    Swal.fire({
                        icon: 'success',
                        title: 'EXITO',
                        html: 'BUSQUEDA EXITOSA <br>LA VENTANA SE CERRARA EN <b></b> ',
                        timer: 1000,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading()
                            const b = Swal.getHtmlContainer().querySelector('b')
                            timerInterval = setInterval(() => {
                                b.textContent = Swal.getTimerLeft()
                            }, 100)
                        },
                        willClose: () => {
                            clearInterval(timerInterval)
                        }
                    }).then((result) => {
                        /* Read more about handling dismissals below */
                        if (result.dismiss === Swal.DismissReason.timer) {
                            console.log('BUSQUEDA EXITOSA')
                        }
                    })
                }
            })
            .catch(function (error) {
                console.log(error);
            });
    }

}
var ListInvoice = new ListInvoiceJs();