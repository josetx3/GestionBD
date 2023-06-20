<?php
class InvoiceView
{

    function paginateInvoice($array_invoice, $array_products)
    {
?>
        <div class="cord">
            <div class="card-header text-center bg-info text-black">
                Registrar una factura
            </div>
            <br>
            <div class="card-body">
                <form id="insert-invoice">
                    <br>

                    <label for="">Generar factura cliente</label>
                    <div class="search-bar">
                        <form id="form_C_invoice" class="search-form align-items-center" method="POST" action="#">
                            <div class="row mb-10">
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="consult_client_invoice" id="consult_client_invoice" placeholder="Busqueda por documento" title="Busqueda por documento">
                                </div>
                                <div class="col-md-1">
                                    <button class="form-control " type="button" title="Buscar"><i class="bi bi-search" onclick="Invoice.consultClientInvoice()"></i></button>
                                </div>
                                <div class="col-md-1">
                                    <button class="form-control " type="button" title="Recargar"><i class="bi bi-arrow-counterclockwise" onclick="Menu.menu('InvoiceController/paginateInvoice')"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
            </div>

            <br>
            <hr>
            <br>

            <div class="row md-12 text-justify">

                <div class="form-group col-md-3">
                    <label for="">NOMBRE CLIENTE</label>
                    <div class="form-group md-12" id="cliente_nombre">
                    </div>
                </div>

                <div class="form-group col-md-3">
                    <label for="">DOCUMENTO CLIENTE</label>
                    <div class="form-group md-12" id="cliente_documento">
                    </div>
                </div>

                <div class="form-group col-md-3">
                    <label for="">NIT NEGOCIO</label>
                    <div class="form-group md-12" id="cliente_nit_negocio">
                    </div>
                </div>

                <div class="form-group col-md-3">
                    <label for="">NOMBRE NEGOCIO</label>
                    <div class="form-group md-12" id="cliente_nombre_negocio">
                    </div>
                </div>

            </div>

            <br>
            <hr>
            <br>
            <div class="search-bar">
                <form id="form_aa_prodcut" class="search-form align-items-center" method="POST" action="#">

                    <div class="row text-justify">
                        <div class="form-group col-8">
                            <label for="">Productos</label>
                            <select class="form-select" name="cod_producto" id="cod_producto">
                                <option value="">Seleccione...</option>
                                <?php
                                if ($array_products) {
                                    foreach ($array_products as $object_product) {
                                        $prod_reference = $object_product->prod_reference;
                                        $prod_description = $object_product->prod_description;
                                ?>
                                        <option value="<?= $prod_reference; ?>"><?= $prod_description; ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group col-1">
                            <label for="">Cantidad</label>
                            <input class="form-control" name="cantidad" id="cantidad" type="text">
                        </div>

                        <div class="form-group col-1 text-center align-items-center">
                            <label for="">Agregar</label>
                            <button type="button" class="form-control btn btn-primary float-right" id="boton_factura" onclick="Invoice.aggDetalle('')" disabled>
                                <i class="bi bi-basket2-fill"></i>
                            </button>
                        </div>

                    </div>

                </form>
            </div>
            <br>
            <hr>

            <div class="row md-12 text-justify align-items-center" id="contenido_fac">

                <!-- ACA SE PEGA LO QUE TRAE DEL JS -->


            </div>

        </div>

        <div class="card">
            <div class="card-header bg-info text-black text-center">
                Listar Detalle
            </div>
            <div class="card-body">
                <br>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr class="text-center">
                                <th>ORDINAL</th>
                                <th>CANT PRODUCTO</th>
                                <th>V. UNITARIO</th>
                                <th>SUBTOTAL</th>
                                <th>FECHA</th>
                                <th>REF PRODUCTO</th>
                                <th>PLU PRODUCTO</th>
                                <th>COD FACTURA</th>
                            </tr>
                        </thead>
                        <tbody id="tabla_detalle">

                        </tbody>
                    </table>
                </div>
                <form action="">
                    <div class="row text-black">

                        <div class="col-4"></div>

                        <div class="form-group col-2">
                            <button type="button" class="form-control btn btn-success float-right" id="boton_detalle_pagar" value="PAGADO" onclick="Invoice.PagarFactura('')" disabled>
                                <i class="bi bi-check-circle-fill text-black"> PAGAR</i>
                            </button>
                        </div>

                        <div class="form-group col-2">
                            <button type="button" class="form-control btn btn-danger float-right" id="boton_detalle_cancelar" value="CANCELADO" onclick="Invoice.cancelarFactura('')" disabled>
                                <i class="bi bi-dash-circle-fill text-black"> CANCELAR</i>
                            </button>
                        </div>

                        <div class="col-4"></div>

                    </div>
                </form>
            </div>
        </div>
<?php
    }
}
