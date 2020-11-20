<?php
session_start();
  if (isset($_SESSION['ingreso']) && $_SESSION['ingreso']=='YES' && $_SESSION['profesor'] == "YES") 
{?>


<?php
   $idCurso = $_GET['idcurso']
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cursos</title>
    <!--=========================================  Links CSS ======================================================-->
    <link rel="shortcut icon" href="../../src/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../../src/css/normalize.css">
    <link rel="stylesheet" href="../../src/css/style.css">
    <link rel="stylesheet" href="../../src/icons/all.css">
    <link rel="stylesheet" href="../../src/css/bootstrap.css">
   

</head>
<body>
<div class="contenedor active" id="contenedor">
        <?php   require '../includes/header.php'?>

         <?php $page = 'cursos'; require '../includes/sidebar.php'?>

        <main class="main">
            <input type="text" style="display:none" id="idCurso" value=" <?php echo $idCurso  ?>">
        <h2 class="title">Administre Curso</h2>
        <h2 class="title" >{{titleModule}}</h2>
        <div class="container-alert" v-bind:style="displayAlert">
                <div v-bind:class="alertgeneral" role="alert" style=" width: 60%;" >
                        <p>{{messagealert}}</p>
                        <i v-bind:class="alerticon"></i>
                </div>
        </div>
        
        <!-- Temas -->
         <?php
         require('./tema.html');
         ?>

        <!-- Fin temas  -->

        <h2 class="title mt-4" >Videos</h2>
        <!-- Videos -->
        <?php
         require('./videos.html');
         ?>
       <!-- Fin videos  -->

        
        <h2 class="title mt-4">Recurso para los videos (Links o archivos)</h2>
        <!-- Recurso -->
        <?php
         require('./recursos.html');
         ?>
       <!-- Recursos -->
    </main>  
</div>
     <!--============================================= SRC JS ==================================================-->
    
     <script src="../../src/js/axios.min.js"></script>
     <script src="../../src/js/vue.js"></script>
     <!--<script src="src/plugins/moment-with-locales.min.js"></script> -->
     <script src="../../src/js/crud_administrar_curso.js"></script>
     <script src="../../src/js/menu.js"></script>
     <script src="../../src/js/jquery-3.5.1.min.js"></script>
     <script src="../../src/plugins/bootstrap.js"></script>     
     <script>
       document.getElementById("searchRegister").onkeyup = function() {
            let buscar_= this.value.toLowerCase() ;
            document.querySelectorAll('.table tbody tr').forEach(function(e){
              let encontro_ =false;
              e.querySelectorAll('td').forEach(function(e){
                if (e.innerHTML.toLowerCase().indexOf(buscar_)>=0){
                  encontro_=true;
                }
              }); 
              if (encontro_){
                e.style.display = '';
              }else{
                e.style.display = 'none';
              }
            });              
        }
     </script>
    <script>
    // Add the following code if you want the name of the file appear on select
    // $(".custom-file-input").on("change", function() {
    // var fileName = $(this).val().split("\\").pop();
    // $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    // });
    </script>
    
     
 
</body>
</html>
<?php
  }
  else
  {
    header("location: ../../public/login.html");
  }
 ?>