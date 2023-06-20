<?php
require_once "Models/AccessModel.php";
require_once "Views/AccessView.php";

class AccessController
{
    function validateClient()
    {
        $AccesView = new AccessView();
        $AccesView->showFormSession();
    }

    function validateFormSession($array)
    {
        $Connection=new Connection('sel');
        $AccessModel=new AccessModel($Connection);
         
        $email=$array['email'];
        $password=$array['password'];


        $array_access=$AccessModel->validateFormSession($email,$password);
        $Respuesta = json_decode($array_access);

        if($Respuesta->acces->acce_email==$email && $Respuesta->acces->acce_password == $password)
        {


            $_SESSION['emti_name']=$Respuesta->emti_name;
            $_SESSION['auth']='OK';
            //$_SESSION['acce_name1']=$Respuesta->access->acce_name1;
            //$_SESSION['acce_email']=$Respuesta->access->acce_email;
            //$_SESSION['emti_id']=$array_access[0]->emti_id;
        }
        header('Location: index.php');

    }

    function closeSession()
    {
        $response=array();
        
        session_unset();
        session_destroy();
        $_SESSION = array();
        $response['message']="Que tenga un buen día";
        exit(json_encode($response));
        
    }
}
