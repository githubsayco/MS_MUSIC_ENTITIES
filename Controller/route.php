<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-Token");

require_once('../vendor/autoload.php');
$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->load();

/*
Realizado por Ing Oscar Arevalo 
core_route maneja el condicionamiento de la url que llega del consumo realizado por el host de los microservicios con el fin de identificar 
los diferentes servicios y criterios de busqueda para su enrutamiento a los servers para la ejecucion. 
*/

$uriData=explode("/",$_SERVER['REQUEST_URI']);
$matches = $uriData;

//echo sizeof($matches);

if ($matches[2]==$_ENV["MSERVICE_SING"]){


    switch (sizeof($matches)){
        case 3:
            $_GET['resource_type'] = $matches[2];
            $_GET['service']=$_ENV["MSERVICE_SING"];
            require '../model/musicEntitiesServer.php';
        break;

        case 4:
            $_GET['resource_type'] = $matches[2];
            $_GET['identity'] = $matches[3];
            $_GET['service']=$_ENV["MSERVICE_SING"];
            require '../model/musicEntitiesServer.php';
        break;

        default:
        
        http_response_code(400);
        die(json_encode('Missing parameters'));

    }
    


/*
    
    if (sizeof($matches)==4){

        $_GET['resource_type'] = $matches[2];
        $_GET['identity'] = $matches[3];
        $_GET['service']=$_ENV["MSERVICE_SING"];
        require '../model/musicEntitiesServer.php';
    }  
    

    else{

    }
  */  
    
}

?>