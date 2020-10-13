<?php
$operacion = $_POST['option'];
//------------------[llamado a los archivos]------------------------
//MVC 
require('../model/mvc/conexion.php');
require('../model/mvc/model_mvc_nivel.php');
//------------------[Creacion de las instancias de los patrones]------------------------

//intancia generaL para patron PATRON [mvv]
$nivel = new MVCNivel();

switch($operacion)
    {
        case 'insert':
            //llamada a SINGLETON O MVC
            $nivel->setNombreNivel($_POST['nombreNivel']);
            echo $nivel->insertData();

        break;

        case 'update':
            //llamada a SINGLETON O MVC
              $nivel->setId($_POST['id']);
              $nivel->setNombreNivel($_POST['nombreNivel']);
              echo $nivel->updatetData();
        break;

        case 'delete':
             //llamada a SINGLETON O MVC
            $nivel->setId($_POST['id']);
            echo $nivel->deleteData();
        break;

        case 'showdata':

            //llamda a MVC Y SINGLETON
            echo $nivel->getData();
        break;
        case 'count':
            //implmentacio de singleton y MVC
            echo $nivel->countRegister();
        
        break;
}