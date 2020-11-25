<?php
$operacion = $_POST['option'];
//------------------[llamado a los archivos]------------------------
//MVC 
require('../model/mvc/model_mvc_estadotema.php');
//------------------[Creacion de las instancias de los patrones]------------------------
//intancia generaL para patron PATRON [mvv]
$objEstadoTema = new MVCEstadoTema();

switch($operacion)
    {
        case 'insert':
            //llamada a SINGLETON O MVC
            $objEstadoTema->setNombreEstado($_POST['nombreEstadoTema']);
            echo $objEstadoTema->insertData();
        break;

        case 'update':
            //llamada a SINGLETON O MVC
              $objEstadoTema->setId($_POST['id']);
              $objEstadoTema->setNombreEstado($_POST['nombreEstadoTema']);
              echo $objEstadoTema->updatetData();

        break;

        case 'delete':
             //llamada a SINGLETON O MVC
            $objEstadoTema->setId($_POST['id']);
            echo $objEstadoTema->deleteData();
        break;

        case 'showdata':
            //llamda a MVC Y SINGLETON
            echo $objEstadoTema->getData();
        break;
        case 'count':
            //implmentacio de singleton y MVC
            echo $objEstadoTema->countRegister();
        break;
       
}