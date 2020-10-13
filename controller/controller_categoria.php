<?php 
$operacion = $_POST['option'];
//------------------[llamado a los archivos]------------------------
//MVC 
require('../model/mvc/conexion.php');
require('../model/mvc/model_mvc_categoria_inst.php');

//------------------[Creacion de las instancias de los patrones]------------------------
//intancia generaL para patron PATRON [mvc]
$objCategoria = new MVCCategoriaInstructor();




switch($operacion)
    {
        case 'insert':
            $objCategoria->setNombreCategoria($_POST['nombreCategoria']);
            echo $objCategoria->insertData();
        break;

        case 'update':
              $objCategoria->setId($_POST['id']);
              $objCategoria->setNombreCategoria($_POST['nombreCategoria']);
              echo $objCategoria->updatetData(); 
        break;

        case 'delete':
            $objCategoria->setId($_POST['id']);
            echo $objCategoria->deleteData();
        break;

        case 'showdata':
            echo $objCategoria->getData();
        break;
        case 'count':
            echo $objCategoria->countRegister();
        break;
}