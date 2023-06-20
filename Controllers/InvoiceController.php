<?php
require_once "Models/InvoiceModel.php";
require_once "Views/InvoiceView.php";

class InvoiceController
{
    function paginateInvoice()
    {
        require_once "Models/ProductModel.php";
        $Connection = new Connection('sel');
        $InvoiceModel = new InvoiceModel($Connection);
        $ProductModel = new ProductModel($Connection);
        $InvoiceView = new InvoiceView();
        $array_invoice = $InvoiceModel->listDetalle();
        $array_products = $ProductModel->listProduct();

        $InvoiceView->paginateInvoice($array_invoice, $array_products);
    }

    function consultClientInvoice()
    {
        $Connection = new Connection('sel');
        $InvoiceModel = new InvoiceModel($Connection);
        $InvoiceView = new InvoiceView();

        $search_client = $_POST['documento'];
        $fecha_factura = date('Y-m-d');

        if (empty($search_client)) {
            $response = ["message" => 'INGRESE UN VALOR PARA REALIZAR LA BUSQUEDA'];
            exit(json_encode($response));
        }

        $array_consult_client_invoice = $InvoiceModel->consultClientInvoice($search_client);

        if (!$array_consult_client_invoice) {
            $response = ["message" => 'NO SE ENCUENTRA REGISTRADO O ESTAN MAL LOS VALORES'];
            exit(json_encode($response));
        }
        $InvoiceModel->registrarFactura($fecha_factura, $search_client);
        echo (json_encode($array_consult_client_invoice));
    }

    function RegistrarDetalle()
    {
        $Connection = new Connection('sel');
        $InvoiceModel = new InvoiceModel($Connection);
        $InvoiceView = new InvoiceView();
        $array_invoice = $InvoiceModel->listDetalle();



        $cod_producto = $_POST['cod_producto'];
        $cantidad = $_POST['cantidad'];

        if (empty($cod_producto)) {
            $response = ["message" => 'INGRESE UN VALOR PARA AGREGAR UN PRODUCTO'];
            exit(json_encode($response));
        }

        $array_registrar_detalle = $InvoiceModel->traerProducto($cod_producto);
        $cantidad_resta_factura = $array_registrar_detalle[0]->prod_available_quantity;
        if ($cantidad_resta_factura < $cantidad) {
            $response = ["message" => 'NO TIENE SUFICIENTE STOCK'];
            exit(json_encode($response));
        }

        //print_r($array_registrar_detalle);

        $prod_code_plu = $array_registrar_detalle[0]->prod_code_plu;
        $valor_producto = $array_registrar_detalle[0]->valor;
        $fecha_factura = date('Y-m-d');
        $cod_factura = $InvoiceModel->consultFactura();
        $max_valor = $cod_factura[0]->max;

        $ordinal = $_POST['ordinal'];

        if (!$array_registrar_detalle) {
            $response = ["message" => 'NO SE ENCUENTRA REGISTRADO O ESTAN MAL LOS VALORES'];
            exit(json_encode($response));
        }


        $InvoiceModel->agregarDetalle($ordinal, $cantidad, $fecha_factura, $cod_producto, $prod_code_plu, $max_valor);

        $array_invoice = $InvoiceModel->listarDetalle($max_valor);
        echo (json_encode($array_invoice));
    }

    function pagarFactura()
    {
        $Connection = new Connection('sel');
        $InvoiceModel = new InvoiceModel($Connection);

        $estado = $_POST['estado'];
        $array_cod = $_POST['array'];
        $array_cant = $_POST['array_cantidad'];

        $array_codigo = explode(",", $array_cod);
        $array_cantidad = explode(",", $array_cant);

        if ($estado == "PAGADO") {
            for ($i = 0; $i < count($array_codigo); $i++) {
                //$InvoiceModel->actualizarEstado($array_codigo);
                $traer_codigo = $InvoiceModel->traerProducto($array_codigo[$i]);
                $cantidad = $traer_codigo[0]->prod_available_quantity;
                $InvoiceModel->actualizarCantidad(($cantidad - $array_cantidad[$i]), $array_codigo[$i]);
            }
        }
        $cod_factura = $InvoiceModel->consultFactura();
        $max_valor = $cod_factura[0]->max;
        $InvoiceModel->ActualizarEstadoFactura($max_valor, $estado);
    }
}
