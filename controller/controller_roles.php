<?php
$operacion = $_POST['option'];
//------------------[llamado a los archivos]------------------------

//MVC 
require('../model/mvc/model_mvc_roles.php');
//------------------[Creacion de las instancias de los patrones]------------------------

//intancia generaL para patron PATRON [mvv]
$objRol = new MVCRoles();


switch($operacion)
    {
        case 'insert':
            //llamada a SINGLETON O MVC
            $objRol->setNombreRol($_POST['nombreRol']);
            echo $objRol->insertData();
        break;

        case 'update':
            //llamada a SINGLETON O MVC
              $objRol->setId($_POST['id']);
              $objRol->setNombreRol($_POST['nombreRol']);
              echo $objRol->updatetData();

        break;

        case 'delete':
             //llamada a SINGLETON O MVC
            $objRol->setId($_POST['id']);
            echo $objRol->deleteData();
        break;

        case 'showdata':
            //llamda a MVC Y SINGLETON
            echo $objRol->getData();

        break;
        case 'count':
            //implmentacio de singleton y MVC
            echo $objRol->countRegister();
        break;
}