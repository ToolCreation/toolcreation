<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis cursos</title>
    <link rel="shortcut icon" href="src/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="src/css/normalize.css">
    <link rel="stylesheet" href="src/css/style.css">
    <link rel="stylesheet" href="src/icons/all.css">
    <link rel="stylesheet" href="src/css/bootstrap.css">
</head>
<body>
    <div class="content-principal" >
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
            
        </header>
        <section class="search-curso mb-3 ">
            <div class=" width-100"  >
                <div class="container-alert">
                    <div v-bind:class="alertgeneral" role="alert">
                        <p>{{messagealert}}</p>
                        <i v-bind:class="alerticon"></i>
                    </div>
                </div>
                <h2>Mis Cursos</h2>  
                <div class="content-card-result">
                    <div   v-for="curso in myCursosDetail " class=" card-curso-result" style="width: 31%;" >
                        <div class="header-curso-result">
                            <img v-bind:src="'src/img/bannerscursos/'+ curso.imagenCurso" alt="">
                        </div>
                        <div class="body-curso-result">
                            <h4>{{curso.nombreCurso}}</h4>
                            <span>{{curso.nameInstructor}}</span> <img v-bind:src="'./src/img/perfilUsers/'+ curso.imgPerfilIntructor"   alt="">
                            <button type="button" class="btn show-curso">Abrir</button>
                            <div class="container-bar-progress" >
                            <div class="progress-bar" v-bind:style="'width:'+ curso.porcentaje+'%;'"></div>
                            </div><span class="mt-3">{{curso.porcentaje}} %</span>
                        </div> 
                    </div> 
                </div>
                
            </div>
        </section>
            
       
        <?php 
            require('./sections/footer.php')
        ?>
        
    </div>

     <script src="src/js/axios.min.js"></script>
     <script src="src/js/vue.js"></script>
     <!--<script src="src/plugins/moment-with-locales.min.js"></script> -->
     <script src="src/js/cliente_plataform.js"></script>
     <script src="src/js/menu_principal.js"></script>
     <script src="src/js/dropdown.js"></script>
     <script src="src/js/jquery-3.5.1.min.js"></script>
</body>
</html>