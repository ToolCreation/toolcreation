<?php
session_start();
?>

<?php
   $idCurso = $_GET['idcurso']
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de curso </title>
    <link rel="shortcut icon" href="src/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="src/css/normalize.css">
    <link rel="stylesheet" href="src/css/style.css">
    <link rel="stylesheet" href="src/icons/all.css">
</head>
<body>
<div class="content-principal" id="contenedor">
    <header class="header-principal">
        <div class="content-logo-principal">      
            <a href="index.php"><img src="src/img/Logo-ToolCreatiion2.png" width="110" height="70" alt=""></a> 
        </div>
        <!-- <div class="barra-busqueda-principal">
            <input type="text" placeholder="Buscar">
            <button class="btn-search"><i class="fas fa-search"></i></button>
        </div> -->

        <?php require('sections/content-menu.php');?>
        <?php require('sections/dropdown.php'); ?>
    
              <button id="btn-menu-principal" class="btn-menu-principal"><i class="fas fa-bars"></i></button> 
              <div><input type="text" id="idCurso-detail" style="display: none" value="<?php echo $idCurso ?>" ></div>
        </header>

           <?php require 'sections/detail_body.html' ?> 
        <?php
            require('./sections/footer.php');
        ?>
</div>
   
  
     <script src="src/js/axios.min.js"></script>
     <script src="src/js/vue.js"></script>
    <script src="src/plugins/moment-with-locales.min.js"></script>
     <script src="src/js/detail_curso.js"></script>
     <script src="src/js/menu_principal.js"></script>
     <script src="src/js/dropdown.js"></script>
     <script>
            let acc = document.getElementsByClassName("accordion");
            let i;

            for (i = 0; i < acc.length; i++) {
            acc[i].onclick = function() {
                this.classList.toggle("active");
                var panel = this.nextElementSibling;
                if (panel.style.maxHeight){
                panel.style.maxHeight = null;
                } else {
                panel.style.maxHeight = panel.scrollHeight + "px";
                } 
            }
            }
     </script>
</body>
</html>