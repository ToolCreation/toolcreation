const ENDPOINT_LOG_ALUMNO   = "controller/controller_login.php";
const ENDPOINT_LOG_PROFESOR = "controller/controller_instructor.php";
const ENDPOINT_CURSOS = "controller/controller_curso.php";
const ENDPOINT_CATEGORIAS = "controller/controller_categoria.php";
const ENDPOINT_VENTAS = "controller/controller_ventas.php";

var d = document;

//CLIENTE.alertMessage("myalert alert-infoDanger","Archivo no valido","fas fa-exclamation bg-infoDanger");
//CLIENTE.alertMessage("myalert alert-correct","Se ha eliminado el estado exitosamente","fas fa-check bg-correct")
// CLIENTE.alertMessage("myalert alert-fail","El estado no pudo eliminarce" + response.data, "fas fa-times bg-fail");



const CLIENTE = new Vue({
  el: ".content-principal",
  data: {
    alertgeneral: null,
    messagealert: null,
    alerticon: null,
    displayAlert: 'display:none',
    logeado: false,
    yearAccount: null,
    monthAccount: null,
    dayAccount: null,
    imgAccount: null,
    imgInfo:null,
    buttonEnable: null,
    showModal: 'display:none',
    textButtonProfesor: 'Quiero ser instructor',
    cursosRecent: [],
    categorias:[],
    curdoDetailList: [],
    myCursosDetail: [],
    idCategory: 0,
  
  
  },
  created: function(){
    this.cargarMisCursos();
  },
  mounted: function() {
   
    this.loadCursos();
    this.loadCategorias();
    this.comprobarLogeo();
   
    if(this.logeado){
      this.setValoresAcount();
    }

    
 },
  methods: {
    inputSearchNameCurso: function(){
      let buscar = d.getElementById("searchCurseName").value;
      d.querySelectorAll('.card-curso-result').forEach(function(e){
          if(e.textContent.toLowerCase().includes(buscar)){
            e.style.display = ''
          } else{
           e.style.display = 'none'
            CLIENTE.alertMessage("myalert alert-infoDanger","No se ha encontrado cursos con ese nombre","fas fa-exclamation bg-infoDanger");
          }
         
        });    
     },
    getDateHuman:function (dateAPI){
      return moment(dateAPI, "YYYYMMDD").fromNow();
    },
    comprobarLogeo: function(){
        let statusSesionUser =  sessionStorage.getItem('status');
         if(statusSesionUser == 'activo'){
             this.logeado = true;
         }
    },
    loadCategorias: function() {
      let formdata = new FormData();
      formdata.append("option", "showdata")
      axios.post(ENDPOINT_CATEGORIAS, formdata)
          .then(function (response) {
              // console.log(response);
              //monedas es el arreglo de  JS 
              CLIENTE.categorias = response.data.categoria;
          })
    },
    loadCursos: function(){
      let combos = new FormData();
      combos.append('option','showDataCursos')
          axios.post(ENDPOINT_CURSOS, combos).then(function (response) {
              // console.log(response);
              CLIENTE.cursosRecent = response.data.cursoList;
      })
    },
    resultCursosForCategory: function(categoria){
      CLIENTE.idCategory = categoria.id;
      let parameter = new FormData();
      parameter.append('option','showFilterCurseCatefory')
      parameter.append('idCategory', CLIENTE.idCategory)
          axios.post(ENDPOINT_CURSOS, parameter).then(function (response) {
              // console.log(response);
              CLIENTE.cursosRecent = response.data.cursoList;
      })
    },
    cargarMisCursos(){
      let getData = new FormData();
      getData.append('option','showCursoPayments')
      getData.append('estudiante', sessionStorage.getItem('estudiante'))
      axios.post(ENDPOINT_VENTAS, getData).then(function (response) {
        console.log(response);
        CLIENTE.myCursosDetail = response.data.cursoListPayments;
        })
    },
    setValoresAcount: function(){
        //Extraccion de valores
        let fechaNacimiento = d.getElementById('fechaNacimiento').value;
        let imgUser = d.getElementById('imagenUsuario').value;
        let sexoUser = d.getElementById('sexoUser').value;
        let tefofonoUser = d.getElementById('telefonoUser').value;
        // console.log(tefofonoUser);
        let splitFecha = fechaNacimiento.split('-');
        document.getElementById('year').value = splitFecha[0];
        document.getElementById('month').value = splitFecha[1];
        document.getElementById('day').value = splitFecha[2];

        //coloacion de valores  elementos del perfil
        let combo = document.getElementById("genero");
        if(sexoUser == 'Prefiero no decirlo'){
          combo.selectedIndex = 3;
        }else if(sexoUser == 'Masculino' || sexoUser == 'M'){
          combo.selectedIndex = 1;
        }else if(sexoUser == 'Femenino' || sexoUser == 'F'){
          combo.selectedIndex = 2;
        }
        //ciolocacion de imagen  de usuario
        (imgUser === "")  ? this.imgAccount = 'src/img/persona.svg' :   this.imgAccount = 'src/img/perfilUsers/'+imgUser;
          
        //colocacion de telefono
        (tefofonoUser === "" ||  tefofonoUser === "null") ? document.getElementById('telefono').value = "" : document.getElementById('telefono').value = tefofonoUser;
          
    },
    updateInfoPersonal: function (){
      CLIENTE.yearAccount = d.getElementById('year').value;
      CLIENTE.monthAccount = d.getElementById('month').value;
      CLIENTE.dayAccount = d.getElementById('day').value;
      let comboGenero = d.getElementById('genero');
      let selectedGenero = comboGenero.options[comboGenero.selectedIndex].text;
      let img = document.getElementById("customFile").files[0];
      let datos = {
          imgPerfil: img,
          nombre: d.getElementById('insert-nombre').value,
          AP: d.getElementById('insert-primerApellido').value,
          AM: d.getElementById('insert-segundoApellido').value,
          edad: d.getElementById('age').value,
          dateOfBirth: this.yearAccount+'-'+this.monthAccount+'-'+this.dayAccount,
          sexo: selectedGenero,
          telefono: d.getElementById('telefono').value,
          idUser: d.getElementById('idUser').value
      }
      if(CLIENTE.camposVaciosConfigPersonal(datos)){
          CLIENTE.alertMessage("myalert alert-infoDanger","Existen campos vacios, intente de nuevo","fas fa-exclamation bg-infoDanger");

      }else{
        let formdata = CLIENTE.toFormData(datos,'accountConfig')
        axios.post(ENDPOINT_LOG_ALUMNO, formdata).then(function (response) {
          console.log(response);
          if (response.data == 1) {
            console.log(response.data);
            CLIENTE.alertMessage("myalert alert-correct","Se han actualizado su perfil","fas fa-check bg-correct");
            setTimeout(function () {
                  location.reload();
              }, 2800);
          } else if (response.data.msj == "errorFile"){
            CLIENTE.alertMessage(
              "myalert alert-fail",
               response.data.detailError,
              "fas fa-times bg-fail"
            );
          } else {
              CLIENTE.alertMessage(
              "myalert alert-fail",
              "Hubo un error al  actualizar los datos" + response.data,
              "fas fa-times bg-fail"
            );
          }
        });
      }
    },
    updateInfoAccount: function(){
       let datos = {
            email: d.getElementById('insert-email').value,
            user: d.getElementById('insert-usuario').value,
            pass: d.getElementById('insert-newPass').value,
            idUser: d.getElementById('idUser').value
          }
      console.log(datos.pass);
      if(CLIENTE.camposVaciosConfigAccount(datos)){
        CLIENTE.alertMessage("myalert alert-infoDanger","Existen campos vacios, intente de nuevo","fas fa-exclamation bg-infoDanger");

      }else{
         let formdata = CLIENTE.toFormData(datos,'accountConfigLog')
         axios.post(ENDPOINT_LOG_ALUMNO, formdata).then(function (response) {
            console.log(response);
            if (response.data) {
              console.log(response.data);
              CLIENTE.alertMessage("myalert alert-correct","Se han actualizado su perfil","fas fa-check bg-correct");
              setTimeout(function () {
                    location.reload();
                }, 2800);
            } else {
                CLIENTE.alertMessage(
                "myalert alert-fail",
                "Hubo un error al  actualizar los datos" + response.data,
                "fas fa-times bg-fail"
              );
            }
         });
      }
    },
    closeSesionRol: () => {
      let formdata = new FormData();
      
      formdata.append("option", "destroySesion");
      axios.post(ENDPOINT_LOG_ALUMNO, formdata).then(function (response) {
        console.log(response);
        if (response.data == "1") {
          sessionStorage.clear();
          window.location.href = "index.php";
        } else {
            CLIENTE.alertMessage(
            "myalert alert-fail",
            "Hubo un error al  cerrar sesion" + response.data,
            "fas fa-times bg-fail"
          );
        }
      });
    },
    validarSoloNumeros: function(e){
      let key = window.event ? e.which : e.keyCode;
      if(key < 48 || key > 57){
          e.preventDefault();
      }
   },
   comprobarEmail: function (){
    let comprobar = new FormData();
    comprobar.append("option","comprobarEmail");
    comprobar.append("email",d.getElementById('insert-email').value);
    axios.post(ENDPOINT_LOG_ALUMNO,comprobar).then(response =>{
          if(response.data.msj == "Existe"){
            CLIENTE.buttonEnable = true;
            CLIENTE.alertMessage("myalert alert-infoDanger","El email ya esta en uso ","fas fa-exclamation bg-infoDanger");
              setTimeout(function () {
                  CLIENTE.limpiarAlertas();
              }, 3500);
          }else{
            CLIENTE.buttonEnable = null;
          }
         
    });
   
 },
 comprobarUser: function (){
  let comprobar = new FormData();
  comprobar.append("option","comprobarUsuario");
  comprobar.append("user",d.getElementById('insert-usuario').value);
  axios.post(ENDPOINT_LOG_ALUMNO,comprobar).then(response =>{
        if(response.data.msj == "Existe"){
          CLIENTE.buttonEnable = true;
          CLIENTE.alertMessage("myalert alert-infoDanger","El usuario ya esta en uso " ,"fas fa-exclamation bg-infoDanger");
            setTimeout(function () {
                CLIENTE.limpiarAlertas();
            }, 3500);
        }else{
          CLIENTE.buttonEnable = null;
        }
       
  });
 
},
ingresarInstructor: function(){
  let ingresar = new FormData();
  ingresar.append("option","auntentificaion");
  ingresar.append("idUsuario",d.getElementById('idUser').value);
  axios.post(ENDPOINT_LOG_PROFESOR,ingresar).then(response =>{
    console.log(response.data);
    let dataSesionProfesor = response.data;
    if( dataSesionProfesor.stateFunction == "RegistradoYLogeado" ||
        dataSesionProfesor.stateFunction == "Logeado"){
           sessionStorage.setItem('idProfesor', dataSesionProfesor.idProfesor);
           sessionStorage.setItem('gradoConocimiento', dataSesionProfesor.gradoConocimiento);
           sessionStorage.setItem('estancia', dataSesionProfesor.estancia);
           sessionStorage.setItem('success', dataSesionProfesor.success);
           sessionStorage.setItem('stateFunction', dataSesionProfesor.stateFunction);
        }

    if(dataSesionProfesor.stateFunction == "RegistradoYLogeado"){
         CLIENTE.showModal = "display:flex";
        setTimeout(function () {
          window.location.href = "view/profesor/index.php";
        }, 5500);
    }else{
      CLIENTE.textButtonProfesor = 'Ingresando...';
       setTimeout(function () {
            window.location.href = "view/profesor/index.php";
        }, 1500);
    }
    
    

});
},
previewImage: function(e){
       CLIENTE.imgInfo  = document.getElementById("customFile").files[0];
      console.log(CLIENTE.imgInfo )
      if( CLIENTE.imgInfo.type == "image/jpeg" ||  CLIENTE.imgInfo.type == "image/png" ||  CLIENTE.imgInfo.type == "image/jpg"){
          let filereader = new FileReader();
          filereader.readAsDataURL(e.target.files[0])
          filereader.onload = (e) => {
              CLIENTE.imgAccount = e.target.result
          }
      }else{
      CLIENTE.alertMessage("myalert alert-infoDanger","Archivo no valido","fas fa-exclamation bg-infoDanger");
        CLIENTE.imgAccount = 'src/img/noImagen.svg';
      }
   },
   camposVaciosConfigPersonal: function(caja){
    if( caja.nombre == 0 || caja.AP == 0  || caja.AM == 0  || caja.edad == 0  ||
       CLIENTE.yearAccount == 0  || CLIENTE.monthAccount == 0 ||  CLIENTE.dayAccount == 0 || 
       caja.sexo == 'Seleccione su sexo' || caja.idUser == 0){
      return true;
      }
      return false
   },
   camposVaciosConfigAccount: function(caja){
    if( caja.email == 0 || caja.user == 0){
      return true;
      }
      return false
   },
   limpiarAlertas: function (){
      CLIENTE.alertgeneral = null;
      CLIENTE.messagealert = null; 
      CLIENTE.alerticon = null;
      CLIENTE.displayAlert ="display:none";
    },
    alertMessage: function (classe, message, iconName) {
      CLIENTE.displayAlert ="";
      CLIENTE.alertgeneral = classe;
      CLIENTE.messagealert = message;
      CLIENTE.alerticon = iconName;
      setTimeout(function () {
        CLIENTE.limpiarAlertas();
    }, 3000);
    
  },
  toFormData: (obj, option) => {
    let fd = new FormData();
    fd.append('option', option);
      for (let i in obj) {
        fd.append(i, obj[i]);
      }
    return fd;
  },
  irdetallecurso: function(id){
    let valor = 'idcurso='+id; 
    window.location.href = 'detailcurso.php?'+valor;
  },
  aprender: function(id){
    localStorage.setItem('idCursoLearn', id)
    window.location.href = 'aprendizaje.html';
  }
  
  
  },
  
});
