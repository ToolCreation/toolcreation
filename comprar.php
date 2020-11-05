<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagar curso</title>
    <link rel="shortcut icon" href="src/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="src/css/normalize.css">
    <link rel="stylesheet" href="src/css/style.css">
    <link rel="stylesheet" href="src/icons/all.css">
</head>
<body>
    <div class="content-principal">
        <header class="header-principal">
            <div class="content-logo-principal">      
                <a href="index.php"><img src="src/img/Logo-ToolCreatiion2.png" width="110" height="70" alt=""></a> 
            </div>
            <div class="barra-busqueda-principal">
                <input type="text" placeholder="Buscar">
                <button class="btn-search"><i class="fas fa-search"></i></button>
            </div>

            <?php require('sections/content-menu.php');?>
            <?php require('sections/dropdown.php'); ?>
    
              <button id="btn-menu-principal" class="btn-menu-principal"><i class="fas fa-bars"></i></button> 
              <div><input type="text" id="idUsuario" style="display: none" value="<?php echo  $_SESSION['status']  ?>" ></div>
        </header>

        <div class="content-purchase">
            <div class="content-section-pay">
               <h3>Pagar</h3>
                <div class="credit-card">
                  
                        <input type="text" class="input-text input-100" placeholder ="Nombre en la tarjeta">
                        <input type="number" class="input-text input-100"  placeholder ="Número en la tarjeta" maxlenght="16">
                        <div class="width-100 my-form-row" >
                            <select name="" id="" class="input-select input-33">
                                <option value="0">MM</option>
                                <option value="01">01</option>
                                <option value="02">02</option>
                                <option value="03">03</option>
                                <option value="04">04</option>
                                <option value="05">05</option>
                                <option value="06">06</option>
                                <option value="07">07</option>
                                <option value="08">08</option>
                                <option value="09">09</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>

                            <select name="" id="" class="input-select input-33">
                                <option value="2021">2021</option>
                                <option value="2022">2022</option>
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                                <option value="2026">2026</option>
                                <option value="2027">2027</option>
                                <option value="2028">2028</option>
                                <option value="2029">2029</option>
                                <option value="2030">2030</option>
                                <option value="2031">2031</option>
                                <option value="2032">2032</option>
                                <option value="2033">2033</option>
                                <option value="2034">2034</option>
                                <option value="2035">2035</option>
                                <option value="2036">2036</option>
                                <option value="2037">2037</option>
                                <option value="2038">2038</option>
                                <option value="2039">2039</option>
                                <option value="2040">2040</option>
                            </select>

                            <input type="number" class="input-number input-33" style="margin-right: 0" name="" id="" placeholder="CVC">
                        </div>
                </div>

                <div class="detailPedido">
                    <h3>Detalles del pedido</h3>
                    <div class="content-detail">  
                        <img src="src/img/bannerscursos/Angular.png" alt="">
                        <p>Curso de Angular</p>
                        <p>279 MXN$</p>
                    </div>
                </div>

            </div>
            <div class="resumen-pago">
                <div class="content-resumen">
                    <h3>Resumen</h3>
                    <div class="descripcion-precio">
                        <p>Total: </p>
                        <p>279 MXN$</p>
                    </div>
                    <hr/>
                    <p>ToolCreation está obligado por ley a recaudar los impuestos sobre las transacciones de las compras realizadas en determinadas jurisdicciones fiscales.</p>
                    <button type="button" class="button-pay"> Realizar Pago</button>
                </div>
            </div>
        </div>

        <?php 
            require('./sections/footer.php')
        ?>
    </div>
   
     <script src="src/js/axios.min.js"></script>
     <script src="src/js/vue.js"></script>
     <!-- <script src="https://momentjs.com/downloads/moment-with-locales.min.js"></script> -->
     <script src="src/js/cliente_plataform.js"></script>
     <script src="src/js/menu_principal.js"></script>
     <script src="src/js/dropdown.js"></script>
     <script src="src/js/jquery-3.5.1.min.js"></script>
</body>
</html>