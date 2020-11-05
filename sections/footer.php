<footer>
            <div class="footer-container">
                <div class="footer-section">
                    <img src="src/img/Logo-ToolCreatiion.png" width="150" height="90" alt="">
                </div>
                <div class="footer-section">
                   <h3>Contenido</h3>
                   <ul>
                      <li><a href="#">Cursos</a></li>
                      <li><a href="#">Especialidades</a></li>
                      <li></li>

                      <!-- <li><a class="btn-iamProfesor" href="#"> Quiero ser intructor</a></li> -->
                   </ul>
                </div>
                <div class="footer-section">
                   <h3>Cursos</h3>
                   <ul>
                      <li><a href="#">WEB</a></li>
                      <li><a href="#">Móvil</a></li>
                      <li><a href="#">Frontend</a></li>
                      <li><a href="#">BackEnd</a></li>
                   </ul>
                </div>
                <div class="footer-section">
                   <h3>Cuenta</h3>
                   <ul>
                      <li  v-if="!logeado"><a href="./public/login.html">Iniciar Sesion</a></li>
                      <li  v-if="!logeado"><a href="./public/register.html">Crear Cuenta</a></li>
                      <li><a href="./politicas.php">Politicas</a></li>
                      <li><a href="./terminos.php">Termino de uso</a></li>
                   </ul>
                </div>
                <div class="footer-section">
                   <h3>Redes sociales</h3>
                   <ul class="social-footer">
                      <li><a href="#"><i class="fab fa-facebook"></i></a></li>
                      <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                      <li><a href="#"><i class="fab fa-github"></i></a></li>
                      <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                   </ul>
                </div>
                <div class="footer-section">
                   <h3>Sellos de confianza</h3>
                   <ul class="social-footer">
                      <li><img src="./src/img/norton-secured.png" alt="" width="100"></li>
                      <li><img src="./src/img/Sello_comercio_electronico.png"  width="100" alt=""></li>
                   </ul>
                </div>
             </div>
        </footer>