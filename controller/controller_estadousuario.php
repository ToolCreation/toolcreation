<?php
$operacion = $_POST['option'];
//------------------[llamado a los archivos]------------------------
//MVC 
require('../model/mvc/model_mvc_estadousuario.php');

//------------------[Creacion de las instancias de los patrones]------------------------

//intancia generaL para patron PATRON [mvv]
$objEstadoUsuario = new MVCEstadoUsuario();

switch($operacion)
    {
        case 'insert':
            //llamada a SINGLETON O MVC
            $objEstadoUsuario->setNombreEstado($_POST['nombreEstadoUsuario']);
            $objEstadoUsuario->setDescripcion($_POST['descripcion']);
            echo $objEstadoUsuario->insertData();
        break;

        case 'update':
            //llamada a SINGLETON O MVC
              $objEstadoUsuario->setId($_POST['id']);
              $objEstadoUsuario->setNombreEstado($_POST['nombreEstadoUsuario']);
              $objEstadoUsuario->setDescripcion($_POST['descripcion']);
              echo $objEstadoUsuario->updatetData();

        break;

        case 'delete':
             //llamada a SINGLETON O MVC
            $objEstadoUsuario->setId($_POST['id']);
            echo $objEstadoUsuario->deleteData();

        break;

        case 'showdata':
            //llamda a MVC Y SINGLETON
            echo $objEstadoUsuario->getData();
        break;
        case 'count':
            //implmentacio de singleton y MVC
            echo $objEstadoUsuario->countRegister();
        break;
}