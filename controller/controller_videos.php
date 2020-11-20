<?php
$operacion = $_POST['option'];

// $operacion = 'update';

//------------------[llamado a los archivos]------------------------
//MVC 
require('../model/mvc/model_mvc_videos.php');

//------------------[Creacion de las instancias de los patrones]------------------------
$video = new MVCVideos();

switch($operacion){
    case 'insert':
         $video->setNombre($_POST['nombreVideo']);
         $video->setUrl($_POST['url']);
         $video->setTema($_POST['tema']);
         $video->setTipo($_POST['tipo']);
         echo $video->insertar();

        break;
    case 'update':
         $video->setId($_POST['id']);
         $video->setNombre($_POST['nombreVideo']);
         $video->setUrl($_POST['url']);
         $video->setTema($_POST['tema']);
         $video->setTipo($_POST['tipo']);
         echo $video->actualizar();
        break;
    case 'delete':
        $video->setId($_POST['id']);
        $video->eliminar();
        break;
    case 'showdata':
        $video->setIdCurso($_POST['IDCURSO']);
        echo $video->listarRegistros();
        break;
    case 'count':
        $video->setIdCurso($_POST['IDCURSO']);
         echo $video->contarRegistros();
        break;
}




