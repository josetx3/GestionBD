<?php

class InvoiceModel
{
    private $Connection;
    function __construct($Connection)
    {
        $this->Connection = $Connection;
    }

    function listDetalle()
    {
        $sql = "SELECT * FROM detalle";
        $this->Connection->query($sql);
        return $this->Connection->fetchAll();
    }

    function consultClientInvoice($search_client)
    {
        $sql = "SELECT * FROM cliente WHERE cliente_documento = '$search_client' OR cliente_nit_negocio = '$search_client'";
        $this->Connection->query($sql);
        return $this->Connection->fetchAll();
    }

    function aggProduct($aggProduct)
    {
        $sql = "SELECT * FROM produc WHERE prod_reference = '$aggProduct' OR prod_code_plu = '$aggProduct'";
        $this->Connection->query($sql);
        return $this->Connection->fetchAll();
    }

    function registrarFactura($fecha_factura, $cliente_documento)
    {
        $sql = "INSERT INTO factura (cod_factura,fecha_factura,cliente_documento)
                            VALUES  (default,'$fecha_factura','$cliente_documento')
        ";
        $this->Connection->query($sql);
    }

    function traerProducto($cod_producto)
    {
        $sql = "SELECT * FROM produc WHERE prod_reference = '$cod_producto'";
        $this->Connection->query($sql);
        return $this->Connection->fetchAll();
    }

    function consultFactura()
    {
        $sql = "SELECT max(cod_factura) FROM factura";
        $this->Connection->query($sql);
        return $this->Connection->fetchAll();
    }

    function agregarDetalle($ordinal, $valor_cantidad, $fecha_factura, $prod_reference, $prod_code_plu, $cod_factura)
    {
        $sql = "INSERT INTO public.detalle(ordinal, cant_detalle, fecha_detalle, prod_reference, prod_code_plu, cod_factura)
                                    VALUES ('$ordinal', $valor_cantidad, '$fecha_factura', '$prod_reference', '$prod_code_plu', '$cod_factura')";
        $this->Connection->query($sql);
    }

    function listarDetalle($max_valor)
    {
        $sql = "SELECT * FROM detalle where cod_factura = '$max_valor'";
        $this->Connection->query($sql);
        return $this->Connection->fetchAll();
    }

    function actualizarCantidad($cantidad, $cod_producto)
    {
        $sql = "UPDATE produc SET
        prod_available_quantity = '$cantidad'
        WHERE prod_reference = '$cod_producto'
        ";
        $this->Connection->query($sql);
    }

    function ActualizarEstadoFactura($max_valor, $estado)
    {
        $sql = "UPDATE factura set
            estado = '$estado'
            WHERE cod_factura = '$max_valor'
             ";
        $this->Connection->query($sql);
        return $this->Connection->fetchAll();
    }


}
