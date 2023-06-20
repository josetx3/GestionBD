<?php
class AccessModel
{
    private $Connection;

    function __construct($Connection)
    {
        $this->Connection = $Connection;
    }

    function consultEmail($email)
    {
        $sql = "SELECT * FROM access WHERE acce_email='$email'";
        $this->Connection->query($sql);
        return $this->Connection->fetchAll();
    }

    function validateFormSession($user,$password)
    {
        try {
            $connection = new Connection();

            $filtro =[
                'acces.acce_email' => "$user",
                'acces.acce_password' => "$password",

            ];

            $result = $connection->query("employees_title",$filtro);

            foreach($result AS $document){
                $salida = json_encode($document->jsonSerialize());
            }



            if(is_null($salida)){
                exit("SIN DATOS");
            }

            return $salida;
            
        } catch (Exception $e) {
            printf($e->getMessage());
        }
    }

}
?>