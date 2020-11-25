const ENDPOINT_TEMAS = "../../controller/controller_tema.php";
const ENDPOINT_VIDEOS = "../../controller/controller_videos.php";
const ENDPOINT_RECURSOS = "../../controller/controller_recursos.php";
const ENDPOINT_LOG_PROFESOR = "../../controller/controller_login.php";
const ENPOINT_TIPOVIDEO = "../../controller/controller_tipovideo.php";
const ENPOINT_TIPORECURSO = "../../controller/controller_tiporecurso.php";

var contentLoad = document.querySelector(".content-spinner");
var spinner = document.getElementById("spinner");
var d = document;
const ADMIN_CURSO = new Vue({
    el: "#contenedor",
    data: {
        titleModule : 'Temas',
        listaTemas : [],
        listaVideos : [],
        listaRecursos : [],
        listaTipoVideo : [],
        listaTipoRecurso: [],
        alertgeneral: null,
        messagealert: null,
        alerticon: null,
        displayAlert: "display:none",
        idVideo:null,
        idRecurso: null,
        //paginacion de modulos
        totalRegistros: 0,
        totalVideos:0,
        totalRcursos:0,
        itemsPerPage:5,
        itemPerPageVideos: 5,
        itemPerPageRecursos: 5,
        paginas: 1,
        paginasVideos: 1,
        paginasRecursos: 1,
        paginaActual: 1,
        paginaActualVideos: 1,
        paginaActualRecursos: 1,
        siguiente: '',
        siguienteVideo: '',
        siguienteRecurso: '',
        anterior: '',
        anteriorVideo: '',
        anteriorRecurso: '',
        ocultarMostrarSiguiente: '',
        ocultarMostrarSiguienteVideo: '',
        ocultarMostrarSiguienteRecurso: '',
        ocultarMostrarAnterior:  '',  
        ocultarMostrarAnteriorVideo:  '',  
        ocultarMostrarAnteriorRecurso:  '',  
     },
     //CICLO DE  VIDA
    mounted: function() {
        this.cargarDatos();
        this.cargarListaDeVideos();
        this.cargarListaDeRecursos();
        this.cargarListaTipoVideo();
        this.cargarListaTipoRecurso();
        this.cargarTotalRegistros();
        this.cargarTotalRegistrosVideo();
        this.cargarTotalRegistrosRecursos();
        this.paginar(1);
        this.paginarVideos(1);
        this.paginarRecursos(1);
    },
    methods: {
       
        cargarTotalRegistros: function(){
     
            let formdata = new FormData();
            //APPEND ES DONDE AGREGAR EL NOMBRE Y VALOR
            formdata.append("option", "count")
            formdata.append("IDCURSO", d.getElementById("idCurso").value)
            //AXIOS TE PERMITE HACER UNA PETICION AL SERVIDOR O BD DE FORMA ASYCRONA
            axios.post(ENDPOINT_TEMAS, formdata)
                .then(function (response) {
                    // RESPUENTA A LA PETICION
                    // console.log(response);
                    ADMIN_CURSO.totalRegistros = response.data;
                    //SE CALCULA EL TOTAL DE PAGINAS
                    ADMIN_CURSO.paginas = Math.ceil(ADMIN_CURSO.totalRegistros / ADMIN_CURSO.itemsPerPage)
                    // console.log(ADMIN_CURSO.paginas);
                })
        },
        cargarTotalRegistrosVideo: function(){
     
            let formdata = new FormData();
            //APPEND ES DONDE AGREGAR EL NOMBRE Y VALOR
            formdata.append("option", "count")
            formdata.append("IDCURSO", d.getElementById("idCurso").value)
            //AXIOS TE PERMITE HACER UNA PETICION AL SERVIDOR O BD DE FORMA ASYCRONA
            axios.post(ENDPOINT_VIDEOS, formdata)
                .then(function (response) {
                    // RESPUENTA A LA PETICION
                    // console.log(response);
                    ADMIN_CURSO.totalVideos = response.data;
                    // console.log(`total Registros Videos ${ ADMIN_CURSO.totalVideos}`)
                    //SE CALCULA EL TOTAL DE PAGINAS
                    ADMIN_CURSO.paginasVideos = Math.ceil(ADMIN_CURSO.totalVideos / ADMIN_CURSO.itemPerPageVideos)
                    // console.log(`total de paginas videos ${ ADMIN_CURSO.paginasVideos}`);
                })
        },
        cargarTotalRegistrosRecursos: function(){
     
            let formdata = new FormData();
            //APPEND ES DONDE AGREGAR EL NOMBRE Y VALOR
            formdata.append("option", "count")
            formdata.append("IDCURSO", d.getElementById("idCurso").value)
            //AXIOS TE PERMITE HACER UNA PETICION AL SERVIDOR O BD DE FORMA ASYCRONA
            axios.post(ENDPOINT_RECURSOS, formdata)
                .then(function (response) {
                    // RESPUENTA A LA PETICION
                    // console.log(response);
                    ADMIN_CURSO.totalRcursos = response.data;
                    // console.log(`total Registros Recursos ${ ADMIN_CURSO.totalRcursos}`)
                    //SE CALCULA EL TOTAL DE PAGINAS
                    ADMIN_CURSO.paginasRecursos = Math.ceil(ADMIN_CURSO.totalRcursos / ADMIN_CURSO.itemPerPageRecursos)
                    // console.log(`total de paginas Recursos ${ ADMIN_CURSO.paginasRecursos}`);
                })
        },
        cargarDatos: function () {
            let formdata = new FormData();
            formdata.append("option", "showdata")
            formdata.append("IDCURSO", d.getElementById("idCurso").value)
            axios.post(ENDPOINT_TEMAS, formdata)
                .then(function (response) {
                    console.log(response);
                    //monedas es el arreglo de  JS 
                    ADMIN_CURSO.listaTemas = response.data.temas;
                })
        },
        cargarListaDeVideos: function () {
            let formdata = new FormData();
            formdata.append("option", "showdata")
            formdata.append("IDCURSO", d.getElementById("idCurso").value)
            axios.post(ENDPOINT_VIDEOS, formdata)
                .then(function (response) {
                    console.info('Lista de Videos')
                    console.log(response);
                    //monedas es el arreglo de  JS 
                    ADMIN_CURSO.listaVideos = response.data.videos;
                    console.info('PrimerVideo Videos')
                    // console.log(ADMIN_CURSO.listaVideos[0].URLvideo)
                })
        },
        cargarListaTipoVideo: function () {
            let formdata = new FormData();
            formdata.append("option", "showdata")
            axios.post(ENPOINT_TIPOVIDEO, formdata)
                .then(function (response) {
                    console.info('Lista de tipo de Videos')
                    console.log(response);
                    //monedas es el arreglo de  JS 
                    ADMIN_CURSO.listaTipoVideo = response.data.tipoVideo;
                })
        },
        cargarListaTipoRecurso: function () {
            let formdata = new FormData();
            formdata.append("option", "showdata")
            axios.post(ENPOINT_TIPORECURSO, formdata)
                .then(function (response) {
                    console.info('Lista de tipo de Recursos')
                    console.log(response);
                    //monedas es el arreglo de  JS 
                    ADMIN_CURSO.listaTipoRecurso = response.data.tipoRec;
                })
        },
        cargarListaDeRecursos: function () {
            let formdata = new FormData();
            formdata.append("option", "showdata")
            formdata.append("IDCURSO", d.getElementById("idCurso").value)
            axios.post(ENDPOINT_RECURSOS, formdata)
                .then(function (response) {
                    console.info('Lista de recursos')
                    console.log(response);
                    //monedas es el arreglo de  JS 
                    ADMIN_CURSO.listaRecursos = response.data.recursos;
                })
        },
        insertar : function(){
            //OBJETO EN JS
            let datos = {
                nombreTema: d.getElementById("insert-nombre").value,
                descripcion: d.getElementById("insert-descripcion").value,
                IDCURSO:  d.getElementById("idCurso").value
              };
            if(ADMIN_CURSO.validarCajasVacias(datos) ){
                                     //nombre de la clase de CSS - Mensaje - clase css de icono
               ADMIN_CURSO.alertMessage("myalert alert-infoDanger","Campos vacios","fas fa-exclamation bg-infoDanger");
            }else {
            let formData = ADMIN_CURSO.toFormData(datos,'insert');
                axios
                .post(ENDPOINT_TEMAS, formData)
                .then(response => {
                if (response.data) {
                    ADMIN_CURSO.cargarDatos();
                    ADMIN_CURSO.alertMessage("myalert alert-correct","Se ha registrado el tema exitosamente","fas fa-check bg-correct")
                    ADMIN_CURSO.limpiarCajas();
                    setTimeout(function () {
                        ADMIN_CURSO.limpiarAlertas();
                    }, 3000);
                    //permite actulizar la paginacion
                    this.cargarTotalRegistros();
                    this.paginar(this.paginaActual);
                } else {
                    ADMIN_CURSO.alertMessage("myalert alert-fail","El tema no pudo registrarce" + response.data, "fas fa-times bg-fail");
                    setTimeout(function () {
                        ADMIN_CURSO.limpiarAlertas();
                       }, 3000);
                }
                });
            } 
        },
        update: function(){
            let datos = {
                id: d.getElementById("update-id").value,
                nombreTema: d.getElementById("update-nombre").value,
                descripcion: d.getElementById("update-descripcion").value,
              };
            console.log(datos);
            if(ADMIN_CURSO.validarCajaUpdate(datos)){
                ADMIN_CURSO.alertMessage("myalert alert-infoDanger","Campos vacios","fas fa-exclamation bg-infoDanger");
            }else {
            let formData = ADMIN_CURSO.toFormData(datos,'update');
                axios
                .post(ENDPOINT_TEMAS, formData)
                .then(response => {
                console.log( response.data)
                if (response.data =="") {
                    ADMIN_CURSO.cargarDatos();
                    ADMIN_CURSO.alertMessage("myalert alert-correct","Se ha actualizado el tema exitosamente","fas fa-check bg-correct")
                    setTimeout(function () {
                        ADMIN_CURSO.limpiarAlertas();
                    }, 3000);
                } else {
                    ADMIN_CURSO.alertMessage("myalert alert-fail","El tema no pudo actulizarce" + response.data, "fas fa-times bg-fail");
                    setTimeout(function () {
                        ADMIN_CURSO.limpiarAlertas();
                       }, 3000);
                }
                });
            }
        },
        eliminar: function(){
            let datos = {
                id: d.getElementById("delete-id").value
            }
            console.log(datos)
            if(ADMIN_CURSO.validarCajaEliminar(datos)){
                ADMIN_CURSO.alertMessage("alert alert-infoDanger","Campos vacios");
            }else {
            let formData = ADMIN_CURSO.toFormData(datos,'delete');
                axios
                .post(ENDPOINT_TEMAS, formData)
                .then(response => {
                if (response.data == "") {
                    ADMIN_CURSO.cargarDatos();
                    ADMIN_CURSO.alertMessage("myalert alert-correct","Se ha eliminado el estado exitosamente","fas fa-check bg-correct")
                    setTimeout(function () {
                        ADMIN_CURSO.limpiarAlertas();
                    }, 3000);
                    this.cargarTotalRegistros();
                    this.paginar(this.paginaActual);
                } else {
                    ADMIN_CURSO.alertMessage("myalert alert-fail","El estado no pudo eliminarce" + response.data, "fas fa-times bg-fail");
                    setTimeout(function () {
                        ADMIN_CURSO.limpiarAlertas();
                       }, 3000);
                }
                });
            }
        },
        validarCajasVacias: function(caja){
            if( caja.nombreTema == 0 || caja.IDCURSO == 0 ){
                return true;
            }
            return false
        },
        validarCajaEliminar:function(caja){
            if(caja.id == 0) {
                return true;
            }
            return false
        },
        validarCajaUpdate: function(caja){
            if(caja.id == 0 || caja.nombreTema == 0 ){
                return true;
            }
            return false
        },
        setDatos: function(tema){
            d.getElementById("update-id").value = tema.id;
            d.getElementById("update-nombre").value = tema.nombre;
            d.getElementById("update-descripcion").value = tema.descripcion;
          
        },
        setDatosDelete: function(tema){
            d.getElementById("delete-id").value =  tema.id;
            d.getElementById("delete-nombre").value = tema.nombre;
        },
        //CRUD VIDEOS
        insertVideo: function (){
          
            let getVideo = document.getElementById("insert-video").files[0];
            let datos = {
                nombreVideo: d.getElementById("insert-nombre-video").value,
                tipo: d.getElementById("insert-res-video").value,
                tema: d.getElementById("insert-tema-video").value,
                url: d.getElementById("insert-url").value,
                video: getVideo
              };
              console.log(getVideo);
            if(ADMIN_CURSO.validarCamposVideos(datos) ){
                                     //nombre de la clase de CSS - Mensaje - clase css de icono
               ADMIN_CURSO.alertMessage("myalert alert-infoDanger","Campos vacios","fas fa-exclamation bg-infoDanger");
            } else {
                ADMIN_CURSO.mostrarSpinner();
            let formData = ADMIN_CURSO.toFormData(datos,'insert');
                axios
                .post(ENDPOINT_VIDEOS, formData)
                .then(response => {
                if (response.data == 1) {
                    ADMIN_CURSO.ocualtarSpinner();
                    ADMIN_CURSO.cargarListaDeVideos();
                    ADMIN_CURSO.alertMessage("myalert alert-correct","Se ha registrado el video exitosamente","fas fa-check bg-correct")
                    ADMIN_CURSO.limpiarCamposVideo();
                    setTimeout(function () {
                        ADMIN_CURSO.limpiarAlertas();
                    }, 3000);
                    //permite actulizar la paginacion
                    this.cargarTotalRegistrosVideo();
                    this.paginarVideos(this.paginaActualVideos);
                }else if(response.data.msj == "errorFile"){
                    ADMIN_CURSO.ocualtarSpinner();
                    ADMIN_CURSO.alertMessage("myalert alert-fail", response.data.detailError, "fas fa-times bg-fail");
                    setTimeout(function () {
                        ADMIN_CURSO.limpiarAlertas();
                       }, 3000);

                } else {
                    ADMIN_CURSO.ocualtarSpinner();
                    ADMIN_CURSO.alertMessage("myalert alert-fail","El video no pudo registrarce" + response.data, "fas fa-times bg-fail");
                    setTimeout(function () {
                        ADMIN_CURSO.limpiarAlertas();
                       }, 3000);
                }
                });
            } 
        },
        updateVideo: function(){
            let getVideo = document.getElementById("update-video").files[0];
            let datos = {
                id: ADMIN_CURSO.idVideo,
                nombreVideo: d.getElementById("update-nombre-video").value,
                tipo: d.getElementById("update-res-video").value,
                tema: d.getElementById("update-tema-video").value,
                url: d.getElementById("update-url").value,
                video: getVideo
              };
            console.log(getVideo);

            if(ADMIN_CURSO.validarCamposVideos(datos)){
                ADMIN_CURSO.alertMessage("myalert alert-infoDanger","Campos vacios","fas fa-exclamation bg-infoDanger");
            }else {
                ADMIN_CURSO.mostrarSpinner();
                let formData = ADMIN_CURSO.toFormData(datos,'update');
                axios
                .post(ENDPOINT_VIDEOS, formData)
                .then(response => {
                console.log( response.data)
                if (response.data) {
                    ADMIN_CURSO.ocualtarSpinner();
                    ADMIN_CURSO.cargarListaDeVideos();
                    ADMIN_CURSO.alertMessage("myalert alert-correct","Se ha actualizado el video exitosamente","fas fa-check bg-correct")
                    setTimeout(function () {
                        ADMIN_CURSO.limpiarAlertas();
                    }, 3000);
                }else if(response.data.msj == "errorFile"){
                    ADMIN_CURSO.ocualtarSpinner();
                    ADMIN_CURSO.alertMessage("myalert alert-fail", response.data.detailError, "fas fa-times bg-fail");
                    setTimeout(function () {
                        ADMIN_CURSO.limpiarAlertas();
                       }, 3000);

                } else {
                    ADMIN_CURSO.ocualtarSpinner();
                    ADMIN_CURSO.alertMessage("myalert alert-fail","El video no pudo actulizarce" + response.data, "fas fa-times bg-fail");
                    setTimeout(function () {
                        ADMIN_CURSO.limpiarAlertas();
                       }, 3000);
                }
                });
            }  
        },
        deleteVideo: function(){
            let datos = {
                id: ADMIN_CURSO.idVideo
            }
            console.log(datos)
            if(datos.id == null){
                ADMIN_CURSO.alertMessage("alert alert-infoDanger","Campos vacios");
            }else {
            let formData = ADMIN_CURSO.toFormData(datos,'delete');
                axios
                .post(ENDPOINT_VIDEOS, formData)
                .then(response => {
                if (response.data == "") {
                    ADMIN_CURSO.cargarListaDeVideos();
                    ADMIN_CURSO.alertMessage("myalert alert-correct","Se ha eliminado el video exitosamente","fas fa-check bg-correct")
                    setTimeout(function () {
                        ADMIN_CURSO.limpiarAlertas();
                    }, 3000);
                    this.cargarTotalRegistrosVideo();
                    this.paginarVideos(this.paginaActualVideos);
                } else {
                    ADMIN_CURSO.alertMessage("myalert alert-fail","El video no pudo eliminarce" + response.data, "fas fa-times bg-fail");
                    setTimeout(function () {
                        ADMIN_CURSO.limpiarAlertas();
                       }, 3000);
                }
                });
            }
        },
        setDatosVideo: function(video){
            ADMIN_CURSO.idVideo = video.idVideo;
            d.getElementById("update-nombre-video").value =video.nombreVideo,
            d.getElementById("update-res-video").value = video.idTipoVideo,
            d.getElementById("update-tema-video").value = video.idTema,
            d.getElementById("update-url").value = video.URLvideo
            console.log(ADMIN_CURSO.idVideo)
        },
        setDatosDeleteVideo: function(video){
            ADMIN_CURSO.idVideo = video.idVideo;
            d.getElementById("delete-nombre-video").value = video.nombreVideo;
        },
        validarCamposVideos: function (datos){
            if( datos.nombreVideo == 0 || datos.tipo == 0 || datos.tema == 0){
                return true;
            }
            return false
        },
        validarFilesMediaSelected: function( video){
            if(video == "" ){
                return true;
            }
            return false
        },
        //CRUD RECURSOS
        insertRecurso: function (){
            let datos = {
                nombreRecurso: d.getElementById("insert-nombre-recurso").value,
                tipo: d.getElementById("insert-tipo-recurso").value,
                video: d.getElementById("insert-video-recurso").value,
                url: d.getElementById("insert-url-recurso").value
              };
            if(ADMIN_CURSO.validarCamposRecursos(datos) ){
                                     //nombre de la clase de CSS - Mensaje - clase css de icono
               ADMIN_CURSO.alertMessage("myalert alert-infoDanger","Campos vacios","fas fa-exclamation bg-infoDanger");
            }else {
            let formData = ADMIN_CURSO.toFormData(datos,'insert');
                axios
                .post(ENDPOINT_RECURSOS, formData)
                .then(response => {
                if (response.data) {
                    ADMIN_CURSO.cargarListaDeRecursos();
                    ADMIN_CURSO.alertMessage("myalert alert-correct","Se ha registrado el recurso exitosamente","fas fa-check bg-correct")
                    ADMIN_CURSO.limpiarCamposRecursos();
                    setTimeout(function () {
                        ADMIN_CURSO.limpiarAlertas();
                    }, 3000);
                    //permite actulizar la paginacion
                    this.cargarTotalRegistrosRecursos();
                    this.paginarRecursos(this.paginaActualRecursos);
                } else {
                    ADMIN_CURSO.alertMessage("myalert alert-fail","El recurso no pudo registrarce" + response.data, "fas fa-times bg-fail");
                    setTimeout(function () {
                        ADMIN_CURSO.limpiarAlertas();
                       }, 3000);
                }
                });
            } 
        },
        mostrarSpinner:function () {
            contentLoad.removeAttribute("hidden");
            spinner.removeAttribute("hidden");
        },
        ocualtarSpinner:  function () {
            contentLoad.setAttribute("hidden", "");
            spinner.setAttribute("hidden", "");
        },
        updateRecurso: function(){
            let datos = {
                id: ADMIN_CURSO.idRecurso,
                nombreRecurso: d.getElementById("update-nombre-recurso").value,
                tipo: d.getElementById("update-tipo-recurso").value,
                video: d.getElementById("update-video-recurso").value,
                url: d.getElementById("update-url-recurso").value
              };
            console.log(datos);
            if(ADMIN_CURSO.validarCamposRecursos(datos)){
                ADMIN_CURSO.alertMessage("myalert alert-infoDanger","Campos vacios","fas fa-exclamation bg-infoDanger");
            }else {
            let formData = ADMIN_CURSO.toFormData(datos,'update');
                axios
                .post(ENDPOINT_RECURSOS, formData)
                .then(response => {
                console.log( response.data)
                if (response.data) {
                    ADMIN_CURSO.cargarListaDeRecursos();
                    ADMIN_CURSO.alertMessage("myalert alert-correct","Se ha actualizado el recurso exitosamente","fas fa-check bg-correct")
                    setTimeout(function () {
                        ADMIN_CURSO.limpiarAlertas();
                    }, 3000);
                } else {
                    ADMIN_CURSO.alertMessage("myalert alert-fail","El recurso no pudo actulizarce" + response.data, "fas fa-times bg-fail");
                    setTimeout(function () {
                        ADMIN_CURSO.limpiarAlertas();
                       }, 3000);
                }
                });
            }  
        },
        deleteRecurso: function(){
            let datos = {
                id: ADMIN_CURSO.idRecurso
            }
            console.log(datos)
            if(datos.id == null){
                ADMIN_CURSO.alertMessage("alert alert-infoDanger","Campos vacios");
            }else {
            let formData = ADMIN_CURSO.toFormData(datos,'delete');
                axios
                .post(ENDPOINT_RECURSOS, formData)
                .then(response => {
                if (response.data == "") {
                    ADMIN_CURSO.cargarListaDeRecursos();
                    ADMIN_CURSO.alertMessage("myalert alert-correct","Se ha eliminado el recurso exitosamente","fas fa-check bg-correct")
                    setTimeout(function () {
                        ADMIN_CURSO.limpiarAlertas();
                    }, 3000);
                    this.cargarTotalRegistrosRecursos();
                    this.paginarRecursos(this.paginaActualRecursos);
                } else {
                    ADMIN_CURSO.alertMessage("myalert alert-fail","El recurso no pudo eliminarce" + response.data, "fas fa-times bg-fail");
                    setTimeout(function () {
                        ADMIN_CURSO.limpiarAlertas();
                       }, 3000);
                }
                });
            }
        },
        setDatosRecurso: function(recurso){
            ADMIN_CURSO.idRecurso = recurso.idRecurso;
            d.getElementById("update-nombre-recurso").value = recurso.nombreRecurso;
            d.getElementById("update-tipo-recurso").value = recurso.idTipoRecurso;
            d.getElementById("update-video-recurso").value = recurso.idVideo;
            d.getElementById("update-url-recurso").value = recurso.URL;
            console.log(ADMIN_CURSO.idRecurso)
        },
        setDatosDeleteRecurso: function(recurso){
            ADMIN_CURSO.idRecurso = recurso.idRecurso;
            d.getElementById("delete-nombre-recurso").value = recurso.nombreRecurso;
        },
        validarCamposRecursos: function (datos){
            if( datos.nombreRecurso == 0 || datos.tipo == 0 || datos.video == 0 || datos.url == 0){
                return true;
            }
            return false
        },
        alertMessage: function( classe, message, iconName){
            ADMIN_CURSO.alertgeneral = classe;
            ADMIN_CURSO.messagealert = message;
            ADMIN_CURSO.alerticon = iconName;
            ADMIN_CURSO.displayAlert ="";
        },
        toFormData: (obj, option) => {
            let fd = new FormData();
            fd.append('option', option);
              for (let i in obj) {
                fd.append(i, obj[i]);
              }
            return fd;
        },
        limpiarCamposVideo: function(){
            d.getElementById("insert-nombre-video").value = "";
            d.getElementById("insert-res-video").value = 0;
            d.getElementById("insert-tema-video").value = 0;
            d.getElementById("insert-url").value = "";
        },
        limpiarCamposRecursos: function(){
            d.getElementById("insert-nombre-recurso").value = "";
            d.getElementById("insert-tipo-recurso").value = 0;
            d.getElementById("insert-video-recurso").value = 0;
            d.getElementById("insert-url-recurso").value = "";
        },
        limpiarCajas: function(){
            d.getElementById("insert-nombre").value = ""
            d.getElementById("insert-descripcion").value = ""
          },
        limpiarAlertas: function (){
            ADMIN_CURSO.alertgeneral = null;
            ADMIN_CURSO.messagealert = null; 
            ADMIN_CURSO.alerticon = null;
            ADMIN_CURSO.displayAlert = "display:none";
        },
        //metodos para paginar Temas
        paginar: function(pagina){
            this.paginaActual = pagina;
            this.anterior = (( this.paginaActual -1) * this.itemsPerPage);
            this.siguiente = this.paginaActual * this.itemsPerPage;

            this.paginaActual == 1 ? this.ocultarMostrarAnterior = "page-item disabled" : this.ocultarMostrarAnterior = "page-item";
            this.paginaActual == this.paginas ? this.ocultarMostrarSiguiente = "page-item disabled" : this.ocultarMostrarSiguiente = "page-item";
        },
        prev:function (){
            this.paginaActual =  this.paginaActual - 1;
            
            this.paginar(this.paginaActual);
        },
        next: function(){
            this.paginaActual = this.paginaActual + 1;
            this.paginar(this.paginaActual);
        },
         //metodos para paginar Videos
         paginarVideos: function(pagina){
            this.paginaActualVideos = pagina;
            this.anteriorVideo = (( this.paginaActualVideos -1) * this.itemPerPageVideos);
            this.siguienteVideo = this.paginaActualVideos * this.itemPerPageVideos;

            this.paginaActualVideos == 1 ? this.ocultarMostrarAnteriorVideo = "page-item disabled" : this.ocultarMostrarAnteriorVideo = "page-item";
            this.paginaActualVideos == this.paginasVideos ? this.ocultarMostrarSiguienteVideo = "page-item disabled" : this.ocultarMostrarSiguienteVideo = "page-item";
        },
        prevVideo:function (){
            this.paginaActualVideos =  this.paginaActualVideos - 1;
            
            this.paginarVideos(this.paginaActualVideos);
        },
        nextVideo: function(){
            this.paginaActualVideos = this.paginaActualVideos + 1;
            this.paginarVideos(this.paginaActualVideos);
        },
         //metodos para paginar Recursos
         paginarRecursos: function(pagina){
            this.paginaActualRecursos = pagina;
            this.anteriorRecurso = (( this.paginaActualRecursos -1) * this.itemPerPageRecursos);
            this.siguienteRecurso = this.paginaActualRecursos * this.itemPerPageRecursos;

            this.paginaActualRecursos == 1 ? this.ocultarMostrarAnteriorRecurso = "page-item disabled" : this.ocultarMostrarAnteriorRecurso = "page-item";
            this.paginaActualRecursos == this.paginasRecursos ? this.ocultarMostrarSiguienteRecurso = "page-item disabled" : this.ocultarMostrarSiguienteRecurso = "page-item";
        },
        prevRecurso:function (){
            this.paginaActualRecursos =  this.paginaActualRecursos - 1;
            
            this.paginarRecursos(this.paginaActualRecursos);
        },
        nextRecurso: function(){
            this.paginaActualRecursos = this.paginaActualRecursos + 1;
            this.paginarRecursos(this.paginaActualRecursos);
        },
        closeSesionRol: () => {
            let formdata = new FormData();
                formdata.append('option','destroySesion');
                    axios.post(ENDPOINT_LOG_PROFESOR, formdata)
                         .then(function (response) {
                            console.log(response);
                                if(response.data == "1"){
                                    sessionStorage.clear();
                                    window.location.href = "../../public/login.html";
                                }else{
                                    CLOSE.alertMessage("myalert alert-fail","Hubo un error al  cerrar sesion" + response.data, "fas fa-times bg-fail");
                                }
                    })               
        },

    }
});