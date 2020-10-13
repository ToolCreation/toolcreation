<?php
$operacion = $_POST['option'];
//------------------[llamado a los archivos]------------------------
//llamado a MVC
require('../model/mvc/model_mvc_plataforma.php');

//------------------[Creacion de las instancias de los patrones]------------------------

//INSTANCIA PARA PATRON [ MVC]
 $plataforma = new MVCPlataforma();

switch($operacion)
    {
        case 'insert':
           
            //instancia  a mvc
            $plataforma->setData($_POST['nombre'], $_POST['objetivos'], $_POST['metas'], $_POST['mision'] , $_POST['vision'], $_POST['descripcion']);
            echo $plataforma->insertData();

        break;

        case 'update':
             //instancia  a mvc a SINGLEON
             $plataforma->setId($_POST['id']);
             $plataforma->setData($_POST['nombre'], $_POST['objetivos'], $_POST['metas'], $_POST['mision'] , $_POST['vision'], $_POST['descripcion']);
             echo $plataforma->updatetData();

        break;

        case 'delete':
            
             //instancia  a mvc O SINGLETON
             $plataforma->setId($_POST['id']);
             echo $plataforma->deleteData();

        break;

        case 'showdata':
            //instancia  a singleton, mvc
            echo $plataforma->getData();
        break;
        case 'count':
            //implmentacio de singleton y MVC
            echo $plataforma->countRegister();
        break;

}