<?php
$operacion = $_POST['option'];
//------------------[llamado a los archivos]------------------------
//MVC 
require('../model/mvc/conexion.php');
require('../model/mvc/model_mvc_estancia.php');
//------------------[Creacion de las instancias de los patrones]------------------------
//intancia generaL para patron PATRON [mvv]
$objEstancia = new MVCEstancia();
switch($operacion)
    {
        case 'insert':
            //llamada a SINGLETON O MVC
            $objEstancia->setNombreEstancia($_POST['nombreEstancia']);
            echo $objEstancia->insertData();
        break;

        case 'update':
            //llamada a SINGLETON O MVC
              $objEstancia->setId($_POST['id']);
              $objEstancia->setNombreEstancia($_POST['nombreEstancia']);
              echo $objEstancia->updatetData();
        break;

        case 'delete':
             //llamada a SINGLETON O MVC
            $objEstancia->setId($_POST['id']);
            echo $objEstancia->deleteData();
        break;

        case 'showdata':
            //llamda a MVC Y SINGLETON
            echo $objEstancia->getData();
        break;
        case 'count':
            //implmentacio de singleton y MVC
            echo $objEstancia->countRegister();
        break;
}