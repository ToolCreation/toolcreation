const ENDPOINT_LOG_ALUMNO   = "controller/controller_login.php";
const ENDPOINT_CURSOS = "controller/controller_data_combos.php";
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
    curdoDetailList: [],
    temasList: [],
    title: "Hola",
    statusVentaCurso :''
  },
  mounted: function() {
    this.comprobarLogeo();
    this.cargarCursoDetail();
    this.loadStatusVentaCurso()
    this.loadTemas();

 },
  methods: {
    getDateHuman:function (dateAPI){
      return moment(dateAPI, "YYYYMMDD").fromNow();
    },
    comprobarLogeo: function(){
      let statusSesionUser =  sessionStorage.getItem('status');
      if(statusSesionUser == 'activo'){
          this.logeado = true;
      }
    },
    cargarCursoDetail: function(){
        d.getElementById("idCurso-detail").value;
        let getData = new FormData();
        getData.append('option','instanciarCurso')
        getData.append('IDCURSO',d.getElementById("idCurso-detail").value)
        axios.post(ENDPOINT_CURSOS, getData).then(function (response) {
          console.log(response);
          CLIENTE.curdoDetailList = response.data.cursoDetail;
          })
        
      },
    loadTemas: function(){
      d.getElementById("idCurso-detail").value;
      let getData = new FormData();
      getData.append('option','showdata')
      getData.append('IDCURSO',d.getElementById("idCurso-detail").value)
      axios.post('controller/controller_tema.php', getData).then(function (response) {
        console.log(response);
        CLIENTE.temasList = response.data.temas;
      })  
    },
    loadData: function(){
       console.log(this.curdoDetailList);
    },
    loadStatusVentaCurso: function(){
      d.getElementById("idCurso-detail").value;
      let getData = new FormData();
      getData.append('option','statuPayCurso')
      getData.append('curso',d.getElementById("idCurso-detail").value);
      getData.append('estudiante', sessionStorage.getItem('estudiante'));
      axios.post(ENDPOINT_VENTAS, getData).then(function (response) {
        console.log(response);
        CLIENTE.statusVentaCurso = response.data;
      }) 
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
 
  // irdetallecurso: function(id){
  //   let valor = 'idcurso='+id; 
  //   window.location.href = 'detailcurso.php?'+valor;
  // },
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
        },
  gotoPay: function(curso){
    localStorage.setItem('idCursoPay', curso.id);
    localStorage.setItem('moneda',curso.moneda)
    localStorage.setItem('precio',curso.precio)
    localStorage.setItem('nameCurso', curso.nombre);
    localStorage.setItem('imgCurso', curso.imgCurso)

    window.location.href = `comprar.php`;

  },
  gotoMyCurse: function(){
    window.location.href = `miscursos.php`;
  }
  },
  
  
});
