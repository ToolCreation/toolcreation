const ENDPOINT_LOG_ALUMNO   = "controller/controller_login.php";
const ENDPOINT_PAY = "payments/charge.php";
const ENDPOINT_CURSOS = "controller/controller_curso.php";
var d = document;
const URLPAY = 'payments/charge.php';

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
    curdoDetailList: [],
    spk:"pk_test_51HmibpGBwRAOgcg084AMLoLbnd2KKs3kMqqa84tbcgWfXxbkIjWLuBF5igK3YK8WfTdIuRKHLZpcFDkkgzRzM39t00qDy5tX7g",
    stripe: null
  },
  created: function(){

  },
  mounted: function() {
    this.comprobarLogeo();
    this.cargarCursoDetail();
   
 },
  methods: {
    comprobarLogeo: function(){
        let statusSesionUser =  sessionStorage.getItem('status');
         if(statusSesionUser == 'activo'){
             this.logeado = true;
         }
    },
    cargarCursoDetail: function(){
      // console.log(localStorage.getItem('idCursoPay'));
      let getData = new FormData();
      getData.append('option','showDataCursosDetail')
      getData.append('IDCURSO', localStorage.getItem('idCursoPay'))
      axios.post(ENDPOINT_CURSOS, getData).then(function (response) {
        // console.log(response);
        CLIENTE.curdoDetailList = response.data.cursoDetail;
        })
      
    },
    closeSesionRol: () => {
      let formdata = new FormData();
      
      formdata.append("option", "destroySesion");
      axios.post(ENDPOINT_LOG_ALUMNO, formdata).then(function (response) {
        console.log(response);
        if (response.data) {
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
    pagar: function(){
      CLIENTE.stripe= Stripe('pk_test_51HmibpGBwRAOgcg084AMLoLbnd2KKs3kMqqa84tbcgWfXxbkIjWLuBF5igK3YK8WfTdIuRKHLZpcFDkkgzRzM39t00qDy5tX7g');
      let data = {
        number: document.getElementById('numberCard').value,
        cvc: document.getElementById('cvcCard').value,
        exp_month: document.getElementById('monthCard').value,
        exp_year: document.getElementById('yearCard').value
      }
      if(CLIENTE.validarCampos(data)){
        CLIENTE.alertMessage("myalert alert-infoDanger","Existen campos vacios" ,"fas fa-exclamation bg-infoDanger");
      }else{
        CLIENTE.stripe.createToken({
          number: document.getElementById('numberCard').value,
          cvc: document.getElementById('cvcCard').value,
          exp_month: document.getElementById('monthCard').value,
          exp_year: document.getElementById('yearCard').value
        },CLIENTE.stripePaymentMethodHandler);
      }
    },
    validarCampos(data){
      if(data.number == 0 || data.cvc == 0 || data.exp_month == 0 || data.exp_year == 0 ){
        return true;
      }
      return false;
    },
    stripePaymentMethodHandler: function(result){
      console.log('Entre a enviar los datos del pago')
          if (result.error) {
            CLIENTE.alertMessage(
              "myalert alert-fail",
              "Hubo un error " + result.error,
              "fas fa-times bg-fail"
            );
          } else {
            // Otherwise send paymentMethod.id to your server (see Step 4)
            fetch(URLPAY, {
              method: 'POST',
              headers: { 'Content-Type': 'application/json' },
              body: JSON.stringify({
                description: `Pago de curso ${localStorage.getItem('nameCurso')}`,
                currency: localStorage.getItem('moneda'),
                amount: localStorage.getItem('precio')
              })
            }).then(function(result) {
              // Handle server response (see Step 4)
              console.log(result.data)
              
            });
          }
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
  

  
  },
  
});
