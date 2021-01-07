@extends("layouts.main")

@section("content")

    <div class="d-flex flex-column-fluid" id="dev-sales">
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
                        <h3 class="card-label">Ventas
                    </div>
                    <div class="card-toolbar">
                        <!--begin::Dropdown-->
                        <div class="dropdown dropdown-inline mr-2">
                            <button type="button" class="btn btn-light-primary font-weight-bolder dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" @click="toggleMenu()">
                            <span class="svg-icon svg-icon-md">
                                <!--begin::Svg Icon | path:assets/media/svg/icons/Design/PenAndRuller.svg-->
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"></rect>
                                        <path d="M3,16 L5,16 C5.55228475,16 6,15.5522847 6,15 C6,14.4477153 5.55228475,14 5,14 L3,14 L3,12 L5,12 C5.55228475,12 6,11.5522847 6,11 C6,10.4477153 5.55228475,10 5,10 L3,10 L3,8 L5,8 C5.55228475,8 6,7.55228475 6,7 C6,6.44771525 5.55228475,6 5,6 L3,6 L3,4 C3,3.44771525 3.44771525,3 4,3 L10,3 C10.5522847,3 11,3.44771525 11,4 L11,19 C11,19.5522847 10.5522847,20 10,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,16 Z" fill="#000000" opacity="0.3"></path>
                                        <path d="M16,3 L19,3 C20.1045695,3 21,3.8954305 21,5 L21,15.2485298 C21,15.7329761 20.8241635,16.200956 20.5051534,16.565539 L17.8762883,19.5699562 C17.6944473,19.7777745 17.378566,19.7988332 17.1707477,19.6169922 C17.1540423,19.602375 17.1383289,19.5866616 17.1237117,19.5699562 L14.4948466,16.565539 C14.1758365,16.200956 14,15.7329761 14,15.2485298 L14,5 C14,3.8954305 14.8954305,3 16,3 Z" fill="#000000"></path>
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span>Exportar</button>
                            <!--begin::Dropdown Menu-->
                            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right" id="menu">
                                <!--begin::Navigation-->
                                <ul class="navi flex-column navi-hover py-2">
                                    <li class="navi-header font-weight-bolder text-uppercase font-size-sm text-primary pb-2">Elegir una opción:</li>
                                    
                                    <li class="navi-item">
                                        <a href="{{ url('/sales/excel') }}" class="navi-link">
                                            <span class="navi-icon">
                                                <i class="la la-file-excel-o"></i>
                                            </span>
                                            <span class="navi-text">Excel</span>
                                        </a>
                                    </li>
                                    <li class="navi-item">
                                        <a href="{{ url('/sales/csv') }}" class="navi-link">
                                            <span class="navi-icon">
                                                <i class="la la-file-text-o"></i>
                                            </span>
                                            <span class="navi-text">CSV</span>
                                        </a>
                                    </li>
                                    
                                </ul>
                                <!--end::Navigation-->
                            </div>
                            <!--end::Dropdown Menu-->
                        </div>
                        <!--end::Dropdown-->
                        
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
                                        <span >#</span>
                                    </th>
                                    <th class="datatable-cell datatable-cell-sort">
                                        <span >Cliente</span>
                                    </th>

                                    <th class="datatable-cell datatable-cell-sort">
                                        <span >Status</span>
                                    </th>

                                    <th class="datatable-cell datatable-cell-sort">
                                        <span >Total</span>
                                    </th>
                                    <th class="datatable-cell datatable-cell-sort">
                                        <span >Fecha</span>
                                    </th>
                                    <th class="datatable-cell datatable-cell-sort">
                                        <span >Acciones</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(shopping, index) in shoppings">
                                    <th>@{{ shopping.order_id }}</th>
                                    <td v-if="shopping.guest_user">@{{ shopping.guest_user.name }}</td>
                                    <td style="text-transform: capitalize;">@{{ shopping.status }}</td>
                                    <td>$ @{{  currencyFormatDE(shopping.total) }}</td>
                                    <td>@{{ dateFormatter(shopping.created_at.toString().substring(0, 10)) }}</td>
                                    <td>
                                        <button class="btn btn-primary" data-toggle="modal" data-target="#shoppingModal" @click="show(shopping)"><i class="far fa-eye"></i></button>
                                        
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-sm-12 col-md-5">
                                <div class="dataTables_info" id="kt_datatable_info" role="status" aria-live="polite">Mostrando página @{{ page }} de @{{ pages }}</div>
                            </div>
                            <div class="col-sm-12 col-md-7">
                                <div class="dataTables_paginate paging_full_numbers" id="kt_datatable_paginate">
                                    <ul class="pagination">
                                        <li class="paginate_button page-item previous disabled" id="kt_datatable_previous" v-if="page > 1">
                                            <a aria-controls="kt_datatable" data-dt-idx="1" tabindex="0" class="page-link">
                                                <i class="ki ki-arrow-back"></i>
                                            </a>
                                        </li>
                                        <li class="paginate_button page-item active" v-for="index in pages">
                                            <a aria-controls="kt_datatable" tabindex="0" class="page-link":key="index" @click="fetch(index)" >@{{ index }}</a>
                                        </li>
                                        
                                        <li class="paginate_button page-item next" id="kt_datatable_next" v-if="page < pages" href="#">
                                            <a aria-controls="kt_datatable" data-dt-idx="7" tabindex="0" class="page-link" @click="fetch(pages)">
                                                <i class="ki ki-arrow-next"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end: Datatable-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->

        <!-- Modal-->
        <div class="modal fade" id="shoppingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Información</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body" v-if="shopping != ''">
                        <div class="row">
                            <div class="col-md-6">
                                <label><strong>Cliente</strong></label>
                                <p v-if="shopping.guest_user">@{{ shopping.guest_user.name }}</p>
                            </div>
                            <div class="col-md-6">
                                <label><strong>Email</strong></label>
                                <p v-if="shopping.guest_user">@{{ shopping.guest_user.email }}</p>
                            </div>
                            <div class="col-md-6">
                                <label><strong>Teléfono</strong></label>
                                <p v-if="shopping.guest_user">@{{ shopping.guest_user.phone }}</p>
                            </div>
                            <div class="col-md-6">
                                <label><strong>Dirección</strong></label>
                                <p v-if="shopping.guest_user">@{{ shopping.guest_user.address }}</p>
                            </div>
                            
                            <div class="col-md-6">
                                <label><strong>Total</strong></label>
                                <p>$ @{{ currencyFormatDE(shopping.total) }}</p>
                            </div>
                            <div class="col-md-6" v-if="shopping.tracking != null">
                                <label><strong>Empresa de envíos</strong></label>
                                <p>
                                <a>@{{ shopping.shipping_provider }}</a>
                                </p>
                            </div>
                            <div class="col-md-6" v-if="shopping.tracking != null">
                                <label><strong>Tracking</strong></label>
                                <p>
                                <a>@{{ shopping.tracking }}</a>
                                </p>
                            </div>
                            <!--<div class="col-md-6">
                                <label>Status tracing</label>
                                <p>@{{ shopping.status_shipping }}</p>
                            </div>-->
                            
                            <div class="col-md-12">
                                <h3 class="text-center">Productos</h3>
                            </div>
                            <div class="col-md-12">
                                <table class="table table-bordered table-checkable">
                                    <thead>
                                        <tr>
                                            <th>Producto</th>
                                            <th>Precio</th>
                                        
                                            <th>Tamaño</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(shoppingPurchase, index) in shopping.product_purchases">
                                            <td>@{{ shoppingPurchase.product_color_size.product.name }}</td>
                                            <td>$ @{{ currencyFormatDE(shoppingPurchase.price) }}</td>
                                            <td>@{{ shoppingPurchase.product_color_size.size.size }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            
                            <div v-if="shopping.tracking == null">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h3 class="text-center">Empresa de envíos</h3>
                                        <div class="form-group">
                                            <input class="form-control" v-model="shippingProvider">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h3 class="text-center">Número de tracking</h3>
                                        <div class="form-group">
                                            <input class="form-control" v-model="trackingNumber">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <p class="text-center">
                                            <button class="btn btn-primary" v-if="shopping.guest_user" @click="sendTracking(shopping.guest_user.email, 'guest', shopping.id)">Enviar</button>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@push("scripts")

    <script>
        
        const app = new Vue({
            el: '#dev-sales',
            data(){
                return{
                    shopping:"",
                    shoppings:[],
                    pages:0,
                    page:1,
                    trackingNumber:"",
                    shippingProvider:"",
                    loading:false,
                    showMenu:false
                }
            },
            methods:{

                show(shopping){

                    this.shopping = shopping
                    console.log(this.shopping)

                },
                fetch(page = 1){

                    this.page = page
                    this.loading= true

                    axios.get("{{ url('/sales/fetch/') }}"+"/"+page)
                    .then(res => {

                        this.loading= false
                        this.shoppings = res.data.shoppings
                        this.pages = Math.ceil(res.data.shoppingsCount / res.data.dataAmount)

                    })
                    .catch(err => {
                        $.each(err.response.data.errors, function(key, value){
                            alert(value)
                        });
                    })

                },
                dateFormatter(date){
                    
                    let year = date.substring(0, 4)
                    let month = date.substring(5, 7)
                    let day = date.substring(8, 10)
                    return day+"-"+month+"-"+year
                },
                currencyFormatDE(num) {
                    return (
                        num
                        .toFixed(2) // always two decimal digits
                        .replace('.', ',') // replace decimal point character with ,
                        .replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
                    ) // use . as a separator
                },
                toggleMenu(){

                    if(this.showMenu == false){
                        $("#menu").addClass("show")
                        this.showMenu = true
                    }else{
                        $("#menu").removeClass("show")
                        this.showMenu = false
                    }

                },
                sendTracking(email, user, paymentId){

                    if(this.trackingNumber == "" || this.shippingProvider == ""){

                        swal({
                            title:"Lo sentimos",
                            text:"Debe agregar un número de tracking y una empresa de envíos",
                            icon: "error"
                        })

                    }else{
                        this.loading = true
                        axios.post("{{ url('send/tracking') }}", {email: email, tracking: this.trackingNumber, user: user, paymentId: paymentId, shippingProvider: this.shippingProvider}).then(res => {
                            this.loading=false
                            if(res.data.success == true){

                                swal({
                                    title:"Genial",
                                    text:res.data.msg,
                                    icon: "success"
                                })

                                this.trackingNumber = ""
                                this.shippingProvider = ""
                                window.location.reload()
                            }else{

                                swal({
                                    title:"Lo sentimos",
                                    text:res.data.msg,
                                    icon: "error"
                                })

                            }

                        })
                    }
                    

                },
                toggleMenu(){

                    if(this.showMenu == false){
                        $("#menu").addClass("show")
                        this.showMenu = true
                    }else{
                        $("#menu").removeClass("show")
                        this.showMenu = false
                    }

                }


            },
            mounted(){
                
                this.fetch()

            }

        })
    
    </script>

@endpush