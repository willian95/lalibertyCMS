@extends("layouts.main")

@section("content")

    <div class="d-flex flex-column-fluid" id="dev-products">
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
                        <h3 class="card-label">Editar producto
                    </div>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body">
                    <div class="row">
                                
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">Título</label>
                                <input type="text" class="form-control" v-model="name">
                                <small v-if="errors.hasOwnProperty('name')">@{{ errors['name'][0] }}</small>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="category">Categoría</label>
                                <div style="display:flex">
                                    <select id="category" class="form-control" v-model="category">
                                        <option :value="category.id" v-for="category in categories">@{{ category.name }}</option>
                                    </select>
                                    <button class="btn btn-success" data-toggle="modal" data-target="#categoryModal">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                <small v-if="errors.hasOwnProperty('category')">@{{ errors['category'][0] }}</small>

                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="image">Imágen</label>
                                <input type="file" class="form-control" ref="file" @change="onImageChange" accept="image/*" style="overflow: hidden;">

                                <img id="blah" :src="imagePreview" class="full-image" style="margin-top: 10px; width: 40%" v-if="mainImageFileType == 'image'">
                                <video style="width: 100%;" controls v-else>
                                    <source :src="imagePreview" type="video/mp4">
                                </video>

                                <div v-if="pictureStatus == 'subiendo'" class="progress-bar progress-bar-striped" role="progressbar" aria-valuemin="0" aria-valuemax="100" :style="{'width': `${imageProgress}%`}">
                                    @{{ imageProgress }}%
                                </div>
                                
                                <p v-if="pictureStatus == 'subiendo' && imageProgress < 100">Subiendo</p>
                                <p v-if="pictureStatus == 'subiendo' && imageProgress == 100">Espere un momento</p>
                                <p v-if="pictureStatus == 'listo' && imageProgress == 100">Imágen lista</p>

                                <small v-if="errors.hasOwnProperty('image')">@{{ errors['image'][0] }}</small>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description">Descripción</label>
                                <textarea rows="3" id="editor1">{!! $product->description !!}</textarea>
                                <small v-if="errors.hasOwnProperty('description')">@{{ errors['description'][0] }}</small>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-12">
                        <h3 class="text-center">Contenido secundario <button class="btn btn-success" data-toggle="modal" data-target="#secondaryImagesModal">+</button></h3>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">

                            <table class="table table-bordered table-checkable" id="kt_datatable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Imágen</th>
                                        <th>Progreso</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(workImage, index) in workImages">
                                        <td>@{{ index + 1 }}</td>
                                        
                                        <td>
                                            <img v-if="workImage.image.indexOf('image') >= 0" :src="workImage.image" style="width: 40%;">
                                            <video style="width: 40%;" controls v-if="workImage.image.indexOf('video') >= 0">
                                                <source :src="workImage.image" type="video/mp4">
                                            </video>
                                        </td>
                                        <td>
                                            
                                            <div v-if="workImage.status == 'subiendo'" class="progress-bar progress-bar-striped" role="progressbar" aria-valuemin="0" aria-valuemax="100" :style="{'width': `${workImage.progress}%`}">
                                                @{{ workImage.progress }}%
                                            </div>
                                           
                                            <p v-if="workImage.status == 'subiendo' && workImage.progress < 100">Subiendo</p>
                                            <p v-if="workImage.status == 'subiendo' && workImage.progress == 100">Espere un momento</p>
                                            <p v-if="workImage.status == 'listo' && workImage.progress == 100">Contenido listo</p>
                                        </td>
                                        <td>
                                            <button class="btn btn-danger" @click="deleteWorkImage(index)"><i class="far fa-trash-alt"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>

    
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <h3 class="text-center">Presentaciones <button @click="create()" class="btn btn-success" data-toggle="modal" data-target="#presentationModal">+</button></h3>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-12">

                            <table class="table table-bordered table-checkable" id="kt_datatable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tamaño</th>
                                        <th>Precio</th>
                                        <th>Color</th>
                                        <th>Stock</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(productFormatSize, index) in productFormatSizes">
                                        <td>@{{ index + 1 }}</td>
                                        <td>@{{ productFormatSize.size.size }}</td>
                                        <td>$ @{{ number_format(productFormatSize.price, 2, ",", ".") }}</td>
                                        <td>@{{ productFormatSize.color.name }}</td>
                                        <td>@{{ productFormatSize.stock }}</td>
                                        <td>
                                            <button class="btn btn-info" data-toggle="modal" data-target="#presentationModal" @click="editProductFormatSizes(index)"><i class="fas fa-edit"></i></button>
                                            <button class="btn btn-danger" @click="deleteProductFormatSize(index)"><i class="far fa-trash-alt"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <p class="text-center">
                                <button class="btn btn-success" @click="update()">Actualizar</button>
                            </p>
                        </div>
                    </div>


                </div>
                <!--end::Body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->

        <!-- Modal-->
        <div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Categoría</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        
                        <div class="form-group">
                            <label for="type">Categoría</label>
                            <input type="text" class="form-control" v-model="newCategory">
                            <small v-if="categoryErrors.hasOwnProperty('category')">@{{ categoryErrors['name'][0] }}</small>
                        </div>

                        <div class="form-group">
                            <label for="type">Imágen</label>
                            <input type="file" class="form-control" ref="file" @change="onImageCategoryChange" accept="image/*">
                            <small v-if="categoryErrors.hasOwnProperty('image')">@{{ categoryErrors['image'][0] }}</small>

                            <img id="blah" :src="newCategoryPreviewPicture" class="full-image" style="margin-top: 10px; width: 40%">
                        </div>

                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Cerrar</button>
                        <button class="btn btn-success" @click="storeCategory()">Añadir</button>
                    </div>
                </div>
            </div>
        </div> 


        <!-- Modal-->
        <div class="modal fade" id="presentationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Presentación</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="type">Color</label>
                                    <div style="display:flex;">
                                        <select id="type" class="form-control" v-model="color">
                                            <option :value="color" v-for="color in colors">@{{ color.name }}</option>
                                        </select>
                                        <button class="btn btn-success" data-toggle="modal" data-target="#formatModal">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="size">Tamaño</label>
                                    <div style="display:flex;">
                                        <select id="type" class="form-control" v-model="size">
                                            <option :value="size" v-for="size in sizes">@{{ size.size }}</option>
                                        </select>
                                        <button class="btn btn-success" data-toggle="modal" data-target="#sizeModal">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="price">Precio</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" v-model="price" @keypress="isNumberDot($event)">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2">$</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="price">Stock</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" v-model="stock" @keypress="isNumberDot($event)">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Cerrar</button>
                        <button class="btn btn-success" @click="addProductFormatSizes()" v-if="action == 'create'">Añadir</button>
                        <button class="btn btn-success" @click="updateProductFormatSizes()" v-if="action == 'edit'">Actualizar</button>
                    </div>
                </div>
            </div>
        </div>  

        <!-- Modal-->
        <div class="modal fade" id="formatModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar formato</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        
                        <div class="form-group">
                            <label for="type">formato</label>
                            <input type="text" class="form-control" v-model="newColor">
                            <small v-if="formatErrors.hasOwnProperty('name')">@{{ formatErrors['name'][0] }}</small>
                        </div>

                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Cerrar</button>
                        <button class="btn btn-success" @click="storeFormat()">Añadir</button>
                    </div>
                </div>
            </div>
        </div> 

        <!-- Modal-->
        <div class="modal fade" id="sizeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar tamaño</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="type">Tamaño</label>
                                        <input type="text" class="form-control" v-model="newSize">
                                        <small v-if="sizeErrors.hasOwnProperty('size')">@{{ sizeErrors['size'][0] }}</small>
                                    </div>
                                </div>
                                

                            </div>
                        </div>

                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Cerrar</button>
                        <button class="btn btn-success" @click="storeSizes()">Añadir</button>
                    </div>
                </div>
            </div>
        </div> 

        <!-- Modal-->
        <div class="modal fade" id="secondaryImagesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Presentación</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="type">Imágen o video</label>
                                    <input type="file" class="form-control" ref="file" @change="onSecondaryImageChange" accept="image/*|video/*" style="overflow: hidden;">
                                    <img id="blah" :src="secondaryPreviewPicture" class="full-image" style="margin-top: 10px; width: 40%">

                                </div>
                            </div>

                        </div>

                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Cerrar</button>
                        <button class="btn btn-success" @click="addSecondaryImage()">Añadir</button>
                    </div>
                </div>
            </div>
        </div> 

    </div>

@endsection

@push("scripts")

    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script>
        
        const app = new Vue({
            el: '#dev-products',
            data(){
                return{
                    cloudinaryAPI:"https://api.cloudinary.com/v1_1/laliberty/upload",
                    cloudinaryPreset:"ml_default",
                    imagesToUpload:[],
                    file:"",
                    fileType:"",
                    fileName:"",
                    workImages:JSON.parse('{!! $product->secondaryImages !!}'),
                    secondaryPreviewPicture:"",
                    secondaryPicture:"",
                    id:"{{ $product->id }}",
                    categories:[],
                    colors:[],
                    sizes:[],
                    productFormatSizes:JSON.parse('{!! $product->productColorSizes !!}'),
                    price:"",
                    color:"",
                    size:"",
                    picture:"",
                    imagePreview:"{{ $product->image }}",
                    category:"{{ $product->category->id }}",
                    name:"{{ $product->name }}",
                    description:"",
                    action:"create",
                    pages:0,
                    page:1,
                    newCategory:"",
                    newCategoryPicture:"",
                    newCategoryPreviewPicture:"",
                    newColor:"",
                    newSize:"",
                    categoryErrors:[],
                    formatErrors:[],
                    sizeErrors:[],
                    errors:[],
                    loading:false,
                    stock:"",
                    productFormaSizesId:"",
                    pictureOriginalName:"",
                    pictureStatus:"",
                    finalPictureName:"",
                    imageProgress:0,
                    mainImageFileType:"{{ $product->main_image_file_type }}"
                }
            },
            methods:{
                
                create(){
                    this.action = "create"
                    this.color = ""
                    this.size = ""
                    this.stock = ""
                    this.price = ""
                },
                update(){

                    if(this.productFormatSizes.length > 0){

                        var completeUploading = true

                        this.workImages.forEach((data) => {
                            if(data.status == 'subiendo'){
                                completeUploading = false
                            }
                        })

                        if(completeUploading && this.pictureStatus != "subiendo"){

                            this.workImages.forEach((data) => {
                                if(data.hasOwnProperty("id")){
                                    this.imagesToUpload.push({id: data.id})
                                }else{
                                    this.imagesToUpload.push({type:data.type, finalName:data.finalName})
                                }
                                
                            })

                            this.loading = true
                            axios.post("{{ url('/products/update') }}", {id: this.id,name:this.name, category: this.category, image: this.picture, productFormatSizes: this.productFormatSizes, description: CKEDITOR.instances.editor1.getData(), workImages: this.imagesToUpload, mainImageFileType: this.mainImageFileType}).then(res => {
                                this.loading = false
                                if(res.data.success == true){

                                    swal({
                                        title: "Excelente!",
                                        text: "Producto actualizado!",
                                        icon: "success"
                                    }).then(function() {
                                        window.location.href = "{{ url('/products/list') }}";
                                    });
                                    

                                }else{
                                
                                    alert(res.data.msg)
                                }

                            }).catch(err => {
                                this.loading = false
                                this.errors = err.response.data.errors
                            })

                        }else{

                            swal({
                                text:"Aún hay contenido cargandose",
                                icon:"warning"
                            })

                        }
                    
                    }else{

                        swal({
                            title: "Oops!",
                            text: "Debe añadir presentaciones para continuar!",
                            icon: "warning"
                        })

                    }

                },
                onImageChange(e){
                    this.picture = e.target.files[0];

                    this.imagePreview = URL.createObjectURL(this.picture);
                    let files = e.target.files || e.dataTransfer.files;
                    if (!files.length)
                        return;
                    this.view_image = false
                    this.createImage(files[0]);
                },
                createImage(file) {

                    this.file = file
                    this.uploadMainImage()
                    let reader = new FileReader();
                    let vm = this;
                    reader.onload = (e) => {
                        vm.picture = e.target.result;
                    };
                    reader.readAsDataURL(file);
                },
                uploadMainImage(){
                    this.imageProgress = 0;
                    let formData = new FormData()
                    formData.append("file", this.file)
                    formData.append("upload_preset", this.cloudinaryPreset)

                    var _this = this
                    var fileName = this.fileName
                    this.pictureStatus = "subiendo";

                    var config = {
                        headers: { "X-Requested-With": "XMLHttpRequest" },
                        onUploadProgress: function(progressEvent) {
                            
                            var progressPercent = Math.round((progressEvent.loaded * 100.0) / progressEvent.total);
                            _this.imageProgress = progressPercent
                            
                        }
                    }

                    axios.post(
                        this.cloudinaryAPI,
                        formData,
                        config                        
                    ).then(res => {
                        
                        this.pictureStatus = "listo";
                        this.finalPictureName = res.data.secure_url

                    }).catch(err => {
                        console.log(err)
                    })

                },
                onImageCategoryChange(e){
                    this.newCategoryPicture = e.target.files[0];

                    this.newCategoryPreviewPicture = URL.createObjectURL(this.newCategoryPicture);
                    let files = e.target.files || e.dataTransfer.files;
                    if (!files.length)
                        return;
                    this.createCategoryImage(files[0]);
                },
                createCategoryImage(file) {
                    let reader = new FileReader();
                    let vm = this;
                    reader.onload = (e) => {
                        vm.newCategoryPicture = e.target.result;
                    };
                    reader.readAsDataURL(file);
                },
                storeCategory(){

                    this.loading = true
                    axios.post("{{ url('category/store') }}", {name: this.newCategory, image: this.newCategoryPicture})
                    .then(res => {
                        this.loading = false
                        if(res.data.success == true){

                            swal({
                                title: "Perfecto!",
                                text: "Haz creado una categoría!",
                                icon: "success"
                            });
                            this.newCategory = ""
                            this.newCategoryPicture = ""
                            this.newCategoryPreviewPicture=""
                            this.fetchCategories()
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
                        this.categoryErrors = err.response.data.errors
                    })

                },
                fetchCategories(){

                    axios.get("{{ url('/category/all') }}").then(res => {
    
                        this.categories = res.data.categories

                    })

                },
                storeFormat(){

                    this.loading = true
                    axios.post("{{ url('color/store') }}", {name: this.newColor})
                    .then(res => {
                        this.loading = false
                        if(res.data.success == true){

                            swal({
                                title: "Perfecto!",
                                text: "Haz creado un formato!",
                                icon: "success"
                            });
                            this.newColor = ""
                            this.fetchFormats()
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
                        this.formatErrors = err.response.data.errors
                    })
                    

                },
                fetchFormats(){
                    axios.get("{{ url('/color/all') }}").then(res => {
    
                        this.colors = res.data.colors

                    })
                },
                storeSizes(){
                    this.loading = true
                    axios.post("{{ url('size/store') }}", {name: this.newSize})
                    .then(res => {
                        this.loading = false
                        if(res.data.success == true){

                            swal({
                                title: "Genial!",
                                text: "Tamaño creado!",
                                icon: "success"
                            });
                            this.newSize = ""
                            this.fetchSizes()
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
                        this.sizeErrors = err.response.data.errors
                    })
                },
                fetchSizes(){
                    axios.get("{{ url('/size/all') }}").then(res => {
    
                        this.sizes = res.data.sizes

                    })
                },
                addProductFormatSizes(){

                    if(this.size != null && this.size != "" && this.color != null && this.color != "" && this.price != null && this.price != "" && this.stock != null && this.stock != ""){
                        this.productFormatSizes.push({size: this.size, color: this.color, price: this.price, stock: this.stock})

                        this.size = ""
                        this.color = ""
                        this.price = ""
                        this.stock = ""
                    }else{
                        swal({
                            title: "Oppss!",
                            text: "Debes completar todos los campos",
                            icon: "error"
                        });
                    }


                },
                updateProductFormatSizes(){

                    if(this.size != null && this.size != "" && this.color != null && this.color != "" && this.price != null && this.price != "" && this.stock != null && this.stock != ""){
                        
                        this.productFormatSizes[this.productFormaSizesId].color = this.color
                        this.productFormatSizes[this.productFormaSizesId].size = this.size
                        this.productFormatSizes[this.productFormaSizesId].stock = this.stock
                        this.productFormatSizes[this.productFormaSizesId].price = this.price

                        this.size = ""
                        this.color = ""
                        this.price = ""
                        this.stock = ""
                    }else{
                        swal({
                            title: "Oppss!",
                            text: "Debes completar todos los campos",
                            icon: "error"
                        });
                    }


                },
                editProductFormatSizes(index){  

                    this.action = "edit"
                    this.productFormaSizesId = index
                    this.color = this.productFormatSizes[index].color
                    this.size = this.productFormatSizes[index].size
                    this.stock = this.productFormatSizes[index].stock
                    this.price = this.productFormatSizes[index].price

                },
                deleteProductFormatSize(index){

                    this.productFormatSizes.splice(index, 1)

                },
                number_format(number, decimals, dec_point, thousands_point) {

                    if (number == null || !isFinite(number)) {
                        throw new TypeError("number is not valid");
                    }

                    if (!decimals) {
                        var len = number.toString().split('.').length;
                        decimals = len > 1 ? len : 0;
                    }

                    if (!dec_point) {
                        dec_point = '.';
                    }

                    if (!thousands_point) {
                        thousands_point = ',';
                    }

                    number = parseFloat(number).toFixed(decimals);

                    number = number.replace(".", dec_point);

                    var splitNum = number.split(dec_point);
                    splitNum[0] = splitNum[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousands_point);
                    number = splitNum.join(dec_point);

                    return number;
                },
                isNumberDot(evt) {
                    evt = (evt) ? evt : window.event;
                    var charCode = (evt.which) ? evt.which : evt.keyCode;
                    if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
                        evt.preventDefault();;
                    } else {
                        return true;
                    }
                },
                isNumber(evt) {
                    evt = (evt) ? evt : window.event;
                    var charCode = (evt.which) ? evt.which : evt.keyCode;
                    if ((charCode > 31 && (charCode < 48 || charCode > 57))) {
                        evt.preventDefault();;
                    } else {
                        return true;
                    }
                },
                onSecondaryImageChange(e){
                    this.secondaryPicture = e.target.files[0];

                    this.secondaryPreviewPicture = URL.createObjectURL(this.secondaryPicture);
                    let files = e.target.files || e.dataTransfer.files;
                    if (!files.length)
                        return;
                    this.createSecondaryImage(files[0]);
                },
                createSecondaryImage(file) {

                    this.file = file
                    this.fileType = file['type'].split('/')[0]
                    this.fileName = file['name']
                    
                    let reader = new FileReader();
                    let vm = this;
                    reader.onload = (e) => {
                        vm.secondaryPicture = e.target.result;
                    };
                    reader.readAsDataURL(file);
                },
                uploadSecondaryImage(){

                    let formData = new FormData()
                    formData.append("file", this.file)
                    formData.append("upload_preset", this.cloudinaryPreset)

                    var _this = this
                    var fileName = this.fileName
                    
                    var config = {
                        headers: { "X-Requested-With": "XMLHttpRequest" },
                        onUploadProgress: function(progressEvent) {
                            
                            var progressPercent = Math.round((progressEvent.loaded * 100.0) / progressEvent.total);
                        
                            if(_this.workImages.length > 0){

                                _this.workImages.forEach((data,index) => {
                                   if(data.originalName == fileName){
                                    _this.workImages[index].progress = progressPercent
                                   }

                                })

                            }
                            
                        }
                    }

                    axios.post(
                        this.cloudinaryAPI,
                        formData,
                        config                        
                    ).then(res => {
                        this.workImages.forEach((data, index) => {

                            if(data.originalName.toLowerCase() == res.data.original_filename.toLowerCase()+"."+res.data.format.toLowerCase()){
                                this.workImages[index].status = "listo";
                                this.workImages[index].finalName = res.data.secure_url
                            }

                        })

                    }).catch(err => {
                        console.log(err)
                    })

                },
                addSecondaryImage(){

                    if(this.secondaryPicture != null){
                        this.uploadSecondaryImage()
                        this.workImages.push({image: this.secondaryPicture, type:this.fileType, status: "subiendo", originalName:this.fileName, finalName:"", progress:0})

                        this.secondaryPicture = ""
                        this.secondaryPreviewPicture = ""

                    }else{
                        swal({
                            title: "Oppss!",
                            text: "Debes añadir una imágen o video",
                            icon: "error"
                        });
                    }


                },
                onSecondaryImageChange(e){
                    this.secondaryPicture = e.target.files[0];

                    this.secondaryPreviewPicture = URL.createObjectURL(this.secondaryPicture);
                    let files = e.target.files || e.dataTransfer.files;
                    if (!files.length)
                        return;
                    this.createSecondaryImage(files[0]);
                },
                createSecondaryImage(file) {

                    this.file = file
                    this.fileType = file['type'].split('/')[0]
                    this.fileName = file['name']
                    
                    let reader = new FileReader();
                    let vm = this;
                    reader.onload = (e) => {
                        vm.secondaryPicture = e.target.result;
                    };
                    reader.readAsDataURL(file);
                },
                uploadSecondaryImage(){

                    let formData = new FormData()
                    formData.append("file", this.file)
                    formData.append("upload_preset", this.cloudinaryPreset)

                    var _this = this
                    var fileName = this.fileName
                    
                    var config = {
                        headers: { "X-Requested-With": "XMLHttpRequest" },
                        onUploadProgress: function(progressEvent) {
                            
                            var progressPercent = Math.round((progressEvent.loaded * 100.0) / progressEvent.total);
                        
                            if(_this.workImages.length > 0){

                                _this.workImages.forEach((data,index) => {
                                   if(data.originalName == fileName){
                                    _this.workImages[index].progress = progressPercent
                                   }

                                })

                            }
                            
                        }
                    }

                    axios.post(
                        this.cloudinaryAPI,
                        formData,
                        config                        
                    ).then(res => {
                        this.workImages.forEach((data, index) => {

                            if(data.hasOwnProperty("originalName")){
                                let returnedName = res.data.original_filename.toLowerCase()
                                let returnedExtension = res.data.original_extension ? res.data.original_extension : res.data.format

                                if(data.originalName.toLowerCase() == returnedName.toLowerCase()+"."+returnedExtension.toLowerCase()){
                                    this.workImages[index].status = "listo";
                                    this.workImages[index].finalName = res.data.secure_url
                                }
                            }

                        })

                    }).catch(err => {
                        console.log(err)
                    })

                },
                addSecondaryImage(){

                    if(this.secondaryPicture != null){
                        this.uploadSecondaryImage()
                        this.workImages.push({image: this.secondaryPicture, type: this.fileType, status: "subiendo", originalName:this.fileName, finalName:"", progress:0})

                        this.secondaryPicture = ""
                        this.secondaryPreviewPicture = ""

                    }else{
                        swal({
                            title: "Oppss!",
                            text: "Debes añadir una imágen o video",
                            icon: "error"
                        });
                    }


                },
                deleteWorkImage(index){

                    this.workImages.splice(index, 1)

                },


            },
            mounted(){
                
                this.fetchCategories()
                this.fetchFormats()
                this.fetchSizes()
                CKEDITOR.replace( 'editor1' );

            }

        })
    
    </script>

@endpush