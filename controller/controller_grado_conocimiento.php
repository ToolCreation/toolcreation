<?php
$operacion = $_POST['option'];
//------------------[llamado a los archivos]------------------------

//MVC 
require('../model/mvc/conexion.php');
require('../model/mvc/model_mvc_grado_conocimiento.php');

//------------------[Creacion de las instancias de los patrones]------------------------
//intancia generaL para patron PATRON [mvv]
$objGradoConocimiento = new MVCGradoConocimiento();

switch($operacion)
    {
        case 'insert':
            //llamada a SINGLETON O MVC
            $objGradoConocimiento->setNombreGradoConocimiento($_POST['nombreGrado']);
            echo $objGradoConocimiento->insertData();
        break;

        case 'update':
            //llamada a SINGLETON O MVC
              $objGradoConocimiento->setId($_POST['id']);
              $objGradoConocimiento->setNombreGradoConocimiento($_POST['nombreGrado']);
              echo $objGradoConocimiento->updatetData();
        break;
        case 'delete':
             //llamada a SINGLETON O MVC
            $objGradoConocimiento->setId($_POST['id']);
            echo $objGradoConocimiento->deleteData();

        break;
        case 'showdata':
            //llamda a MVC Y SINGLETON
            echo $objGradoConocimiento->getData();
        break;
        case 'count':
            //implmentacio de singleton y MVC
            echo $objGradoConocimiento->countRegister();
        break;
}