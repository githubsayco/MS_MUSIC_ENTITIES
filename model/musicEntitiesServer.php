<?php

header('Content-Type: application/json');
require_once('../config/database_sqlsrv_connect.php'); 

$allowedResourceTypes = [
    'entity',
    'entities'
  ];

$resourceType=$_GET['resource_type'];

if ( !in_array($resourceType,$allowedResourceTypes)){
      die;
}

//enviar parametro del id recurso en particular 
$resourceId= array_key_exists('resource_id', $_GET) ? $_GET['resource_id']:'';

switch ( strtoupper($_SERVER['REQUEST_METHOD'])){
   case 'GET':

              if ($resourceType==$_GET['service']){

                
                $idEntity= array_key_exists('identity', $_GET) ? $_GET['identity']:'';

                $sql_entities="select rtrim(ltrim(nit)) nit, rtrim(ltrim(nombre)) nombre,rtrim(ltrim(direccion)) direccion, rtrim(ltrim(email)) email,
                              rtrim(ltrim(emailp)) emailp,rtrim(ltrim(tel1)) tel1,rtrim(ltrim(tel2))tel2 from mtprocli where nit='".$idEntity. "'"  ;
              }

              $conn_entities = connect_bd_back();
              $stat_entities = sqlsrv_query( $conn_entities, $sql_entities);

              $detEntity = array();

              while( $row = sqlsrv_fetch_array( $stat_entities, SQLSRV_FETCH_ASSOC))

                                {

                                   $detEntity[] = array('nit' => $row['nit'] ,'nombre' => $row['nombre'] , 'direccion' => $row['direccion'] );                    

                                }

              close_bd_back($stat_entities ,$conn_entities);

         echo json_encode($detEntity);
       break;
   
   case 'POST':
             
                if ($resourceType==$_GET['service'])
                {
                   $input = json_decode(file_get_contents('php://input'),true);   
                   
                   echo json_encode($input['NIT']);  

                   $sql_entities="INSERT INTO mtprocli
                   (nit, apellido1, apellido2,
                    cdciiu,
                    ciudad, ciudadprv, codpostal,
                    direccion, email,emailp,EMAILFEC,identifica,
                    nombre, nombre1, nombre2, tel1,
                    tel2, vendedor, pais, coddepto, emailcar,
                    passwordin, fechaing, fecnac, fecmod, habilitado, escliente , esprovee, intcar, codigoctap,codctaniif,facelectro,
                    clase,personanj
                   )
            VALUES ('900123456-7', UPPER('Gomez'), UPPER('Perez'),
                    (SELECT codigo
                       FROM mtcddan
                      WHERE nomciud = UPPER ('Medellin')),
                    (SELECT codciudad
                       FROM ciudad
                      WHERE nombre = UPPER ('Medellin')), UPPER ('Medellin'), '050015',
                    UPPER('Calle 10 No 22-33'), 'empresario@example.com','empresario@example.com', 'empresario@example.com', 'N',
                    UPPER('Gomez Perez Juan'), UPPER('Juan'), UPPER('Carlos'), '0341234567',
                    '3001234567', '001', '169', '05', 'cartera@example.com',
                    'password123', '19/04/2024','19/04/2024','19/04/2024','S','S','S','S','23359501','13809501','1',
                    (select codigo from vPopupClaseSayco where Identifica='N'), (select personanj from vPopupClaseSayco where Identifica='N'))"  ;
                 }

              $conn_entities = connect_bd_back();
              $stat_entities = sqlsrv_query( $conn_entities, $sql_entities);
                   

       break;
   
   case 'PUT':
       break;
   
   case 'DELETE':
       break;
   
   }
   

?>
