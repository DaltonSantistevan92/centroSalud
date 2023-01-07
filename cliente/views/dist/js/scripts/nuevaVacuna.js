

    
    _init();

    let stockVacunas = [];
    
    function _init(){  
        recuperarIdEnfermero();
        recuperarEnfermeroCampaniaIds();
        cargarPacientes();
        guardarVacunaPaciente();
        getVacunasAplicadas();

    }

    function reducir() {
        let stock= [5]
        const disminuir = (acc,num) =>{
            acc.push(num -1);
            return acc;
        };

        const num2 = stock.reduce(disminuir, []);
        console.log(num2);
    }

    function recuperarIdEnfermero(){
        let sesion = JSON.parse(sessionStorage.getItem("sesion"));
        let enfermero = sesion.personas.enfermero;

        enfermero.map(e => {
            let enfermero_id = e.id;
            $('#enfermero_id').val(enfermero_id);
        });
    }

    function recuperarEnfermeroCampaniaIds() {
        let enfermero_id =  $('#enfermero_id').val();
        $.ajax({
            // la URL para la petición
            url : urlServidor + 'enfermero/listarEnfermeroCampania/'+ enfermero_id, 
            // especifica si será una petición POST o GET
            type : 'GET',
            // el tipo de información que se espera de respuesta
            dataType : 'json',
            success : function(response) {
                if(response.status){
                    let arrayCampaniaEnfermero = response.enfermero.campania_enfermero;
                    arrayCampaniaEnfermero.forEach(e=>{
                       let campania_id = e.campania.id; 
                       $('#campania_id').val(campania_id);
                    });
                    
                    let campania_id = $('#campania_id').val();
                    cargarDataEnfermeroCampania(campania_id,enfermero_id);
                }
            },
            error : function(jqXHR, status, error) {
                console.log('Disculpe, existió un problema');
            }
        }); 
    }

    function cargarDataEnfermeroCampania(campania_id,enfermero_id) {
        $.ajax({
            // la URL para la petición
            url : urlServidor + 'campania_enfermero/listarDetalles/'+ campania_id + '/'+ enfermero_id , 
            // especifica si será una petición POST o GET
            type : 'GET',
            // el tipo de información que se espera de respuesta
            dataType : 'json',
            success : function(response) {
                //console.log(response);
                if(response.status){
                    let data = response.data;
                    data.map(e=>{
                        let nombreEnfermero = e.enfermero;
                        let nombreCampania = e.nombre_campaña;
                        let total_vacunas = e.total_vacuna; //5
                        let provincia = e.provincia;
                        let canton = e.canton;
                        let parroquia = e.parroquia;
                        let barrio = e.barrio;
                        let intervalo_edad = e.intervalo_edad;
                        let nombre_producto = e.nombre_producto;

                        const newObjec = {
                            stock: total_vacunas
                        }
                        stockVacunas.push(newObjec);
                        hacerUnaCopiaValidar(stockVacunas);

                        //window.location.reload();
                        
                        let f = new Date();
                        let fecha = f.getDate() + '/' + (f.getMonth() + 1) + '/' + f.getFullYear();

                        $('#enfermero-nombre').val(nombreEnfermero);
                        $('#campania-nombres').val(nombreCampania);
                        $('#total-vacunas').val(total_vacunas);//original
                        $('#total-vacunas-text').text(total_vacunas);//original
                        $('#fecha').text(fecha);
                        $('#provincia').val(provincia);
                        $('#canton').val(canton);
                        $('#parroquia').val(parroquia);
                        $('#barrio').val(barrio);
                        $('#edad').val(intervalo_edad);
                        $('#nombre-vacuna').val(nombre_producto);
                    });
                }
            },
            error : function(jqXHR, status, error) {
                console.log('Disculpe, existió un problema');
            }
        });
        
    }

    function cargarPacientes(){
        $.ajax({
            // la URL para la petición
            url: urlServidor + 'pacientes/listarPacientes',
            // especifica si será una petición POST o GET
            type: 'GET',
            // el tipo de información que se espera de respuesta
            dataType: 'json',
            success: function (response) {
                //console.log(response);
                if (response.status) {
                    let tr = '';
                    let i = 1;
                    response.paciente.forEach(element => {
                        tr += `<tr id="fila-paciente-${element.id}">
                                <td>${i}</td>
                                <td style="display: none">${element.id}</td>
                                <td>${element.personas.cedula}</td>
                                <td>${element.personas.nombre}</td>
                                <td>${element.personas.apellido}</td>
                                <td>${element.personas.num_celular}</td>
                                <td>${element.personas.sexo.tipo}</td>
                                <td>
                                <div class="div text-center">
                                    <button class="btn btn-dark btn-sm" data-dismiss="modal" onclick="seleccionarPaciente(${element.id})">
                                    <i class="fas fa-check"></i>
                                    </button>
                                </div>
                                </td>
                            </tr>`;
                        i++;
                    });
                    $('#paciente-body').html(tr);
                }
            },
            error: function (jqXHR, status, error) {
                console.log('Disculpe, existió un problema');
            }
        });
    }

    function hacerUnaCopiaValidar(stockVacunas) {
        if(stockVacunas === undefined){
            stockVacunas = [];
        }else{
            if(JSON.parse(localStorage.getItem('vacunas')) === null){
                alert('añadiendo al local primera vez');
                localStorage.setItem('vacunas', JSON.stringify(stockVacunas));
            }else{
                alert('ya esta añadido solo muestra la data del local');
                const datalocal = JSON.parse(localStorage.getItem('vacunas'));
                datalocal.forEach(e =>{
                    console.log(e.stock);
                    $('#total-restante-val').val(e.stock);//data del local storage
                    $('#vacunas-restante').text(e.stock);//data del local storage
                });  
            }
        } 
    }

    function disminuir(oneDosis) {
        const tr = JSON.parse(localStorage.getItem('vacunas'))[0].stock;
        //console.log(tr);

        if(tr === 0){
            return false;
        }else{
            if(tr > 0){
                let stock = 0; let object = {}; let detalle = [];
                for (let i = 1; i <= tr; i++) {
                    stock = (tr - oneDosis);
                }
                object = {stock};
                detalle.push(object);
                localStorage.setItem('vacunas', JSON.stringify(detalle));
                //return detalle;
                return detalle;
            }  
            return true;
        }           
    }

    function reset() {
        $('#paciente-id').val('');
        $('#paciente-cedula').val('');
        $('#paciente-nombre').val('');
        $('#paciente-apellido').val('');
        $('#paciente-celular').val('');
        $('#paciente-sexo').val('');
        $('#hora').val('');
        
    }

    function getVacunasAplicadas() {
        $.ajax({
            // la URL para la petición
            url: urlServidor + 'aplicar_vacuna/contarVacunasAplicadas',
            // especifica si será una petición POST o GET
            type: 'GET',
            // el tipo de información que se espera de respuesta
            dataType: 'json',
            success: function (response) {
                //console.log(response);
                if (response.status) {    
                    $('#vacunas-aplicada').text(response.vacuna);
                }
            },
            error: function (jqXHR, status, error) {
                console.log('Disculpe, existió un problema');
            }
        });
    }

    function seleccionarPaciente(id) {
        let fila = '#fila-paciente-' + id;
        let f = $(fila)[0].children;

        let cedula = f[2].innerText;
        let nombre = f[3].innerText;
        let apellido = f[4].innerText;
        let celular = f[5].innerText;
        let sexo = f[6].innerText;

        $('#paciente-id').val(id);
        $('#paciente-cedula').val(cedula);
        $('#paciente-nombre').val(nombre);
        $('#paciente-apellido').val(apellido);
        $('#paciente-celular').val(celular);
        $('#paciente-sexo').val(sexo);
    }
    
    function guardarVacunaPaciente() {
        $('#btn-vacunar').click(function () {

            hacerUnaCopiaValidar(stockVacunas);

            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

            let enfermero_id = $('#enfermero_id').val();
            let campania_id = $('#campania_id').val();
            let pacientes_id = $('#paciente-id').val();
            let hora = $('#hora').val();
            let total_vacuna = $('#total-vacunas-text').text();
            let dosis = $('#dosis').val();

            if(hora.length == 0){
                Toast.fire({
                    icon: 'info',
                    title: 'Ingrese la hora de vacunación'
                });
            }else
            if(pacientes_id.length == 0){
                Toast.fire({
                    icon: 'info',
                    title: 'Ingrese un paciente'
                });
            }else{

                let dis = disminuir(dosis);
                console.log(dis);
                //let total_restante = dis[0].stock;
                //console.log(total_restante);
                 
                if(dis == false){
                    Toast.fire({
                        icon: 'info',
                        title: 'No hay vacunas'
                    });
                }else{
                    let json = {
                        vacunar: {
                            enfermero_id: enfermero_id,
                            campania_id: campania_id,
                            pacientes_id: pacientes_id,
                            total_vacuna: total_vacuna,
                            total_aplicadas: 1,
                            total_restante: dis[0].stock,
                            hora:hora,
                        }
                    };
                    console.log(json);
                    guardandoVacuna(json);
                }   
            }
        });
    }

    function guardandoVacuna(json){
        $.ajax({
            url:urlServidor  +'aplicar_vacuna/guardar',
            type:'POST',
            data: 'data=' + JSON.stringify(json),
            dataType:'json',
            success:function(response){              
                 var Toast = Swal.mixin({
                     toast: true,
                     position: 'top-end',
                     showConfirmButton: false,
                     timer: 3000
                 });
 
                if(response.status){
                    Toast.fire({
                     icon: 'success',
                     title: response.mensaje
                   });
                   reset();
                   window.location.reload();
                } else{
                 Toast.fire({
                     icon: 'error',
                     title: response.mensaje
                   });
                }
            },
            error : function(jqXHR, status, error) {
                console.log('Disculpe, existió un problema');
            }
        });
    }

    window.onload = () => {
        const storage = JSON.parse(localStorage.getItem('vacunas'));
        //console.log(storage);
        if(storage == null){
            alert("datos del local null");
        }else{
            if(storgare = stockVacunas ){
                hacerUnaCopiaValidar(stockVacunas);
            }
        }
    }




    