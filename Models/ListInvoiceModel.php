<?php

class ListInvoiceModel
{

    private $Connection;

    function __construct($Connection)
    {
        $this->Connection = $Connection;
    }

    function listFactura()
    {
        //$sql = "SELECT * FROM factura";
        $sql = "SELECT * FROM factura ORDER BY cod_factura";
        $this->Connection->query($sql);
        return $this->Connection->fetchAll();
    }

    function consultFactura($search_factura)
    {
        $sql = "SELECT * FROM factura WHERE cliente_documento LIKE '%$search_factura%'";
        //$sql = "SELECT * FROM factura WHERE cliente_documento = '$search_factura'";
        $this->Connection->query($sql);
        return $this->Connection->fetchAll();
    }

}
