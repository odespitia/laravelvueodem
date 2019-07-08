<template>
    <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="/">BACKEND - SISTEMA DE COMPRAS - VENTAS</a></li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">

                       <h2>Listado de Categorías</h2><br/>
                      
                        <button class="btn btn-primary btn-lg" type="button" @click="abrirModal('categoria', 'registrar')">
                            <i class="fa fa-plus fa-2x"></i>&nbsp;&nbsp;Agregar Categoría
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <div class="form-group row">
                                    <div class="col-3">
                                    <select v-model="search.tipoBusq" class="form-control">
                                        <option value="nombre">Categoría</option>
                                        <option value="descripcion">Descripción</option>
                                    </select>
                                    </div>
                                    <div class="col-5">
                                    <input type="search" v-model="search.search" class="form-control" placeholder="Buscar...!" @keyup.enter="listarCategorias">
                                    </div>
                                    <div class="col-3">
                                    <button  @click="listarCategorias"  class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr class="bg-primary">
                                   
                                    <th>Categoría</th>
                                    <th>Descripción</th>
                                    <th>Estado</th>
                                    <th>Editar</th>
                                    <th>Cambiar Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                               
                                <tr v-for="categoria in arrayCategoria.data" :key="categoria.id">
                                    
                                    <td v-text="categoria.nombre"></td>
                                    <td v-text="categoria.descripcion"></td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-md" v-if="categoria.condicion">
                                          <i class="fa fa-check fa-2x"></i> Activo
                                        </button>
                                        <button type="button" class="btn btn-danger btn-md" v-else>
                                          <i class="fa fa-close fa-2x"></i> Desactivo
                                        </button>
                                       
                                    </td>

                                    <td>
                                        <button type="button" class="btn btn-info btn-md" @click="abrirModal('categoria', 'actualizar', categoria)">
                                          <i class="fa fa-edit fa-2x"></i> Editar
                                        </button> &nbsp;
                                    </td>

                                    <td>
                                        <template v-if="categoria.condicion">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarCategoria(categoria.id)">
                                                <i class="fa fa-lock fa-2x"></i> Desactivar
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-success btn-sm" @click="activarCategoria(categoria.id)">
                                                <i class="fa fa-lock fa-2x"></i> Activar
                                            </button>
                                        </template>
                                    </td>
                                </tr>
                               
                            </tbody>
                        </table>
                        <nav>
                             <pagination :data="arrayCategoria"
                             @pagination-change-page="listarCategorias"></pagination>
                        </nav>
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" :class="{'mostrar':modal}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" @click="cerrarModal()" class="close" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                       
                        <div class="modal-body">
                            
                            <div v-show="errorCategoria" class="form-group row div-error">
                                
                                <div class="text-center text-error">
                                    
                                    <div v-for="error in errorMostrarMsjCategoria" :key="error" v-text="error"></div>

                                </div>
                            
                            </div>
                             

                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Categoría</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Nombre de categoría">
                                       
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Descripción</label>
                                    <div class="col-md-9">
                                    <input type="text" v-model="descripcion" class="form-control" placeholder="Ingrese descripcion">
                                    </div>
                                </div>


                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" @click="cerrarModal()" class="btn btn-danger"><i class="fa fa-times fa-2x"></i> Cerrar</button>
                            <button type="button" @click="registrarCategoria()" v-if="tipoAccion==1" class="btn btn-success"><i class="fa fa-save fa-2x"></i> Guardar</button>
                            <button type="button" @click="actualizarCategoria()" v-if="tipoAccion==2" class="btn btn-success"><i class="fa fa-save fa-2x"></i> Actualizar</button>
                           
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
    </main>
</template>

<script>

    export default {
        data(){
            return {
                categoria_id:0,
                nombre:'',
                descripcion:'',
                arrayCategoria:{},
                modal:0,
                tituloModal:'',
                tipoAccion:0,
                errorCategoria:0,
                errorMostrarMsjCategoria:[],
                search: {
                    search: '',
                    tipoBusq: 'nombre'
                }
            }
        },
        methods:{
            listarCategorias(page = 1){
                let me = this;
                axios.get('/categoria',{ 
                    params:{
                        'tipoBusq': this.search.tipoBusq,
                        'search': this.search.search,
                        'page': page
                    }
                }).then(function (response) {
                    // handle response
                    me.arrayCategoria = response.data;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            registrarCategoria(){

                if(this.validarCategoria()){
                    return false;
                }

                let me = this;
                axios.post('/categoria/registrar',{
                    'nombre': this.nombre,
                    'descripcion': this.descripcion
                }).then(function (response) {
                    // handle response
                    me.cerrarModal();
                    me.listarCategorias();
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            actualizarCategoria(){

                if(this.validarCategoria()){
                    return false;
                }

                let me = this;
                axios.put('/categoria/actualizar',{
                    'id': this.categoria_id,
                    'nombre': this.nombre,
                    'descripcion': this.descripcion
                }).then(function (response) {
                    // handle response
                    me.cerrarModal();
                    me.listarCategorias();
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            desactivarCategoria(id){

                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false,
                })

                swalWithBootstrapButtons.fire({
                title: 'Estas seguro de Descativar la Categoria?',
                //type: 'warning',
                showCancelButton: true,
                confirmButtonText: ' Aceptar ',
                cancelButtonText: ' Cancelar ',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios.put('/categoria/desactivar',{
                        'id': id
                    }).then(function (response) {
                        // handle response
                        me.listarCategorias();
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    });
                    swalWithBootstrapButtons.fire(
                    'Desactivado!',
                    'La Categoria ha sido desactivada con exito.',
                    'success'
                    )
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    
                }
                })
                
            },
            activarCategoria(id){

                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false,
                })

                swalWithBootstrapButtons.fire({
                title: 'Estas seguro de Activar la Categoria?',
                //type: 'warning',
                showCancelButton: true,
                confirmButtonText: ' Aceptar ',
                cancelButtonText: ' Cancelar ',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios.put('/categoria/activar',{
                        'id': id
                    }).then(function (response) {
                        // handle response
                        me.listarCategorias();
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    });
                    swalWithBootstrapButtons.fire(
                    'Activado!',
                    'La Categoria ha sido Activada con exito.',
                    'success'
                    )
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    
                }
                })
                
            },
            abrirModal(modelo, accion, data=[]){
                switch(modelo){
                    case "categoria":
                    {
                        switch(accion){
                            case "registrar":
                            {
                                this.modal = 1;
                                this.tituloModal = "Registrar - Categoria";
                                this.nombre = "";
                                this.descripcion = "";
                                this.tipoAccion = '1';
                                break;
                            }
                            case "actualizar":
                            {
                                this.modal = 1;
                                this.tituloModal = "Actualizar - Categoria";
                                this.categoria_id = data.id;
                                this.nombre = data.nombre;
                                this.descripcion = data.descripcion;
                                this.tipoAccion = '2';
                                break;
                            }
                        }
                    }
                }
            },
            cerrarModal(){
                this.modal = 0;
                this.tituloModal = "";
                this.nombre = "";
                this.descripcion = "";
                this.tipoAccion = 0;
                this.errorCategoria = 0;
                this.errorMostrarMsjCategoria = [];
                this.search.search = "";
            },
            validarCategoria(){
                this.errorCategoria = 0;
                this.errorMostrarMsjCategoria = [];
                if(!this.nombre){
                    this.errorMostrarMsjCategoria.push("(*)El nombre de la categoria no puede estar vacio.");
                    this.errorCategoria = 1;
                }
                return this.errorCategoria;
            }

        },

        mounted() {
            this.listarCategorias();
            //console.log('Component -*- mounted.')
        }
    }
</script>

<style>
.modal-content{
    width: 100% !important;
    position: absolute !important;
}
.mostrar{
    display: list-item !important;
    opacity: 1 !important;
    position: absolute !important;
    background-color: #3c29297a !important;
}
.text-error{
    color: red;
    font-weight: bold;
    font-size: 20px;
    text-align: center;
}
</style>
