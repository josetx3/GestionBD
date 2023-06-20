<?php
class PersonModel
{
    private $Connection;

    function __construct($Connection)
    {
        $this->Connection = $Connection;
    }

    function listPerson()
    {
        try {
            $Connection = new Connection();
            $result = $Connection->query("employees_title");

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

    function selectPosition($emti_id)
    {
        $sql = "SELECT ac.*,et.* FROM access ac , employees_title et WHERE ac.acce_document='$emti_id' AND ac.emti_id=et.emti_id ";
        $this->Connection->query($sql);
        return $this->Connection->fetchAll();
    }

    function selectPerson($document)
    {
        try {
            $connection = new Connection();

            $filtro = [
                'acces.acce_document' => "$document"
            ];

            $result = $connection->query("employees_title", $filtro);

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

    function insertPerson($document, $name1, $name2, $lastname1, $lastname2, $address, $sex, $telephone, $email, $pasword, $emti_name, $acce_state)
    {
        $connection = new Connection();

        $json = json_encode([
            'emti_name'=> "$emti_name",
            'acces' => [
                'acce_document' => "$document", 
                'acce_name1' => "$name1",
                'acce_name2' => "$name2",
                'acce_lastname1' => "$lastname1",
                'acce_lastname2' => "$lastname2",
                'acce_address' => "$address",
                'acce_sex' => "$sex",
                'acce_telephone_number' => "$telephone",
                'acce_email' => "$email",
                'acce_password' => "$pasword",
                'acce_state' => "$acce_state"
            ]

        ]);

        $connection->queryCreate("employees_title", json_decode($json));
    }

    //acce_document='$document',
    function updatePerson($document, $name1, $name2, $lastname1, $lastname2, $address, $telephone, $email, $pasword, $acce_state, $sex)
    {

        $connection = new Connection();

        $primary = [
            'acces.acce_document' => "$document"
        ];

        $actualizar = [
            '$set' => [
                'acces' => [
                    'acce_document' => "$document", 
                    'acce_name1' => "$name1",
                    'acce_name2' => "$name2",
                    'acce_lastname1' => "$lastname1",
                    'acce_lastname2' => "$lastname2",
                    'acce_address' => "$address",
                    'acce_sex' => "$sex",
                    'acce_telephone_number' => "$telephone",
                    'acce_email' => "$email",
                    'acce_password' => "$pasword",
                    'acce_state' => "$acce_state"
                ]
            ]
        ];

        $connection->queryUpdate("employees_title", $primary, $actualizar);
    }

    function consultPerson($search_person)
    {

        $sql = "SELECT ac.*, et.* FROM access ac , employees_title et WHERE ac.emti_id=et.emti_id 
                AND (acce_document = '$search_person' 
                OR acce_name1 = '$search_person' 
                OR acce_email = '$search_person')";
        /*
        $sql = "SELECT ac., et. FROM access ac , employees_title et WHERE ac.emti_id=et.emti_id 
                AND $filter = '$search_person'";
*/
        $this->Connection->query($sql);
        return $this->Connection->fetchAll();
    }


    function deletePerson($document)
    {
        $connection = new Connection();

        $json = [
            'acces.acce_document'=>"$document"
        ];

        $connection->queryDelete("employees_title",$json);
    }
}
