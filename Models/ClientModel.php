<?php
class ClientModel
{
    private $Connection;

    function __construct($Connection)
    {
        $this->Connection = $Connection;
    }

    function listClient()
    {
        try {
            $Connection = new Connection();
            $result = $Connection->query("client");

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

    function insertClient($cliente_documento, $cliente_nombre, $cliente_correo, $cliente_sexo, $cliente_telefono, $cliente_direccion, $cliente_barrio, $cliente_nombre_negocio, $cliente_nit_negocio, $cliente_estado)
    {
        $connection = new Connection();

        $json = json_encode([
            'client_document' => "$cliente_documento",
            'client_name' => "$cliente_nombre",
            'client_email' => "$cliente_correo",
            'client_sex' => "$cliente_sexo",
            'client_telephone' => "$cliente_telefono",
            'client_address' => "$cliente_direccion",
            'client_neighborhood' => "$cliente_barrio",
            'client_name_business' => "$cliente_nombre_negocio",
            'client_nit_business' => "$cliente_nit_negocio",
            'client_satus' => "$cliente_estado"
        ]);

        $connection->queryCreate("client", json_decode($json));
    }

    function selectClient($cliente_documento)
    {
        try {
            $connection = new Connection();

            $filtro = [
                'client_document' => "$cliente_documento"
            ];

            $result = $connection->query("client", $filtro);

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

    function updateClient($cliente_documento, $cliente_nombre, $cliente_correo, $cliente_sexo, $cliente_telefono, $cliente_direccion, $cliente_barrio, $cliente_nombre_negocio, $cliente_nit_negocio, $cliente_estado)
    {
        $connection = new Connection();

        $primary = [
            'client_document' => "$cliente_documento"
        ];

        $actualizar = [
            '$set' => [
                'client_name' => "$cliente_nombre",
                'client_email' => "$cliente_correo",
                'client_sex' => "$cliente_sexo",
                'client_telephone' => "$cliente_telefono",
                'client_address' => "$cliente_direccion",
                'client_neighborhood' => "$cliente_barrio",
                'client_name_business' => "$cliente_nombre_negocio",
                'client_nit_business' => "$cliente_nit_negocio",
                'client_satus' => "$cliente_estado"
            ]
        ];

        $connection->queryUpdate("client", $primary, $actualizar);
    }

    function deleteClient($cliente_documento)
    {
        $connection = new Connection();

        $json = [
            'client_document'=>"$cliente_documento"
        ];

        $connection->queryDelete("client",$json);

    }

    function consultClient($search_client)
    {
        $sql = "SELECT * FROM cliente WHERE cliente_documento LIKE'%$search_client%' OR
                                            cliente_nombre LIKE '%$search_client%' OR
                                            cliente_correo LIKE '%$search_client%' OR
                                            cliente_telefono LIKE '%$search_client%' OR
                                            cliente_nombre_negocio LIKE '%$search_client%' OR
                                            cliente_nit_negocio LIKE '%$search_client%'
                                            ";
        $this->Connection->query($sql);
        return $this->Connection->fetchAll();
    }
}
