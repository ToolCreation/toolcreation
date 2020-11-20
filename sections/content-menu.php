<nav class="content-menu">
        <button  class="menu_close"><i class="fas fa-times"></i></button>
        <div class="option-menu">
                <a href="index.php">Inicio</a>
                <a href="cursos.php">Cursos</a>
        </div>
        
        <div class="botones-header"  v-if="!logeado">
            <a class="btn-register-log text-decoration-none" href="./public/register.html">Registrar</a>
            <a class="btn-access-log text-decoration-none" href="./public/login.html">ingresar</a>              
        </div>

</nav>