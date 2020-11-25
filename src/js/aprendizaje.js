const ENDPOINT_TEMAS = "controller/controller_tema.php";
const ENDPOINT_VIDEOS = "controller/controller_videos.php";
const ENDPOINT_RECURSOS = "controller/controller_recursos.php";
const ENDPOINT_CURSOS = "controller/controller_curso.php";
const ENDPOINT_VENTAS = "controller/controller_ventas.php";


const LEARN = new Vue({
    el: "#container-learn",
    data: {
        listaTemas : [],
        listaVideos : [],
        listaRecursos : [],
        listaCurso:[],
        tituloCurso: '',
        videoPlay: '',
        temaActual:0,
        porcentaje: 0

     },
     mounted: function(){
        this.loadPorcentaje();
        this.loadCurso();
        this.loadRecursos();
        this.loadVideos();
     },
     methods: {
        loadPorcentaje: function(){
            let idCurso = localStorage.getItem('idCursoLearn');
            let data = new FormData();
            data.append('option','porcentajeCurso');
            data.append('estudiante', sessionStorage.getItem('estudiante'));
            data.append('IDCURSO', idCurso);
            axios.post(ENDPOINT_CURSOS, data).then(function (response) {
              LEARN.porcentaje = response.data;
            })
        },
        loadCurso: function(){
            let idCurso = localStorage.getItem('idCursoLearn');
            let data = new FormData();
            data.append('option','showDataCursosDetail');
            data.append('IDCURSO', idCurso);
            axios.post(ENDPOINT_CURSOS, data).then(function (response) {
                console.log(response)
              LEARN.listaCurso = response.data.cursoDetail;
              LEARN.tituloCurso = LEARN.listaCurso[0].nombre; 
              LEARN.videoPlay = LEARN.listaCurso[0].videoPresentacion;
            })
        },
        loadRecursos: function(){
            let formdata = new FormData();
            formdata.append("option", "showdata")
            formdata.append("IDCURSO",localStorage.getItem('idCursoLearn'))
            axios.post(ENDPOINT_RECURSOS, formdata)
                .then(function (response) {
                    console.info('Lista de recursos')
                    console.log(response);
                    LEARN.listaRecursos = response.data.recursos;
                })
        },
        loadVideos: function(){
            let formdata = new FormData();
            formdata.append("option", "showVideoStateTema")
            formdata.append('estudiante', sessionStorage.getItem('estudiante'));
            formdata.append("IDCURSO", localStorage.getItem('idCursoLearn'))
            axios.post(ENDPOINT_VIDEOS, formdata)
                .then(function (response) {
                    console.info('Lista de Videos')
                    console.log(response);
                    //monedas es el arreglo de  JS 
                    LEARN.listaVideos = response.data.videos;
                    
                })
        },
        toFormData: (obj, option) => {
            let fd = new FormData();
            fd.append('option', option);
              for (let i in obj) {
                fd.append(i, obj[i]);
              }
            return fd;
          },

        viewVideo: function(tema) {
            console.log('entre a cambiar el video')
           LEARN.videoPlay = tema.URLvideo;
           let video =  document.getElementById('fm-video_html5_api');
           video.setAttribute('src','src/videos/cursos/'+LEARN.videoPlay);
           localStorage.setItem('idTema', tema.idTema)
        //    data.append('estudiante', sessionStorage.getItem('estudiante'));
        },
        enviarTemaVisto: function(){
            let data = new FormData()
            data.append('option','insertTemaVisto')
            data.append('idTema', localStorage.getItem('idTema'));
            data.append('estudiante', sessionStorage.getItem('estudiante'));
            axios.post(ENDPOINT_TEMAS, data).then(function (response) {
            //    if(response.data =)
                console.log(response.data);
                LEARN.loadPorcentaje();
                LEARN.loadVideos();
            })
        }
     }
})