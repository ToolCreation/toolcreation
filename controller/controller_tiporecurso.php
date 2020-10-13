<?php
$operacion = $_POST['option'];
//------------------[llamado a los archivos]------------------------
//MVC 
require('../model/mvc/model_mvc_tiporecurso.php');

//------------------[Creacion de las instancias de los patrones]------------------------
//intancia generaL para patron PATRON [mvv]
$tipoRec = new MVCTipoRecurso();

switch($operacion)
    {
        case 'insert':
            //llamada a SINGLETON O MVC
            $tipoRec->setNombreTipoRec($_POST['nombreTipoRec']);
            echo $tipoRec->insertData();
        break;

        case 'update':
            //llamada a SINGLETON O MVC
              $tipoRec->setId($_POST['id']);
              $tipoRec->setNombreTipoRec($_POST['nombreTipoRec']);
              echo $tipoRec->updatetData();
        break;

        case 'delete':
             //llamada a SINGLETON O MVC
            $tipoRec->setId($_POST['id']);
            echo $tipoRec->deleteData();
        break;

        case 'showdata':
            //llamda a MVC o singleton
            echo $tipoRec->getData();
        break;
        case 'count':
            //implmentacio de singleton y MVC
            echo $tipoRec->countRegister();
        break;
}