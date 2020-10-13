<?php
$operacion = $_POST['option'];
//------------------[llamado a los archivos]------------------------

//MVC 
require('../model/mvc/conexion.php');
require('../model/mvc/model_mvc_moneda.php');

//------------------[Creacion de las instancias de los patrones]------------------------
//intancia generaL para PATRON [mvc]
$objmoneda = new MVCMoneda();

switch($operacion)
    {
        case 'insert':
            //llamda a MVC singleton
              $objmoneda->setData($_POST['nombreMoneda'], $_POST['valor']);
              echo $objmoneda->insertData();

        break;

        case 'update':
            //llamda a MVC O singleton
              $objmoneda->setId($_POST['id']);
              $objmoneda->setData($_POST['nombreMoneda'], $_POST['valor']);
              echo $objmoneda->updatetData();
        break;

        case 'delete':
            //llamda a MVC o singleton
            $objmoneda->setId($_POST['id']);
            echo $objmoneda->deleteData();
        break;

        case 'showdata':
             //llamada a singleton a MVC
             echo $objmoneda->getData();
        break;
        case 'count':
            //implmentacio de singleton y MVC
            echo $objmoneda->countRegister();
        break;

}