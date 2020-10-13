<?php
$operacion = $_POST['option'];
//------------------[llamado a los archivos]------------------------
//MVC 
require('../model/mvc/model_mvc_estadocurso.php');

//------------------[Creacion de las instancias de los patrones]------------------------
//intancia generaL para patron PATRON [mvv]
$estadoCurso = new MVCEstadoCurso();

switch($operacion)
    {
        case 'insert':
            //llamada a SINGLETON O MVC
            $estadoCurso->setNombreEstadoCurso($_POST['nombreEstadoCurso']);
            echo $estadoCurso->insertData();

        break;

        case 'update':
            //llamada a SINGLETON O MVC
              $estadoCurso->setId($_POST['id']);
              $estadoCurso->setNombreEstadoCurso($_POST['nombreEstadoCurso']);
              echo $estadoCurso->updatetData();

        break;

        case 'delete':
             //llamada a SINGLETON O MVC
            $estadoCurso->setId($_POST['id']);
            echo $estadoCurso->deleteData();
        break;

        case 'showdata':
            //llamda a MVC Y SINGLETON
            echo $estadoCurso->getData();
        break;
        case 'count':
            //implmentacio de singleton y MVC
            echo $estadoCurso->countRegister();
        break;
}