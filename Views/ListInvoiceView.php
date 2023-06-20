<?php
class ListInvoiceView
{
    function ListInvoice($array_factura)
    {
?>
        <div class="card">
            <div class="card-header bg-info text-black text-center">
                Listar Facturas
            </div>

            <div class="card-body">
                <br>
                <div class="search-bar">
                    <form id="form_consulta_factura" class="search-form align-items-center" method="POST" action="#">
                        <div class="row mb-10">
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="consulta_factura" id="consulta_factura" placeholder="Busqueda por documento de cliente" title="Busqueda por documento de cliente">
                            </div>
                            <div class="col-md-1">
                                <button class="form-control " type="button" title="Busqueda por documento de cliente"><i class="bi bi-search" onclick="ListInvoice.consultFactura()"></i></button>
                            </div>
                            <div class="col-md-1">
                                <button class="form-control " type="button" title="Recargar"><i class="bi bi-arrow-counterclockwise" onclick="Menu.menu('ListInvoiceController/ListInvoice')"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
                <br>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr class=" text-center">
                                <th>COD FACTURA</th>
                                <th>FECHA FACTURA</th>
                                <th>TOTAL FACTURA</th>
                                <th>DOC CLIENTE</th>
                                <th>ESTADO</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($array_factura as $object_factura) {
                                $cod_factura = $object_factura->cod_factura;
                                $fecha_factura = $object_factura->fecha_factura;
                                $total_factura = $object_factura->total_factura;
                                $cliente_documento = $object_factura->cliente_documento;
                                $estado = $object_factura->estado;
                            ?>
                                <tr class="text-center">
                                    <td> <?= $cod_factura; ?> </td>
                                    <td> <?= $fecha_factura; ?> </td>
                                    <td>$ <?= $total_factura; ?> </td>
                                    <td> <?= $cliente_documento; ?> </td>
                                    <td> <?= $estado; ?> </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
<?php
    }
}
