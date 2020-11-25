var contentLoad = document.querySelector(".content-spinner");
var spinner = document.getElementById("spinner");
function cargarInforCurso(){
  document.getElementById('loadNombreCurso').innerText = `${localStorage.getItem('nameCurso')}`;
  document.getElementById('loadPrecio').innerText = `${localStorage.getItem('precio')} ${localStorage.getItem('moneda')} $`;
  document.getElementById('loadPrecioCurso').innerText = `${localStorage.getItem('precio')} ${localStorage.getItem('moneda')} $`;
  document.getElementById('loadImgCurso').setAttribute('src', `src/img/bannerscursos/${localStorage.getItem('imgCurso')}`);
  document.getElementById('nombreTItualar').value = `${sessionStorage.getItem('nombre')} ${sessionStorage.getItem('aPaterno')} ${sessionStorage.getItem('aMaterno')} ` ;
  document.getElementById('correoTitular').value = sessionStorage.getItem('email');
}

cargarInforCurso();

// Create a Stripe client.
var stripe = Stripe('pk_test_51HmibpGBwRAOgcg084AMLoLbnd2KKs3kMqqa84tbcgWfXxbkIjWLuBF5igK3YK8WfTdIuRKHLZpcFDkkgzRzM39t00qDy5tX7g');

// Create an instance of Elements.
var elements = stripe.elements();

// Custom styling can be passed to options when creating an Element.
// (Note that this demo uses a wider set of styles than the guide below.)
var style = {
  base: {
    color: '#32325d',
    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
    fontSmoothing: 'antialiased',
    fontSize: '16px',
    '::placeholder': {
      color: '#aab7c4'
    }
  },
  invalid: {
    color: '#fa755a',
    iconColor: '#fa755a'
  }
};

var card = elements.create('card', {style: style});

// Add an instance of the card Element into the `card-element` <div>.
card.mount('#card-element');

// Handle real-time validation errors from the card Element.
card.addEventListener('change', function(event) {
  var displayError = document.getElementById('card-errors');
  if (event.error) {
    displayError.textContent = event.error.message;
  } else {
    displayError.textContent = '';
  }
});

// Handle form submission.
var form = document.getElementById('payment-form');
form.addEventListener('submit', function(event) {
  event.preventDefault();
  console.log('entre');
  stripe.createToken(card).then(function(result) {
    if (result.error) {
      // Inform the user if there was an error.
      var errorElement = document.getElementById('card-errors');
      errorElement.textContent = result.error.message;
    } else {
      // Send the token to your server.
      stripeTokenHandler(result.token);
    }
  });
});

// Submit the form with the token ID.
function stripeTokenHandler(token) {
  mostrarSpinner();
  // Insert the token ID into the form so it gets submitted to the server
  var form = document.getElementById('payment-form');
  var hiddenInput = document.createElement('input');
  hiddenInput.setAttribute('type', 'hidden');
  hiddenInput.setAttribute('id', 'stripeToken');
  hiddenInput.setAttribute('value', token.id);
  form.appendChild(hiddenInput);
  let data = {
    stripeToken:document.getElementById('stripeToken').value,
    nombreTItualar:  `${sessionStorage.getItem('nombre')} ${sessionStorage.getItem('aPaterno')} ${sessionStorage.getItem('aMaterno')} `,
    correoTitular: sessionStorage.getItem('email'),
    monto: localStorage.getItem('precio'),
    moneda:  localStorage.getItem('moneda'),
    idEstudiante:  sessionStorage.getItem('estudiante'),
    nombreCurso: localStorage.getItem('nameCurso'),
    idCurso: localStorage.getItem('idCursoPay'),
  }
  if(validarDatosVacios(data)){
    ocualtarSpinner();
    alertNotification("Campos vacios", "Todos los campos son obligatorios", "info", 2000);
  }else{
    let formdata =  formDataAppend(data);
    axios.post("payments/charge.php", formdata)
        .then(function (response) {
            console.log(response.data);
            if(response.data.mensaje){
              setTimeout(() => {
                ocualtarSpinner(); 
                alertNotification("Exito", `Pago Exitoso`, "success", 2000);
              }, 2000);
              setTimeout(() => {
                localStorage.clear();
                window.location.href = "miscursos.php";
              }, 5000);
            }else{
              ocualtarSpinner();
              alertNotification("Error", `${response.data.mensaje}`, "error", 2000)
            }    
    });
  }
  
}

function formDataAppend (obj){
  let fd = new FormData();
  // fd.append('option', option);
    for (let i in obj) {
      fd.append(i, obj[i]);
    }
  return fd;
}

function alertNotification(title, text, icon, timer) {
  swal({ title, text, icon, timer })
}

function mostrarSpinner() {
  contentLoad.removeAttribute("hidden");
  spinner.removeAttribute("hidden");
}

function ocualtarSpinner() {
  contentLoad.setAttribute("hidden", "");
  spinner.setAttribute("hidden", "");
}

function validarDatosVacios(data){
  if(data.stripeToken == 0 || data.nombreTItualar == 0 || data.correoTitular == 0 ||
    data.monto.length == 0 || data.moneda.length == 0 || data.idEstudiante == 0 ||
    data.nombreCurso == 0 || data.idCurso == 0){
      return true;
    }
    return false;
}