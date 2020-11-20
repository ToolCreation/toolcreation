<?php
require_once('../model/stripe/init.php');
require('../model/mvc/payments.php');
\Stripe\Stripe::setApiKey('sk_test_51HmibpGBwRAOgcg0K24iVvPlQyR9FC5T3ncmXgDDzg5HiQYq8WwybJHo30nPXOzKuHIcAUyE2FwPEPDXo5bfYsH300YeZKtzCR');
$pay = new MVCPayment();
if(!empty($_POST['stripeToken'])){
  $nombre = $_POST['nombreTItualar'];
  $email = $_POST['correoTitular'];
  $monto = $_POST['monto'];
  $moneda = $_POST['moneda'];
  $estudiante = $_POST['idEstudiante'];
  $token = $_POST['stripeToken'];
  $nombreCurso = $_POST['nombreCurso'];
  $idCurso = $_POST['idCurso'];

  //precios Mexicanos 
  if($monto >= 100){
    $nuevoMOnto = $monto * 100;
  }else if ($monto >= 1000){
    $nuevoMOnto = $monto * 1000;
  }else{
    $nuevoMOnto = $monto * 100;
  }

  $charge = \Stripe\Charge::create(array(
    "amount" => $nuevoMOnto,
    "currency" => $moneda,
    "description" => "Pago de $nombreCurso",
    "source" => $token
  ));
  
  $chargeJson = $charge->jsonSerialize(); 
  if($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1){
    if($chargeJson['status'] == 'succeeded'){
      $pay->setCurso($idCurso);
      $pay->setEstudiante($estudiante);
      $pay->setTransaction($chargeJson['id']);
      $pay->setMoneda($chargeJson['currency']);
      $mensaje = $pay->realizar();
    }else{
      $mensaje = "Su pago falló";
    }
  }else{
    $mensaje = "Ha ocurrido un error con la transaccion, cumuniquese con sus banco";
  }
}else{
  $mensaje = "No se ha enviado el token";
}


echo json_encode(array(
  "mensaje" => $mensaje
));
// echo "<pre>", print_r($charge), "</pre>";


// if(!empty($_POST['stripeToken'])){
//   $json_str = file_get_contents('php://input');
//   $json_obj = json_decode($json_str, TRUE);
//   $token =  $_POST['stripeToken'];

//   try{
//     $charge = \Stripe\Charge::create(array( 
//       'card' => $token ,
//       'amount'   =>  $json_obj['amount'], 
//       'currency' =>$json_obj['currency'], 
//       'description' => $json_obj['description'] 
//     )); 

//   }catch( Exception $e){
//     $api_error = $e->getMessage();
//     $mensaje =  json_encode(array(
//         "mesaje" =>$api_error
//       ));
//   }

//   if(empty($api_error) && $charge){
//     $chargeJson = $charge->jsonSerialize(); 
//     if($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1){ 
//       $transactionID = $chargeJson['balance_transaction']; 
//       $paidAmount = $chargeJson['amount']; 
//       $paidCurrency = $chargeJson['currency']; 
//       $payment_status = $chargeJson['status']; 
//        //ingreso de los datos a la base de datos
//       if($payment_status  == 'succeeded'){
//         $mensaje =  json_encode(array(
//           "mesaje" => "Su pago ha sido exitoso"
//         ));
//       }else{
//         $mensaje =  json_encode(array(
//           "mesaje" => "Su pago ha fallado"
//         ));
//       }
//      }else{
//       $mensaje =  json_encode(array(
//         "mesaje" => "Hubo un error con la trasaccion cumuniquese a su banco"
//       ));
//      }
    
//   }else{
//     $mensaje =  json_encode(array(
//       "mesaje" => "Error en lo datos de la tarjeta $api_error"
//     ));
//   }
// }else{
//   $mensaje =  json_encode(array(
//     "mesaje" => "Erroren al enviar token"
//   ));
// }

// echo $mensaje;


