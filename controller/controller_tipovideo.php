<?php
$operacion = $_POST['option'];
//------------------[llamado a los archivos]------------------------
//MVC 
require('../model/mvc/model_mvc_tipovideo.php');
//------------------[Creacion de las instancias de los patrones]------------------------
//intancia generaL para patron PATRON [mvv]
$tipoVideo = new MVCTipoVideo();

switch($operacion)
    {
        case 'insert':
            //llamada a SINGLETON O MVC
            $tipoVideo->setNombreTipoVideo($_POST['nombreTipoVid']);
            echo $tipoVideo->insertData();

        break;

        case 'update':
            //llamada a SINGLETON O MVC
              $tipoVideo->setId($_POST['id']);
              $tipoVideo->setNombreTipoVideo($_POST['nombreTipoVid']);
              echo $tipoVideo->updatetData();
        break;

        case 'delete':
             //llamada a SINGLETON O MVC
            $tipoVideo->setId($_POST['id']);
            echo $tipoVideo->deleteData();
        break;

        case 'showdata':
            //llamda a MVC o singleton
            echo $tipoVideo->getData();

        break;
        case 'count':
            //implmentacio de singleton y MVC
            echo $tipoVideo->countRegister();
        break;
}