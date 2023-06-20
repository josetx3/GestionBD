<?php
require_once "Models/ListInvoiceModel.php";
require_once "Views/ListInvoiceView.php";

class ListInvoiceController
{
    function ListInvoice()
    {
        $Connection = new Connection('sel');
        $ListInvoiceModel = new ListInvoiceModel($Connection);
        $ListInvoiceView = new ListInvoiceView();

        $array_factura = $ListInvoiceModel->listFactura();
        $ListInvoiceView->ListInvoice($array_factura);
    }

    function consultFactura()
    {
        $Connection = new Connection('sel');
        $ListInvoiceModel = new ListInvoiceModel($Connection);
        $ListInvoiceView = new ListInvoiceView();

        $search_factura = $_POST['consulta_factura'];

        if (empty($search_factura)) {
            $response = ["message" => 'INGRESE UN DOCUMENTO PARA REALIZAR LA BUSQUEDA'];
            exit(json_encode($response));
        }
        $arreglo_search_factura = $ListInvoiceModel->consultFactura($search_factura);

        if (!$arreglo_search_factura) {
            $response = ["message" => 'EL PRODUCTO NO SE ENCUENTRA REGISTRADO'];
            exit(json_encode($response));
        }
        $ListInvoiceView->ListInvoice($arreglo_search_factura);
    }
}