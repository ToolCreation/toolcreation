<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar cursos</title>
    <link rel="shortcut icon" href="src/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="src/css/normalize.css">
    <link rel="stylesheet" href="src/css/style.css">
    <link rel="stylesheet" href="src/icons/all.css">
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
              <div><input type="text" id="idUsuario" style="display: none" value="<?php echo  $_SESSION['status']  ?>" ></div>
        </header>

        <div class="search-curso">
            <div class="section-search">
                  <div class="header-search">
                    <h3>Busqueda de cursos</h3>
                  </div>
                  <div class="width-100">
                    <input type="text" class="input-text input-100" @keyup="inputSearchNameCurso" id="searchCurseName" placeholder="Busque por nombre de curso">
                  </div>

                  <!-- <div class="width-100" >
                     <select name="" class="input-select input-100" id="genero">
                        <option value="0">Seleccione una categoria</option>
                     </select>
                  </div> -->
                  <button type="button" class="button-tecnology" @click="loadCursos">Todos</button>
                
                  <button v-for="categoria in categorias " type="button" class="button-tecnology" @click="resultCursosForCategory(categoria)">{{categoria.nombreCategoria}}</button>
                  

                <button class="button-search-curso">Buscar</button>
            </div>
            
            <div class="section-result-cursos">
                <h2>Cursos</h2>
                     <div class="container-alert">
                        <div v-bind:class="alertgeneral" role="alert">
                                <p>{{messagealert}}</p>
                                <i v-bind:class="alerticon"></i>
                        </div>
                    </div>
                <div class="content-card-result">
                    <div   v-for="curso in cursosRecent " class=" card-curso-result" >
                        <div class="header-curso-result">
                            <img v-bind:src="'src/img/bannerscursos/'+ curso.imgCurso" alt="">
                        </div>
                        <div class="body-curso-result">
                            <h4>{{curso.nombre}}</h4>
                            <span>{{curso.instructor}}</span> <img v-bind:src="'./src/img/perfilUsers/'+ curso.imgUser"   alt="">
                            <button type="button" class="btn show-curso" @click="irdetallecurso(curso.id)">Ir a ver</button>
                        </div> 
                    </div> 
                </div>
                

            </div>
        </div>

        <?php 
            require('./sections/footer.php')
        ?>
    </div>
    <script src="https://js.stripe.com/v3/"></script>
     <script src="src/js/axios.min.js"></script>
     <script src="src/js/vue.js"></script>
     <!--<script src="src/plugins/moment-with-locales.min.js"></script> -->
     <script src="src/js/cliente_plataform.js"></script>
     <script src="src/js/menu_principal.js"></script>
     <script src="src/js/dropdown.js"></script>
     <script src="src/js/jquery-3.5.1.min.js"></script>
</body>
</html>