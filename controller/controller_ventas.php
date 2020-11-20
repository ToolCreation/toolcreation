<?php
$operacion = $_POST['option'];
// $operacion = 'showCursoPayments';

//------------------[llamado a los archivos]------------------------
//MVC 
require('../model/mvc/payments.php');
//------------------[Creacion de las instancias de los patrones]------------------------
//intancia generaL para patron PATRON [mvv]
$venta = new MVCPayment();

switch($operacion)
    {
        case 'statuPayCurso':
          $venta->setCurso($_POST['curso']);
          $venta->setEstudiante($_POST['estudiante']); 
          echo $venta->verificarEstadoVentaCurso();
        break;

        case 'showCursoPayments':
          //llamda a MVC o singleton
          $venta->setEstudiante($_POST['estudiante']);
          echo $venta->showCursosPayments();
        break;
     
}