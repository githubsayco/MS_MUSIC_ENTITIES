<?php

require_once('../vendor/autoload.php');
$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->load();

function connect_bd_back() 
  {       
    $serverName = $_ENV["DB_HOST"];
    $connectionInfo = array("Database" => $_ENV["DB_NAME"], "UID" => $_ENV["DB_USER"], "PWD" => $_ENV["DB_PASSWD"]);

    $conn = sqlsrv_connect($serverName, $connectionInfo);
      
    if($conn) {
        return $conn;
        //echo "Connection established.<br />";
    }else{
        //echo "Connection could not be established.<br />";
        die( print_r( sqlsrv_errors(), true));
    }

}

function close_bd_back($stat,$conn) 
   {
    
     if ($stat == null){
        sqlsrv_close($conn);	
     }
     else
     {
        sqlsrv_free_stmt($stat);
        sqlsrv_close($conn);	
     }
     
   }

?>