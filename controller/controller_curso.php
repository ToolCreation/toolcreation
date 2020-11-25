<?php
$option = $_POST['option'];
//------------------[llamado a los archivos]------------------------
require('../model/mvc/conexion.php');
require('../model/mvc/model_mvc_cursos.php');

//------------------[Creacion de las instancias de los patrones]------------------------
$typoImg = (isset($_FILES['imgCurso']['type']))? $_FILES['imgCurso']['type']: '';
$nombreImg = (isset($_FILES['imgCurso']['name']))? $_FILES['imgCurso']['name']: '';
$rutaActualImg = (isset($_FILES['imgCurso']['tmp_name']))? $_FILES['imgCurso']['tmp_name']: '';
$typoVideo = (isset($_FILES['video']['type']))? $_FILES['video']['type']: '';
$nombreVideo = (isset($_FILES['video']['name']))? $_FILES['video']['name']: '';
$rutaActualVideo = (isset($_FILES['video']['tmp_name']))? $_FILES['video']['tmp_name']: '';

$curso = new MVCCurso();
switch($option){
    case 'insert':
        $curso->setNombre($_POST['nombre']);
        $curso->setConocimiento($_POST['conocimiento']);
        $curso->setRequistos($_POST['requisitos']);
        $curso->setDescripcion($_POST['descripcion']);
        $curso->setTipoImagen($typoImg);
        $curso->setImagenCurso($nombreImg );
        $curso->setRutaActualImagen($rutaActualImg);
        $curso->setTipoVideo($typoVideo);
        $curso->setVideoPrueba( $nombreVideo);
        $curso->setRutaVideoActual($rutaActualVideo);
        $curso->setCategoria($_POST['categoria']);
        $curso->setNivel($_POST['nivel']);
        $curso->setPrecio($_POST['precio']);
        $curso->setMoneda($_POST['moneda']);
        $curso->setInstructor($_POST['instructor']);
        echo $curso->insertData(); 
    break;
    case 'update':
       
        $curso->setId($_POST['idCurso']);
        $curso->setNombre($_POST['nombre']);
        $curso->setConocimiento($_POST['conocimiento']);
        $curso->setRequistos($_POST['requisitos']);
        $curso->setDescripcion($_POST['descripcion']);
        $curso->setTipoImagen($typoImg);
        $curso->setImagenCurso($nombreImg);
        $curso->setRutaActualImagen($rutaActualImg);
        $curso->setTipoVideo($typoVideo);
        $curso->setVideoPrueba( $nombreVideo);
        $curso->setRutaVideoActual($rutaActualVideo);
        $curso->setCategoria($_POST['categoria']);
        $curso->setNivel($_POST['nivel']);
        $curso->setPrecio($_POST['precio']);
        $curso->setMoneda($_POST['moneda']);
        echo $curso->updateData();
    break;
    case 'delete':
        $curso->setId($_POST['idCurso']);
        $curso->eliminar();
    break;
    case 'publish':
        $curso->setId($_POST['idCurso']);
        $curso->publicar();
    break;
    case 'restaurar':
        $curso->setId($_POST['idCurso']);
        $curso->restaurar();
    break;
    case 'showData':
        $curso->setInstructor($_POST['idProfesor']);
        echo $curso->showData();
    break;
    case 'showDataCursos':
        echo $curso->showDataCursoClient();
    break;
    case 'showFilterCurseCatefory':
        $curso->setCategoria($_POST['idCategory']);
        echo $curso->filterCurseForCategory();
    break;
    case 'showDataCursosDetail':
        $curso->setId($_POST['IDCURSO']);
        echo $curso->cursoDeatail();
    break;
    case 'porcentajeCurso':
        $estudiante = $_POST['estudiante'];
        $curso->setId($_POST['IDCURSO']);
        echo $curso->obtenerPorcentaje($estudiante);
    break;
    
    
}

