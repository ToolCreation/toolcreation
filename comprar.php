
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
    <link rel="stylesheet" href="src/css/bootstrap.css">
    <link rel="stylesheet" href="src/css/stripe.css">
    <!-- <link rel="stylesheet" href="src/css/sweetalert2.min.css"> -->
    <style>
        .button-pay{
                width: 100% ;
                margin-top: 1rem;
                border:none;
                color: white;
                background: #f87c4b;
                padding: .8rem 3.5rem ;
                cursor: pointer;
                border-radius: 5px;
            }
        .content-spinner:not([hidden]){
                margin-top: 0;
                width: 100%;
                position: fixed;
                height: 100%;
                padding: 20px;
                background: rgba(32, 32, 32, 0.5);
                z-index: 1000;
            }
        #spinner:not([hidden]) {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                display: flex;
                justify-content: center;
                align-items: center;
            }

        #spinner::after {
                content: "";
                width: 80px;
                height: 80px;
                border: 2px solid #f3f3f3;
                border-top: 3px solid #f87c4b;
                border-radius: 100%;
                will-change: transform;
                animation: spin 1s infinite linear;
            }

        @keyframes spin {
                from {
                        transform: rotate(0deg);
                }
                to {
                        transform: rotate(360deg);
                }
             }
    </style>
</head>
<body>
    <div hidden class="content-spinner">
            <div hidden id="spinner"></div>
        </div>
    <div class="content-principal">
        
            <buton type="button" class="btn-back"  style="display: block; margin-left: 3%; "><i class="fas fa-arrow-left" onclick="window.history.back();"></i></buton>
            <div class="content-purchase" >
                <div class="content-section-pay">
                    
                <h3>Pagar</h3>
                    <div class="credit-card">
                            <form action="" method="" id="payment-form">
                                <input type="text" id="nombreTItualar" name ="nombreTItualar" placeholder ="Nombre completo" class="input-text input-100 "  >
                                <input type="email" id="correoTitular" name ="correoTitular" placeholder ="correo" class="input-text input-100"  >
                                <label for="" class="mt-2">
                                    Tajeta de credido o debito
                                </label>
                                <div id="card-element" class="form-control mt-1 ">

                                </div>

                                <div id="card-errors" class="mt-2 mb-2" role="alert"></div>
                                <input type="submit" class="button-pay " id ="btnPayment"  value="Realizar Pago">
                            </form>
                    </div>

                    <div class="detailPedido">
                        <h3>Detalles del pedido</h3>
                        <div class="content-detail">  
                            <img id="loadImgCurso" alt="">
                            <p id="loadNombreCurso"></p>
                            <p id="loadPrecio"></p>
                        </div>
                    </div>

                </div>
                <div class="resumen-pago">
                    <div class="content-resumen">
                        <h3>Resumen</h3>
                        <div class="descripcion-precio">
                            <p>Total: </p>
                            <p id="loadPrecioCurso"></p>
                        </div>
                        <hr/>
                        <p>ToolCreation está obligado por ley a recaudar los impuestos sobre las transacciones de las compras realizadas en determinadas jurisdicciones fiscales.</p>
                        <!-- <button type="button" class="button-pay"> Realizar Pago</button> -->
                    </div>
                </div>
            </div>

    
    </div>
    <script src="https://js.stripe.com/v3/"></script>
    <script src="src/js/axios.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="src/js/charge.js"></script>
     
</body>
</html>