<?php
$operacion = $_POST['option'];
//------------------[llamado a los archivos]------------------------
//MVC 
require('../model/mvc/model_mvc_recursos.php');

//------------------[Creacion de las instancias de los patrones]------------------------
$recurso = new MVCRecursos();

switch($operacion){
    case 'insert':
         $recurso->setNombre($_POST['nombreRecurso']);
         $recurso->setUrl($_POST['url']);
         $recurso->setVideo($_POST['video']);
         $recurso->setTipo($_POST['tipo']);
         echo $recurso->insertar();

        break;
    case 'update':
         $recurso->setId($_POST['id']);
         $recurso->setNombre($_POST['nombreRecurso']);
         $recurso->setUrl($_POST['url']);
         $recurso->setVideo($_POST['video']);
         $recurso->setTipo($_POST['tipo']);
         echo $recurso->actualizar();
        break;
    case 'delete':
        $recurso->setId($_POST['id']);
        $recurso->eliminar();
        break;
    case 'showdata':
        $recurso->setIdCurso($_POST['IDCURSO']);
        echo $recurso->listarRegistros();
        break;
    case 'count':
         $recurso->setIdCurso($_POST['IDCURSO']);
         echo $recurso->contarRegistros();
        break;
}



