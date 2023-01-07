/* $(function(){ */
   
    _init();

    function _init(){
        listarCategoria();
        editarCategoriaModal();
    }

    function listarCategoria(){
        $.ajax({
            // la URL para la petición
            url: urlServidor + 'categorias/listar',
            // especifica si será una petición POST o GET
            type: 'GET',
            // el tipo de información que se espera de respuesta
            dataType: 'json',
            success: function (response) {
                if (response.status) {
                    let tr = '';
                    let i = 1;
                    response.categoria.forEach(element => {
                        tr += `<tr>
                            <td>${i}</td>
                            <td>${element.categoria}</td>
                            <td>
                            <div><button class="btn btn-primary btn-sm" onclick="editarCategoria(${element.id})">
                                <i class="fa fa-edit"></i>
                                </button>
                            </div>
                            </td>

                            <td>
                            <div><button class="btn btn-dark btn-sm" onclick="eliminarCategoria(${element.id})">
                                <i class="fa fa-trash"></i>
                                </button>
                            </div>
                            </td>
                        </tr>`;
                        i++;
                    });
                    $('#categorias-body').html(tr);
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

/* }); */

function eliminarCategoria(id){
    let data = {
        categoria: {
            id: id,
        }
    };

    $.ajax({
        // la URL para la petición
        url : urlServidor + 'categorias/eliminar',
        // especifica si será una petición POST o GET
        type : 'POST',
        // el tipo de información que se espera de respuesta
        data: {data: JSON.stringify(data)},
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
                  })
                  listarCategoria();
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

function editarCategoria(id){
    $('#modal-editar-categoria').modal('show'); 
    cargarCategoria(id);  
}

function cargarCategoria(id){
    $.ajax({
        url:urlServidor  +'categorias/listarXid/' + id,
        type:'GET',
        dataType:'json',
        success:function(response){
            console.log(response);
            if(response.status){    
                $('#upd-categoria-id').val(response.categoria.id);
                $('#upd-nombre-categoria').val(response.categoria.categoria);
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

function editarCategoriaModal(){
    $('#btn-update').click(function(){

        let id = $('#upd-categoria-id').val();
        let categoria = $('#upd-nombre-categoria').val();
                
        let json = {
            categoria: {
                id:id,
                categoria: categoria
            }
        };

        $.ajax({
            // la URL para la petición
            url : urlServidor + 'categorias/editar',
            type : 'POST',
            data: {data: JSON.stringify(json)},
            dataType : 'json',
            success : function(response){   
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
                    $('#modal-editar-categoria').modal('hide');
                    listarCategoria();
                }else{
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
    });
}