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

                       <h2>Listado de Productos</h2><br/>
                      
                        <button class="btn btn-primary btn-lg" type="button" @click="abrirModal('producto', 'registrar')">
                            <i class="fa fa-plus fa-2x"></i>&nbsp;&nbsp;Agregar Producto
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <div class="form-group row">
                                    <div class="col-3">
                                    <select v-model="search.tipoBusq" class="form-control">
                                        <option value="nombre">Producto</option>
                                    </select>
                                    </div>
                                    <div class="col-5">
                                    <input type="search" v-model="search.search" class="form-control" placeholder="Buscar...!" @keyup.enter="listarProductos">
                                    </div>
                                    <div class="col-3">
                                    <button  @click="listarProductos"  class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr class="bg-primary">                                   
                                    <th>Categoría</th>
                                    <th>Producto</th>
                                    <th>Codigo</th>
                                    <th>Precio Venta</th>
                                    <th>Stock</th>
                                    <th>Estado</th>
                                    <th>Editar</th>
                                    <th>Cambiar Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                               
                                <tr v-for="producto in arrayProducto.data" :key="producto.id">
                                    
                                    <td v-text="producto.categoria"></td>
                                    <td v-text="producto.nombre"></td>
                                    <td v-text="producto.codigo"></td>
                                    <td v-text="producto.precio_venta"></td>
                                    <td v-text="producto.stock"></td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-md" v-if="producto.condicion">
                                          <i class="fa fa-check fa-2x"></i> Activo
                                        </button>
                                        <button type="button" class="btn btn-danger btn-md" v-else>
                                          <i class="fa fa-close fa-2x"></i> Desactivo
                                        </button>
                                       
                                    </td>

                                    <td>
                                        <button type="button" class="btn btn-info btn-md" @click="abrirModal('producto', 'actualizar', producto)">
                                          <i class="fa fa-edit fa-2x"></i> Editar
                                        </button> &nbsp;
                                    </td>

                                    <td>
                                        <template v-if="producto.condicion">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarProducto(producto.id)">
                                                <i class="fa fa-lock fa-2x"></i> Desactivar
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-success btn-sm" @click="activarProducto(producto.id)">
                                                <i class="fa fa-lock fa-2x"></i> Activar
                                            </button>
                                        </template>
                                    </td>
                                </tr>
                               
                            </tbody>
                        </table>
                        <nav>
                             <pagination :data="arrayProducto"
                             @pagination-change-page="listarProductos"></pagination>
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
                            
                            <div v-show="errorProducto" class="form-group row div-error">
                                
                                <div class="text-center text-error">
                                    
                                    <div v-for="error in errorMostrarMsjProducto" :key="error" v-text="error"></div>

                                </div>
                            
                            </div>
                             

                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Categoria</label>
                                    <div class="col-md-9">
                                        <select class="form-control" v-model="idcategoria">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="categoria in arrayCategoria" :key="categoria.id" :value="categoria.id">{{categoria.nombre}}</option>
                                        </select>                                       
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Producto</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Nombre de Producto">                                       
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Precio Venta</label>
                                    <div class="col-md-9">
                                    <input type="text" v-model="precio_venta" class="form-control" placeholder="Ingrese Precio Venta">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Stock</label>
                                    <div class="col-md-9">
                                    <input type="text" v-model="stock" class="form-control" placeholder="Ingrese Stock">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Codigo</label>
                                    <div class="col-md-9">
                                    <input type="text" v-model="codigo" class="form-control" placeholder="Ingrese Codigo">
                                    <barcode :value="codigo" :options="{format:'EAN-13'}">
                                        Creando Codigo de Barras
                                    </barcode>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" @click="cerrarModal()" class="btn btn-danger"><i class="fa fa-times fa-2x"></i> Cerrar</button>
                            <button type="button" @click="registrarProducto()" v-if="tipoAccion==1" class="btn btn-success"><i class="fa fa-save fa-2x"></i> Guardar</button>
                            <button type="button" @click="actualizarProducto()" v-if="tipoAccion==2" class="btn btn-success"><i class="fa fa-save fa-2x"></i> Actualizar</button>
                           
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
    import VueBarcode from 'vue-barcode';

    export default {
        data(){
            return {
                producto_id:0,
                idcategoria:0,
                codigo:'',
                nombre:'',
                precio_venta:0,
                stock:0,
                arrayProducto:{},
                arrayCategoria:{},
                modal:0,
                tituloModal:'',
                tipoAccion:0,
                errorProducto:0,
                errorMostrarMsjProducto:[],
                search: {
                    search: '',
                    tipoBusq: 'nombre'
                }
            }
        },
        components: {
            'barcode': VueBarcode
        },
        methods:{
            listarProductos(page = 1){
                let me = this;
                axios.get('/producto',{ 
                    params:{
                        'tipoBusq': this.search.tipoBusq,
                        'search': this.search.search,
                        'page': page
                    }
                }).then(function (response) {
                    // handle response
                    me.arrayProducto = response.data;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            listarCategorias(){
                let me = this;
                axios.get('/categoria/categorias').then(function (response) {
                    // handle response
                    me.arrayCategoria = response.data;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            registrarProducto(){

                if(this.validarProducto()){
                    return false;
                }

                let me = this;
                axios.post('/producto/registrar',{
                    'idcategoria': this.idcategoria,
                    'codigo': this.codigo,
                    'nombre': this.nombre,
                    'precio_venta': this.precio_venta,
                    'stock': this.stock
                }).then(function (response) {
                    // handle response
                    me.cerrarModal();
                    me.listarProductos();
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            actualizarProducto(){

                if(this.validarProducto()){
                    return false;
                }

                let me = this;
                axios.put('/producto/actualizar',{
                    'id': this.producto_id,
                    'idcategoria': this.idcategoria,
                    'codigo': this.codigo,
                    'nombre': this.nombre,
                    'precio_venta': this.precio_venta,
                    'stock': this.stock
                }).then(function (response) {
                    // handle response
                    me.cerrarModal();
                    me.listarProductos();
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            desactivarProducto(id){

                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false,
                })

                swalWithBootstrapButtons.fire({
                title: 'Estas seguro de Descativar el Producto?',
                //type: 'warning',
                showCancelButton: true,
                confirmButtonText: ' Aceptar ',
                cancelButtonText: ' Cancelar ',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios.put('/producto/desactivar',{
                        'id': id
                    }).then(function (response) {
                        // handle response
                        me.listarProductos();
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    });
                    swalWithBootstrapButtons.fire(
                    'Desactivado!',
                    'El Producto ha sido desactivado con exito.',
                    'success'
                    )
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    
                }
                })
                
            },
            activarProducto(id){

                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false,
                })

                swalWithBootstrapButtons.fire({
                title: 'Estas seguro de Activar el Producto?',
                //type: 'warning',
                showCancelButton: true,
                confirmButtonText: ' Aceptar ',
                cancelButtonText: ' Cancelar ',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios.put('/producto/activar',{
                        'id': id
                    }).then(function (response) {
                        // handle response
                        me.listarProductos();
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    });
                    swalWithBootstrapButtons.fire(
                    'Activado!',
                    'El Producto ha sido Activado con exito.',
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
                this.listarCategorias();
                switch(modelo){
                    case "producto":
                    {
                        switch(accion){
                            case "registrar":
                            {
                                this.modal = 1;
                                this.tituloModal = "Registrar - Producto";
                                this.idcategoria = 0;
                                this.codigo = "";
                                this.nombre = "";
                                this.precio_venta = 0;
                                this.stock = 0;
                                this.tipoAccion = '1';
                                break;
                            }
                            case "actualizar":
                                {
                                    this.modal = 1;
                                this.tituloModal = "Actualizar - Producto";
                                this.producto_id = data.id;
                                this.idcategoria = data.idcategoria;
                                this.codigo = data.codigo;
                                this.nombre = data.nombre;
                                this.precio_venta = data.precio_venta;
                                this.stock = data.stock;
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
                this.idcategoria = 0;
                this.codigo = "";
                this.nombre = "";
                this.precio_venta = 0;
                this.stock = 0;
                this.tipoAccion = 0;
                this.errorProducto = 0;
                this.errorMostrarMsjProducto = [];
                this.search.search = "";
            },
            validarProducto(){
                this.errorProducto = 0;
                this.errorMostrarMsjProducto = [];
                if(!this.nombre){
                    this.errorMostrarMsjProducto.push("(*)El nombre de la Producto no puede estar vacio.");
                    this.errorProducto = 1;
                }
                return this.errorProducto;
            }

        },

        mounted() {
            this.listarProductos();
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
