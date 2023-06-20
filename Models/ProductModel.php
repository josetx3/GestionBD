<?php

class ProductModel
{
    private $Connection;

    function __construct($Connection)
    {
        $this->Connection = $Connection;
    }

    function listProduct()
    {
        try {
            $Connection = new Connection();
            $result = $Connection->query("product");
            $productos = [];
            foreach ($result as $producto) {
                $productos[] = $producto->jsonSerialize();
            }
            if (is_null($productos)) {
                exit("SIN DATOS");
            }
            return $productos;
        } catch (Exception $e) {
            printf($e->getMessage());
        }
    }

    function insertProduct($prod_reference, $prod_code_plu, $prod_description, $prod_available_quantity, $prod_arrival_price, $valor, $prod_iva)
    {
        $connection = new Connection();
        $json = json_encode([
            'prod_reference' => "$prod_reference",
            'prod_code_plu' => "$prod_code_plu",
            'prod_description' => "$prod_description",
            'prod_available_quantity' => "$prod_available_quantity",
            'prod_arrival_price' => "$prod_arrival_price",
            'value' => "$valor",
            'prod_iva' => "$prod_iva",
        ]);
        $connection->queryCreate("product", json_decode($json));
    }

    function updateProduct($prod_reference, $prod_code_plu, $prod_description, $prod_available_quantity, $prod_arrival_price, $valor, $prod_iva)
    {
        $connection = new Connection();
        $primary = [
            'prod_reference' => "$prod_reference"
        ];
        $actualizar = [
            '$set' => [
                'prod_code_plu' => "$prod_code_plu",
                'prod_description' => "$prod_description",
                'prod_available_quantity' => "$prod_available_quantity",
                'prod_arrival_price' => "$prod_arrival_price",
                'value' => "$valor",
                'prod_iva' => "$prod_iva",
            ]
        ];

        $connection->queryUpdate("product", $primary, $actualizar);
    }

    function selectProduct($prod_code_plu)
    {
        try {
            $connection = new Connection();
            $filtro = [
                'prod_reference' => "$prod_code_plu"
            ];
            $result = $connection->query("product", $filtro);
            foreach ($result as $document) {
                $salida = json_encode($document->jsonSerialize());
            }
            if (is_null($salida)) {
                exit("SIN DATOS");
            }
            return $salida;
        } catch (Exception $e) {
            printf($e->getMessage());
        }
    }

    function consultProduct($search_product)
    {
        $sql = "SELECT * FROM produc WHERE prod_code_plu = '$search_product' OR prod_description LIKE '%$search_product%'";
        $this->Connection->query($sql);
        return $this->Connection->fetchAll();
    }

    function deleteProduct($prod_reference)
    {
        $connection = new Connection();

        $json = [
            'prod_reference'=>"$prod_reference"
        ];

        $connection->queryDelete("product",$json);
    }

}
