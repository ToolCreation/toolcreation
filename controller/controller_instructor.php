<?php
$option = $_POST['option'];
//------------------[llamado a los archivos]------------------------
require('../model/mvc/model_mvc_instructor.php');


//------------------[Creacion de las instancias de los patrones]------------------------
$profesor = new MVCProfesor();

// $option = 'auntentificaion';

switch($option){
    case 'auntentificaion':
        $profesor->setIdUsuario($_POST['idUsuario']);
        // $profesor->setIdUsuario('23');
        $profedorVerificado = $profesor->verificarSiEsProfesor();
        session_start();
        if($profedorVerificado == null){
          $stateSesionProfesor =   $profesor->registrarNuevoProfesor();
          // var_dump($stateSesionProfesor);
          if($stateSesionProfesor == 'ErrorRegistro'){
            echo json_encode(array("error"=>"NoseRegistro",
                                    "stateFunction"=>"FalloRegistro"));
          }else if($stateSesionProfesor == '0'){
            echo json_encode(array("error"=>"NoseEncontro",
                                    "stateFunction"=>"NoEncontre"));
          }else{
            $_SESSION['idProfesor']        = $stateSesionProfesor[0];
            $_SESSION['gradoConocimiento'] = $stateSesionProfesor[1];
            $_SESSION['estancia']          = $stateSesionProfesor[2];
            $_SESSION['profesor']          = "YES";
            echo json_encode(array( "idProfesor"        => $stateSesionProfesor[0],
                                    "gradoConocimiento" => $stateSesionProfesor[1],
                                    "estancia"          => $stateSesionProfesor[1],
                                    "profesor" =>   $_SESSION['profesor'] ,
                                    "success"   => "OK",
                                    "stateFunction"=>"RegistradoYLogeado"));
          }
        }else{
            $arrayDataProfesor = $profesor->autentificarProfesor();
            if($arrayDataProfesor[0] == 0){
               echo json_encode(array("error"=>"noSeLogeo",
                                   "stateFunction" => "me meti a logar directo pero no pude"));
            }else{
                $_SESSION['idProfesor']        = $arrayDataProfesor[0];
                $_SESSION['gradoConocimiento'] = $arrayDataProfesor[1];
                $_SESSION['estancia']          = $arrayDataProfesor[2];
                $_SESSION['profesor']          = "YES";
                echo json_encode(array( "idProfesor"        => $arrayDataProfesor[0],
                                        "gradoConocimiento" => $arrayDataProfesor[1],
                                        "estancia"          => $arrayDataProfesor[1],
                                        "profesor" =>   $_SESSION['profesor'] ,
                                        "success"=>'OK',
                                        "stateFunction"=>"Logeado"));
            }
           
        }
        // echo $profedorVerificado;
    break;

    case 'update':
      $profesor->setIdInstructor($_POST['id']);
      $profesor->setGradoConocimiento($_POST['conocimiento']);
      $profesor->setEstancia($_POST['estancia']);
      echo $profesor->update();

    break;
}