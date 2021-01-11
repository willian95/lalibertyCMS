@extends("layouts.main")

@section("content")

    <div class="d-flex flex-column-fluid" id="dev-format">
        <div class="loader-cover-custom" v-if="loading == true">
			<div class="loader-custom"></div>
		</div>
        <!--begin::Container-->
        <div class="container">
            <!--begin::Card-->
            <div class="card card-custom">
                <!--begin::Header-->
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h3 class="card-label">Orden home
                    </div>
                    <div class="card-toolbar">
                        <!--begin::Button-->
                        <button href="#" class="btn btn-primary font-weight-bolder" data-toggle="modal" data-target="#formatModal" v-if="homeOrders.length < 21">
                        <span class="svg-icon svg-icon-md">
                            <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"></rect>
                                    <circle fill="#000000" cx="9" cy="15" r="6"></circle>
                                    <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3"></path>
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span>Agregar elemento</button>
                        <!--end::Button-->
                    </div>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body">
                    <!--begin: Datatable-->
                    <div class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded" id="kt_datatable" style="">
                        <table class="table">
                            <thead>
                                <tr >
                                    <th class="datatable-cell datatable-cell-sort">
                                        <span style="width: 130px;">Titulo</span>
                                    </th>
                                    <th class="datatable-cell datatable-cell-sort">
                                        <span style="width: 130px;">Imagen</span>
                                    </th>
                                    <th class="datatable-cell datatable-cell-sort">
                                        <span style="width: 130px;">Orden</span>
                                    </th>
                                    <th class="datatable-cell datatable-cell-sort">
                                        <span style="width: 130px;">Acciones</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="order in homeOrders">
                                    <!-- columna 1 -->
                                    <td class="datatable-cell" v-if="order.work_id">
                                        @{{ order.work.title }}
                                    </td>
                                    <td class="datatable-cell" v-if="order.work_image_id">
                                        Contenido secundario
                                    </td>
                                    <td class="datatable-cell" v-if="order.product_id">
                                        @{{ order.product.name }}
                                    </td>
                                    <td class="datatable-cell" v-if="order.product_secondary_image_id">
                                        Contenido secundario
                                    </td>
                                    <td class="datatable-cell" v-if="order.blog_id">
                                        @{{ order.blog.title }}
                                    </td>
                                    <!-- columna 1 -->

                                    <!-- columna 2 -->
                                    <td class="datatable-cell" v-if="order.work_id">
                                        <img :src="order.work.main_image" alt="" style="width: 150px" v-if="order.work.main_image_file_type == 'image'">
                                        <video style="width: 150px;" controls v-else>
                                            <source :src="order.work.main_image" type="video/mp4">
                                        </video>
                                    </td>
                                    <td class="datatable-cell" v-if="order.work_image_id">
                                        <img :src="order.work_image.image" alt="" style="width: 150px" v-if="order.work_image.file_type == 'image'">
                                        <video style="width: 150px;" controls v-else>
                                            <source :src="order.work_image.image" type="video/mp4">
                                        </video>
                                    </td>

                                    <td class="datatable-cell" v-if="order.product_id">
                                        <img :src="order.product.image" alt="" style="width: 150px" v-if="order.product.main_image_file_type == 'image'">
                                        <video style="width: 150px;" controls v-else>
                                            <source :src="order.product.image" type="video/mp4">
                                        </video>
                                    </td>

                                    <td class="datatable-cell" v-if="order.product_secondary_image_id">
                                        <img :src="order.product_image.image" alt="" style="width: 150px" v-if="order.product_image.file_type == 'image'">
                                        <video style="width: 150px;" controls v-else>
                                            <source :src="order.product_image.image" type="video/mp4">
                                        </video>
                                    </td>

                                    <td class="datatable-cell" v-if="order.blog_id">
                                        <img :src="order.blog.image" alt="" style="width: 150px" v-if="order.blog.main_image_file_type == 'image'">
                                        <video style="width: 150px;" controls v-else>
                                            <source :src="order.blog.image" type="video/mp4">
                                        </video>
                                    </td>
                                    <!-- columna 2 -->
                                    <td>
                                        @{{ order.order }}
                                    </td>
                                    <td>
                                        <button class="btn btn-info" data-toggle="modal" data-target="#orderModal" @click="edit(order)"><i class="far fa-edit"></i></button>
                                        <button class="btn btn-secondary" @click="erase(order.id)"><i class="far fa-trash-alt"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        
                    </div>
                    <!--end: Datatable-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->

        <!-- Modal-->
        <div class="modal fade" id="formatModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content modal-lg">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Añadir elemento</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        
                        <div class="container">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">Tipo</label>
                                        <select class="form-control" v-model="type" @change="fetchElements">
                                            <option value="works">
                                                Works
                                            </option>
                                            <option value="fashion merch">
                                                Fashion Merch
                                            </option>
                                            <option value="products">
                                                Productos
                                            </option>
                                            <option value="blogs">
                                                Blog
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="name">Elemento</label>
                                        <select class="form-control" v-model="selectedElement" @change="showImage">
                                            <optgroup v-for="element in elements">
                                                <option :value="element">@{{ element.title ? element.title : element.name }}</option>
                                                <option :value="secondaryImage" v-if="element.work_images" v-for="(secondaryImage, index) in element.work_images">Contenido secundario @{{ index + 1 }}</option>
                                                <option :value="secondaryImage" v-if="element.secondary_images" v-for="(secondaryImage, index) in element.secondary_images">Contenido secundario @{{ index + 1 }}</option>                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4" v-if="selectedElement != ''">
                                    <img :src="selectedElementPreviewImage" alt="" style="width: 100%;" v-if="selectedElement.main_image_file_type == 'image' || selectedElement.file_type == 'image'">
                                    <video style="width: 100%;" controls v-else>
                                        <source :src="selectedElementPreviewImage" type="video/mp4">
                                    </video>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">Orden</label>
                                        <select class="form-control" v-model="order">
                                            <option :value="i" v-for="i in 21">@{{ i }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal" id="modal-close">Cerrar</button>
                        <button type="button" class="btn btn-primary font-weight-bold" @click="store()">Agregar</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal orden-->
        <div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-lg">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Editar posición</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        
                        <div class="container">
   
                            <div class="row">
                                
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">Orden</label>
                                        <select class="form-control" v-model="order">
                                            <option :value="i" v-for="i in 21">@{{ i }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal" id="modal-close-edit">Cerrar</button>
                        <button type="button" class="btn btn-primary font-weight-bold" @click="update()">Actualizar</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@push("scripts")

    <script>
        
        const app = new Vue({
            el: '#dev-format',
            data(){
                return{
                    name:"",
                    elemetId:"",
                    elements:[],
                    type:"",
                    orders:[],
                    selectedElement:"",
                    selectedElementPreviewImage:"",
                    loading:false,
                    orderId:"",
                    order:"",
                    homeOrders:[]
                }
            },
            methods:{
                
                store(){

                    this.loading = true
                    axios.post("{{ url('order/store') }}", {element: this.selectedElement, type: this.type, order: this.order})
                    .then(res => {
                        this.loading = false
                        if(res.data.success == true){

                            swal({
                                title: "Perfecto!",
                                text: "Haz agregado un elemento al orden!",
                                icon: "success"
                            });

                            $("#modal-close").click();
                            $('body').removeClass('modal-open');
                            $('body').css('padding-right', '0px');
                            $('.modal-backdrop').remove();

                            this.fetchHomeOrder()
                        }else{

                            swal({
                                title: "Lo sentimos!",
                                text: res.data.msg,
                                icon: "error"
                            });
                        }

                    })
                    .catch(err => {
                        this.loading = false
                        this.errors = err.response.data.errors
                    })

                },
                edit(order){
                    this.order = order.order
                    this.orderId = order.id
                },
                erase(id){
                    
                    swal({
                        title: "¿Estás seguro?",
                        text: "Eliminarás este formato!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            this.loading = true
                            axios.post("{{ url('/color/delete/') }}", {id: id}).then(res => {
                                this.loading = false
                                if(res.data.success == true){
                                    swal({
                                        title: "Genial!",
                                        text: "Formato eliminado!",
                                        icon: "success"
                                    });
                                    this.fetch()
                                }else{

                                    swal({
                                        title: "Lo sentimos!",
                                        text: res.data.msg,
                                        icon: "error"
                                    });

                                }

                            }).catch(err => {
                                this.loading = false
                                $.each(err.response.data.errors, function(key, value){
                                    alert(value)
                                });
                            })

                        }
                    });

                },
                fetchElements(){
                    this.elements = []
                    if(this.type == "works"){
                        this.fetchWorks()
                    }else if(this.type == "fashion merch"){
                        this.fetchFashionMerch()
                    }else if(this.type == "products"){
                        this.fetchProducts()
                    }else if(this.type == "blogs"){
                        this.fetchBlogs()
                    }

                },
                fetchWorks(){

                    axios.get("{{ url('order/fetch/works') }}").then(res => {

                        this.elements = res.data.works

                    })

                },
                fetchFashionMerch(){
                    
                    axios.get("{{ url('order/fetch/fashion-merch') }}").then(res => {

                        this.elements = res.data.fashionMerch

                    })
                    

                },
                fetchProducts(){
                    
                    axios.get("{{ url('order/fetch/products') }}").then(res => {

                        this.elements = res.data.products

                    })
                    

                },
                fetchBlogs(){
                    
                    axios.get("{{ url('order/fetch/blogs') }}").then(res => {

                        this.elements = res.data.blogs

                    })
                    

                },
                showImage(){

                    if(this.selectedElement.hasOwnProperty("main_image")){
                        this.selectedElementPreviewImage = this.selectedElement.main_image
                    }

                    else if(this.selectedElement.hasOwnProperty("image")){
                        this.selectedElementPreviewImage = this.selectedElement.image
                    }

                },
                fetchHomeOrder(){
                    axios.get("{{ url('order/fetch/elements') }}").then(res => {

                        this.homeOrders = res.data.elements

                    })
                },
                erase(id){

                    axios.post("{{ url('/order/delete') }}", {id: id}).then(res => {

                        if(res.data.success == true){
                            swal({
                                title: "Perfecto!",
                                text: "Haz agregado un elemento al orden!",
                                icon: "success"
                            });

                            this.fetchHomeOrder()

                        }else{
                            swal({
                              
                                text: res.data.msg,
                                icon: "error"
                            });
                        }

                    })

                },
                update(){

                    this.loading = true
                    axios.post("{{ url('order/update') }}", {orderId: this.orderId, order: this.order})
                    .then(res => {
                        this.loading = false
                        if(res.data.success == true){

                            swal({
                                title: "Perfecto!",
                                text: "Haz actualizado un elemento del orden!",
                                icon: "success"
                            });

                            $("#modal-close-edit").click();
                            $('body').removeClass('modal-open');
                            $('body').css('padding-right', '0px');
                            $('.modal-backdrop').remove();

                            this.fetchHomeOrder()
                        }else{

                            swal({
                                title: "Lo sentimos!",
                                text: res.data.msg,
                                icon: "error"
                            });
                        }

                    })
                    .catch(err => {
                        this.loading = false
                        this.errors = err.response.data.errors
                    })

                }


            },
            mounted(){
                
                this.fetchHomeOrder()

            }

        })
    
    </script>

@endpush