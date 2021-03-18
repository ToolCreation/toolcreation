<?php 
 
    $hash =  password_hash('admin1', PASSWORD_DEFAULT, ['cost'=>10]);
    echo $hash;
    echo '<br>';
    if(!password_verify('admin1', $hash)){
        echo "Contraseña incorrecta";
    }else{
        echo "Contraseña correcta";
    }
?>