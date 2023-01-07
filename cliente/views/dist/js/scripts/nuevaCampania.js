var tabla;
/* $(function(){ */

    _init();

    function _init(){
        $('#btn-borrar').hide();
        cargarProvincias();
        cargarCantones();
        cargarParroquias();
        cargarBarrios();
        cargarIntervalos();
        cargarProductos();
        agregarItemProducto();
        guardarCampania();
        guardarAsignacion();
        cargarCampania();
        cargarEnfermeros();
        listarAsignaciones();
        buscarCampania();
        buscarEnfermero();
    }

    function cargarProvincias() {
        $.ajax({
            // la URL para la petición
            url: urlServidor + 'provincia/listar',
            // especifica si será una petición POST o GET
            type: 'GET',
            // el tipo de información que se espera de respuesta
            dataType: 'json',
            success: function (response) {
                if (response.status) {
                    let option = '<option value=0>Seleccione una Provincia</option>';

                    response.provincia.forEach(element => {
                        option += `<option value=${element.id}>${element.nombre_provincia}</option>`;
                    });
                    $('#campania-provincia').html(option);
                }
            },
            error: function (jqXHR, status, error) {
                console.log('Disculpe, existió un problema');
            },
            complete: function (jqXHR, status) {
                // console.log('Petición realizada');
            }
        });

    }

    function cargarCantones() {
        $('#campania-provincia').change(function () {
            let id = $('#campania-provincia option:selected').val();
            $.ajax({
                // la URL para la petición
                url: urlServidor + 'provincia/listarxId/' + id,
                // especifica si será una petición POST o GET
                type: 'GET',
                // el tipo de información que se espera de respuesta
                dataType: 'json',
                success: function (response) {
                    let inicio = '<option value=0>Seleccione un Canton</option>';
                    let aux = 0;

                    if (response.status) {
                        response.provincia.cantones.forEach(element => {
                            aux += `<option value='${element.id}'>${element.nombre_canton}</option>`;
                        });
                        inicio += aux;
                    }
                    $('#campania-canton').html(inicio);
                },
                error: function (jqXHR, status, error) {
                    console.log('Disculpe, existió un problema');
                },
                complete: function (jqXHR, status) {
                    // console.log('Petición realizada');
                }
            });
        });
    }

    function cargarParroquias() {
        $('#campania-canton').change(function () {
            let id = $('#campania-canton option:selected').val();
            $.ajax({
                // la URL para la petición
                url: urlServidor + 'cantones/listarxId/' + id,
                // especifica si será una petición POST o GET
                type: 'GET',
                // el tipo de información que se espera de respuesta
                dataType: 'json',
                success: function (response) {
                    let inicio = '<option value=0>Seleccione una Parroquia</option>';
                    let aux = 0;

                    if (response.status) {
                        response.cantones.parroquias.forEach(element => {
                            aux += `<option value='${element.id}'>${element.nombre_parroquia}</option>`;
                        });
                        inicio += aux;
                    }
                    $('#campania-parroquia').html(inicio);
                },
                error: function (jqXHR, status, error) {
                    console.log('Disculpe, existió un problema');
                },
                complete: function (jqXHR, status) {
                    // console.log('Petición realizada');
                }
            });
        });
    }

    function cargarBarrios() {
        $('#campania-parroquia').change(function () {
            let id = $('#campania-parroquia option:selected').val();
            $.ajax({
                // la URL para la petición
                url: urlServidor + 'parroquias/listarxId/' + id,
                // especifica si será una petición POST o GET
                type: 'GET',
                // el tipo de información que se espera de respuesta
                dataType: 'json',
                success: function (response) {
                    let inicio = '<option value=0>Seleccione un Barrio</option>';
                    let aux = 0;

                    if (response.status) {
                        response.parroquias.barrios.forEach(element => {
                            aux += `<option value='${element.id}'>${element.nombre_barrio}</option>`;
                        });
                        inicio += aux;
                    }
                    $('#campania-barrio').html(inicio);
                },
                error: function (jqXHR, status, error) {
                    console.log('Disculpe, existió un problema');
                },
                complete: function (jqXHR, status) {
                    // console.log('Petición realizada');
                }
            });
        });
    }

    function cargarIntervalos() {
        $.ajax({
            // la URL para la petición
            url: urlServidor + 'intervalo_edad/listar',
            // especifica si será una petición POST o GET
            type: 'GET',
            // el tipo de información que se espera de respuesta
            dataType: 'json',
            success: function (response) {
                if (response.status) {
                    let option = '<option value=0>Seleccione un Intervalo</option>';

                    response.intervalo.forEach(element => {
                        option += `<option value=${element.id}>${element.edad}</option>`;
                    });
                    $('#campania-edad').html(option);
                }
            },
            error: function (jqXHR, status, error) {
                console.log('Disculpe, existió un problema');
            },
            complete: function (jqXHR, status) {
                // console.log('Petición realizada');
            }
        });

    }

    function cargarProductos() {
        $('#abril-modal-prod').click(function(e){
            e.preventDefault();
            $('#modal-productos').modal('show');
            $.ajax({
                // la URL para la petición
                url: urlServidor + 'productos/listarParaCampania',
                // especifica si será una petición POST o GET
                type: 'GET',
                // el tipo de información que se espera de respuesta
                dataType: 'json',
                success: function (response) {
                    if (response.status) {
                        let tr = '';
                        let i = 1;
                        response.producto.forEach(element => {
                            tr += `<tr id="fila-producto-${element.id}">
                            <td>${i}</td>
                            <td style="display: none">${element.id}</td>
                            <td>${element.nombre}</td>
                            <td>${element.stock}</td>
                            <td>
                              <div class="div">
                                <button class="btn btn-primary btn-sm" data-dismiss="modal" onclick="seleccionar_producto(${element.id})">
                                  <i class="fas fa-check"></i>
                                </button>
                              </div>
                            </td>
                          </tr>`;
                            i++;
                        });
                        $('#productos-body').html(tr);
                    }
                },
                error: function (jqXHR, status, error) {
                    console.log('Disculpe, existió un problema');
                },
                complete: function (jqXHR, status) {
                    // console.log('Petición realizada');
                }
            });
        });
    }

    function agregarItemProducto() {
        $('#agregar-producto').click(function (e) {
            e.preventDefault();
            
            let id = $('#producto-id').val();
            let nombre = $('#producto-nombre').val();
            let cantidad = $('#producto-cantidad').val();
            let items = $('.total_producto');
            let stock = $('#producto-stock').val();
    
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
    
            if(id.length == 0){
                Toast.fire({
                    icon: 'info',
                    title: 'Seleccione un producto'
                });
                return;
            }else if(cantidad.length == 0){
                Toast.fire({
                    icon: 'info',
                    title: 'Ingrese una cantidad'
                });
                return;
            }else if(parseInt(cantidad) > stock){
                Toast.fire({
                    icon: 'info',
                    title: 'La cantidad excede el stock actual'
                });
                return;
            }else{
                $('#ocultar').hide();

                let tr = `<tr id="fila-producto-${id}" class="fila-productos">
                    <td><i class="fas fa-star-of-life"></i></td>
                    <td>${nombre}</td>
                    <td>${cantidad}</td>
                    <td class="total_producto">${cantidad}</td>
                    <th>
                            <div>
                                <button class="btn btn-outline-dark" onclick="borrar_item(${id})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                    </th>
                    <th style="display:none;">${id}</th>
                </tr>`;
                $('#listProdCampania').append(tr); 
                $('#table-detalle-campania').removeClass('d-none');
                resetProducto();
            }
        });
    }

    function resetProducto() {
        $('#producto-id').val('');
        $('#producto-nombre').val('');
        $('#producto-cantidad').val('');
        $('#producto-stock').val('');
        $('#btn-borrar').hide();
    }

    function guardarCampania(){
        $('#form-datos-campania').submit(function(e){
            e.preventDefault();

            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

            let nombre = $('#campania-nombre').val();
            let provincia_id = $('#campania-provincia option:selected').val();
            let cantones_id = $('#campania-canton option:selected').val();
            let parroquias_id = $('#campania-parroquia option:selected').val();
            let barrios_id = $('#campania-barrio option:selected').val();
            let intervalo_edad_id = $('#campania-edad option:selected').val();
            let fecha = $('#campania-fecha').val();

            //detalle abastecer
            let productos = $('.fila-productos');
            let items = $('.total_producto');

            if(nombre.length == 0){
                Toast.fire({
                    icon: 'info',
                    title: 'Ingrese nombre de la campaña'
                });
                return;
            }else if(provincia_id == 0){
                Toast.fire({
                    icon: 'info',
                    title: 'Seleccione una provincia'
                });
                return;
            }else if(cantones_id == 0){
                Toast.fire({
                    icon: 'info',
                    title: 'Seleccione un canton'
                });
                return;
            }else if(parroquias_id == 0){
                Toast.fire({
                    icon: 'info',
                    title: 'Seleccione una parroquia'
                });
            }else if(barrios_id == 0){
                Toast.fire({
                    icon: 'info',
                    title: 'Seleccione un barrio'
                });
            }else if(intervalo_edad_id == 0){
                Toast.fire({
                    icon: 'info',
                    title: 'Seleccione un intervalo de edad'
                });
            }else if(items.length == 0){
                Toast.fire({
                    icon: 'info',
                    title: 'Seleccione al menos un producto'
                });
            }else if(fecha.length == 0){
                Toast.fire({
                    icon: 'info',
                    title: 'Seleccione una fecha para la campaña'
                });
            }
            else{
                let detalles = [];
               for(let i = 0; i < productos.length; i++){

                   let productos_id = productos[i].children[5].innerText;
                   let cantidad = productos[i].children[2].innerText;

                   let aux = {
                        productos_id, cantidad
                   };
                   detalles.push(aux);
               }

                let json = {
                    campania: {
                        nombre: nombre,
                        provincia_id: provincia_id, 
                        cantones_id: cantones_id,
                        parroquias_id: parroquias_id,
                        barrios_id: barrios_id,
                        intervalo_edad_id: intervalo_edad_id,
                        fecha: fecha
                    },
                    detalle_campania: detalles
                };
                
                guardandocampania(json);
            }
        });
    }

    function guardandocampania(json){
        $.ajax({
            url:urlServidor  +'campania/guardar',
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
                   })
                   $('#form-datos-campania')[0].reset();
                    $('#listProdCampania').html('');
                    $('#table-detalle-campania').addClass('d-none');
                    cargarCampania();
                } else{
                 Toast.fire({
                     icon: 'error',
                     title: response.mensaje
                   })
                }
            },
            error : function(jqXHR, status, error) {
                console.log('Disculpe, existió un problema');
            },
            complete : function(jqXHR, status) {
                // console.log('Petición realizada');
            }
        });
    }

    function cargarCampania(){
        $.ajax({
            // la URL para la petición
            url : urlServidor + 'campania/listar', 
            // especifica si será una petición POST o GET
            type : 'GET',
            // el tipo de información que se espera de respuesta
            dataType : 'json',
            success : function(response) {
                if(response.status){
                    let tr = '';
                    let i = 1;
                    response.campania.forEach(element => {
                        tr += `<tr id="fila-campania-${element.id}">
                        <td>${i}</td>
                        <td style="display: none">${element.id}</td>
                        <td>${element.nombre}</td>
                        <td>
                          <div>
                            <button class="btn btn-primary btn-sm" onclick="seleccionar_campania(${element.id})">
                              <i class="fas fa-check"></i>
                            </button>
                          </div>
                        </td>
                      </tr>`;
                      i++;
                    });
                    $('#campania-body').html(tr);
                }
            },
            error : function(jqXHR, status, error) {
                console.log('Disculpe, existió un problema');
            },
            complete : function(jqXHR, status) {
                // console.log('Petición realizada');
            }
        }); 
    }

    function cargarEnfermeros(){
        $.ajax({
            // la URL para la petición
            url : urlServidor + 'enfermero/listar', 
            // especifica si será una petición POST o GET
            type : 'GET',
            // el tipo de información que se espera de respuesta
            dataType : 'json',
            success : function(response) {
                //console.log(response);
                if(response.status){
                    let tr = '';
                    let i = 1;
                    response.enfermero.forEach(element => {
                        tr += `<tr id="fila-enfermero-${element.id}">
                        <td>${i}</td>
                        <td style="display: none">${element.id}</td>
                        <td>${element.personas.nombre} ${element.personas.apellido}</td>
                        <td>
                          <div>
                            <button class="btn btn-primary btn-sm" onclick="seleccionar_enfermero(${element.id})">
                              <i class="fas fa-check"></i>
                            </button>
                          </div>
                        </td>
                      </tr>`;
                      i++;
                    });
                    $('#enfermero-body').html(tr);
                }
            },
            error : function(jqXHR, status, error) {
                console.log('Disculpe, existió un problema');
            },
            complete : function(jqXHR, status) {
                // console.log('Petición realizada');
            }
        }); 
    }

    function guardarAsignacion(){
        $('#asignar-campania-enfermero').click(function(){  
            let campania_id = $('#campania-id').val();
            let enfermero_id = $('#enfermero-id').val();

            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

            if(campania_id.length == 0){
                  Toast.fire({
                    icon: 'info',
                    title: 'Debe seleccionar una campaña'
                });
                return;
            }else
            if(enfermero_id.length == 0){
                  Toast.fire({
                    icon: 'info',
                    title: 'Debe seleccionar un enfermero'
                });
                return;
            }else{
               let json = {
                    campania_enfermero: {
                        campania_id,
                        enfermero_id,
                    },
                };

                guardandoAsignacion(json);
            }
        });
    }

    function guardandoAsignacion(json){
        $.ajax({
            // la URL para la petición
            url : urlServidor + 'campania_enfermero/guardar',
            // especifica si será una petición POST o GET
            type : 'POST',
            data : "data=" + JSON.stringify(json),
            // el tipo de información que se espera de respuesta
            dataType : 'json',
            success : function(response) {
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
                    listarAsignaciones();
                    cargarEnfermeros();
                }else{
                    Toast.fire({
                        icon: 'error',
                        title: response.mensaje
                    });
                }
            },
            error : function(jqXHR, status, error) {
                console.log('Disculpe, existió un problema');
            },
            complete : function(jqXHR, status) {
                // console.log('Petición realizada');
            }
        });
    }

    function reset(){ 
        $('#campania-id').val('');
        $('#campania-seleccionado').text('----------');
        $('#enfermero-id').val('');
        $('#enfermero-seleccionado').text('----------');
    }

    function listarAsignaciones(){
        $.ajax({
            // la URL para la petición
            url : urlServidor + 'campania_enfermero/listar', 
            // especifica si será una petición POST o GET
            type : 'GET',
            // el tipo de información que se espera de respuesta
            dataType : 'json',
            success : function(response) {
                if(response.status){
                    let tr = '';
                    let i = 1;
                    response.campania_enfermero.forEach(element => {
                        tr += `<tr id="fila-camp-enf-${element.id}">
                        <td>${i}</td>
                        <td style="display: none">${element.id}</td>
                        <td>${element.campania.nombre}</td>
                        <td>${element.campania.cantones.nombre_canton}</td>
                        <td>${element.campania.parroquias.nombre_parroquia}</td>
                        <td>${element.campania.barrios.nombre_barrio}</td>
                        <td>${element.enfermero.personas.nombre} ${element.enfermero.personas.apellido}</td>
                        <td>
                          <div>
                            <button class="btn btn-primary btn-sm" onclick="eliminarAsignacion(${element.id})">
                              <i class="fas fa-trash"></i>
                            </button>
                          </div>
                        </td>
                      </tr>`;
                      i++;
                    });
                    $('#asignacion-body').html(tr);
                }
            },
            error : function(jqXHR, status, error) {
                console.log('Disculpe, existió un problema');
            },
            complete : function(jqXHR, status) {
                // console.log('Petición realizada');
            }
        }); 
    }

    function buscarCampania(){
        $('#buscar-campania').keyup(function(){
            let texto = $('#buscar-campania').val();
            $.ajax({
                // la URL para la petición
                url : urlServidor + 'campania/buscarCampania/' + texto,
                // especifica si será una petición POST o GET
                type : 'GET',
                // el tipo de información que se espera de respuesta
                dataType : 'json',
                success : function(response) {
                   if(response.status){
                        let tr = '';
                        let i = 1;
                        response.campania.forEach(element => {
                            tr += `<tr id="fila-campania-${element.id}">
                            <td>${i}</td>
                            <td style="display: none">${element.id}</td>
                            <td>${element.nombre}</td>
                            <td>
                            <div>
                                <button class="btn btn-primary btn-sm" onclick="seleccionar_campania(${element.id})">
                                <i class="fas fa-check"></i>
                                </button>
                            </div>
                            </td>
                        </tr>`;
                        i++;
                        });
                        $('#campania-body').html(tr);
                    }else{
                        $('#campania-body').html('No hay información disponible');
                    }
                },
                error : function(jqXHR, status, error) {
                    console.log('Disculpe, existió un problema');
                },
                complete : function(jqXHR, status) {
                    // console.log('Petición realizada');
                }
            });
        });
    }

    function buscarEnfermero(){
        $('#buscar-enfermero').keyup(function(){
            let texto = $('#buscar-enfermero').val();
            $.ajax({
                // la URL para la petición
                url : urlServidor + 'enfermero/buscarEnfermero/' + texto,
                // especifica si será una petición POST o GET
                type : 'GET',
                // el tipo de información que se espera de respuesta
                dataType : 'json',
                success : function(response) {
                   if(response.status){
                        let tr = '';
                        let i = 1;
                        response.enfermero.forEach(element => {
                            tr += `<tr id="fila-enfermero-${element.enfermero_id}">
                            <td>${i}</td>
                            <td style="display: none">${element.enfermero_id}</td>
                            <td>${element.nombre} ${element.apellido}</td>
                            <td>
                              <div>
                                <button class="btn btn-primary btn-sm" onclick="seleccionar_enfermero(${element.enfermero_id})">
                                  <i class="fas fa-check"></i>
                                </button>
                              </div>
                            </td>
                          </tr>`;
                          i++;
                        });
                        $('#enfermero-body').html(tr);
                    }else{
                        $('#enfermero-body').html('No hay información disponible');
                    }
                },
                error : function(jqXHR, status, error) {
                    console.log('Disculpe, existió un problema');
                },
                complete : function(jqXHR, status) {
                    // console.log('Petición realizada');
                }
            });
        });
    }

/* }); */

function seleccionar_producto(id) {
    let fila = '#fila-producto-' + id;
    let f = $(fila)[0].children;

    let nombreProducto = f[2].innerText;
    let stock = f[3].innerText;

    $('#producto-id').val(id);
    $('#producto-nombre').val(nombreProducto);
    $('#producto-stock').val(stock);
    $('#btn-borrar').show();
}

function borrar_item(id){
    let tr = '#fila-producto-'+id;
    $(tr).remove();
    $('#ocultar').show();
    $('#table-detalle-campania').addClass('d-none')
}

function seleccionar_campania(id) {
    let fila = '#fila-campania-' + id;
    let f = $(fila)[0].children;

    let campania = f[2].innerText;

    $('#campania-id').val(id);
    $('#campania-seleccionado').text(campania);
}

function seleccionar_enfermero(id) {
    let fila = '#fila-enfermero-' + id;
    let f = $(fila)[0].children;

    let nombreEnfermero = f[2].innerText;

    $('#enfermero-id').val(id);
    $('#enfermero-seleccionado').text(nombreEnfermero);
}

function eliminarAsignacion(id){
    $.ajax({
        // la URL para la petición
        url : urlServidor + 'campania_enfermero/eliminar/'+ id, 
        // especifica si será una petición POST o GET
        type : 'DELETE',
        // el tipo de información que se espera de respuesta
        dataType : 'json',
        success : function(response) {
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
                listarAsignaciones();
                cargarEnfermeros();
            }
        },
        error : function(jqXHR, status, error) {
            console.log('Disculpe, existió un problema');
        },
        complete : function(jqXHR, status) {
            // console.log('Petición realizada');
        }
    });
}


