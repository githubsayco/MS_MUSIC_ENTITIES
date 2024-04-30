<?php

header('Content-Type: application/json');
require_once('../config/database_sqlsrv_connect.php'); 

$allowedResourceTypes = [
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
                                 VALUES ('". $input['NIT'] ."', UPPER('". $input['APELLIDO1'] ."'), UPPER('". $input['APELLIDO2'] ."'),
                                 (SELECT min(codigo)
                                    FROM mtcddan
                                    WHERE nomciud like UPPER ('%" . $input['CIUDADPRV'] ."%')),
                                 (SELECT codciudad
                                    FROM ciudad
                                    WHERE nombre like UPPER ('%". $input['CIUDADPRV'] ."%')), UPPER ('". $input['CIUDADPRV'] ."'), '" . $input['CODPOSTAL'] ."',
                                 UPPER('". $input['DIRECCION'] ."'), '" . $input['EMAIL'] ."', '" . $input['EMAIL'] ."' , '" . $input['EMAIL'] ."', '".$input['IDENTIFICA'] ."',
                                 UPPER('" . $input['NOMBRE'] ."'), UPPER('" . $input['NOMBRE1'] ."'), UPPER('" . $input['NOMBRE2'] ."'), '" . $input['TEL1'] ."',
                                 '" . $input['TEL2'] . "', '" . $input['VENDEDOR'] ."', '" . $input['PAIS'] ."', '" . $input['CODDEPTO'] ."', '" . $input['EMAILCAR'] ."',
                                 '" . $input['PASSWORDIN'] . "', CONVERT(VARCHAR(10), GETDATE(), 103), CONVERT(VARCHAR(10), GETDATE(), 103),CONVERT(VARCHAR(10), GETDATE(), 103),'S','S','S','S','23359501','13809501','1',
                                 (select codigo from vPopupClaseSayco where Identifica='".$input['IDENTIFICA'] ."'), (select personanj from vPopupClaseSayco where Identifica='".$input['IDENTIFICA'] ."'))"  ;
                              
                           $conn_entities = connect_bd_back();
                           $stat_entities = sqlsrv_query( $conn_entities, $sql_entities);
                           
                                  
                         if( $stat_entities === false ) {
                             
                           http_response_code(400);
                           die(json_encode('Insert Failed '));

                              
                         }
                     
                         http_response_code(201);
                         close_bd_back($stat_entities ,$conn_entities);       
                         echo json_encode('Insert completed');

               }
       break;
   
   case 'PUT':
       break;
   
   case 'DELETE':
       break;
   
   }
   

?>
