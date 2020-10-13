<?php
$operacion = $_POST['option'];
//------------------[llamado a los archivos]------------------------

//MVC 
require('../model/mvc/model_mvc_tipopromo.php');

//------------------[Creacion de las instancias de los patrones]------------------------
//intancia generaL para patron PATRON [mvv]
$objTipoPromo = new MVCTipoPromocion();

switch($operacion)
    {
        case 'insert':
            //llamada a SINGLETON O MVC
            $objTipoPromo->setNombreTipoPromocion($_POST['nombreTipoPromo']);
            echo $objTipoPromo->insertData();

        break;

        case 'update':
            //llamada a SINGLETON O MVC
              $objTipoPromo->setId($_POST['id']);
              $objTipoPromo->setNombreTipoPromocion($_POST['nombreTipoPromo']);
              echo $objTipoPromo->updatetData();
        break;

        case 'delete':
             //llamada a SINGLETON O MVC
            $objTipoPromo->setId($_POST['id']);
            echo $objTipoPromo->deleteData();
        break;

        case 'showdata':
            //llamda a MVC o singleton
            echo $objTipoPromo->getData();
        break;
        case 'count':
            //implmentacio de singleton y MVC
            echo $objTipoPromo->countRegister();
        break;
}