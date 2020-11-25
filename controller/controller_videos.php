<?php
$operacion = $_POST['option'];

// $operacion = 'update';

//------------------[llamado a los archivos]------------------------
//MVC 
require('../model/mvc/model_mvc_videos.php');

//------------------[Creacion de las instancias de los patrones]------------------------
$video = new MVCVideos();

$typoFileVideo = (isset($_FILES['video']['type']))? $_FILES['video']['type']: '';
$nombreVideo = (isset($_FILES['video']['name']))? $_FILES['video']['name']: '';
$rutaActualVideo = (isset($_FILES['video']['tmp_name']))? $_FILES['video']['tmp_name']: '';
switch($operacion){
    case 'insert':
         $video->setNombre($_POST['nombreVideo']);
         $video->setUrl($_POST['url']);
         $video->setTema($_POST['tema']);
         $video->setTipo($_POST['tipo']);
         $video->setTipeVideoExtension($typoFileVideo);
         $video->setVideoFile($nombreVideo);
         $video->setRutaActual($rutaActualVideo);
         echo $video->insertar();

        break;
    case 'update':
         $video->setId($_POST['id']);
         $video->setNombre($_POST['nombreVideo']);
         $video->setUrl($_POST['url']);
         $video->setTema($_POST['tema']);
         $video->setTipo($_POST['tipo']);
         $video->setTipeVideoExtension($typoFileVideo);
         $video->setVideoFile($nombreVideo);
         $video->setRutaActual($rutaActualVideo);
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
    case 'showVideoStateTema':
        $estudiante = $_POST['estudiante'];
        $video->setIdCurso($_POST['IDCURSO']);
        echo $video->listaVideosConEstadosDeTema($estudiante);
        break;
}




