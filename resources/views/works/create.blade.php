@extends("layouts.main")

@section("content")
    @cloudinaryJS
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
                        <h3 class="card-label">Crear Work
                    </div>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body">
                    
                        <div class="row">
                                    
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="title">Título</label>
                                        <input type="text" class="form-control" v-model="title" name="title">
                                        <small v-if="errors.hasOwnProperty('title')">@{{ errors['title'][0] }}</small>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="title">Nombre del cliente</label>
                                        <input type="text" class="form-control" v-model="clientName" name="clientName">
                                        <small v-if="errors.hasOwnProperty('clientName')">@{{ errors['clientName'][0] }}</small>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="title">Fecha de creación</label>
                                        <input type="date" class="form-control" v-model="createdDate" name="createdDate">
                                        <small v-if="errors.hasOwnProperty('createdDate')">@{{ errors['createdDate'][0] }}</small>
                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="image">Imágen</label>
                                        <input type="file" class="form-control" ref="file" @change="onImageChange" accept="image/*" style="overflow: hidden;" name="image">

                                        <img id="blah" :src="imagePreview" class="full-image" style="margin-top: 10px; width: 40%">

                                        <div v-if="pictureStatus == 'subiendo'" class="progress-bar progress-bar-striped" role="progressbar" aria-valuemin="0" aria-valuemax="100" :style="{'width': `${imageProgress}%`}">
                                                @{{ imageProgress }}%
                                            </div>
                                        
                                        <p v-if="pictureStatus == 'subiendo' && imageProgress < 100">Subiendo</p>
                                        <p v-if="pictureStatus == 'subiendo' && imageProgress == 100">Espere un momento</p>
                                        <p v-if="pictureStatus == 'listo' && imageProgress == 100">Imágen lista</p>

                                        <small v-if="errors.hasOwnProperty('image')">@{{ errors['image'][0] }}</small>
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="description">Descripción</label>
                                        <textarea v-model="description" id="description" class="form-control" rows="3" name="description"></textarea>
                                        <small v-if="errors.hasOwnProperty('description')">@{{ errors['description'][0] }}</small>
                                    </div>
                                </div>

                                <div class="col-md-4" style="padding-top: 20px;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="defaultCheck1" v-model="isFashionMerch" name="isFashionMerch">
                                        <label class="form-check-label" for="defaultCheck1">
                                            Activar como Fashion Merch
                                        </label>
                                    </div>
                                </div>
                          
                            

                        </div>
                   
                    <div class="row">
                        <div class="col-12">
                            <h3 class="text-center">Imágenes secundarias <button @click="create()" class="btn btn-success" data-toggle="modal" data-target="#presentationModal">+</button></h3>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-12">

                            <table class="table table-bordered table-checkable" id="kt_datatable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Imagen</th>
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
                                            <p v-if="workImage.status == 'listo' && workImage.progress == 100">Imágen lista</p>
                                        </td>
                                        <td>
                                            <button class="btn btn-danger" @click="deleteWorkImage(index)"><i class="far fa-trash-alt"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>

                        <div class="col-12">
                            <p class="text-center">
                                <button class="btn btn-success" @click="store()">Crear</button>
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
                        <button class="btn btn-success" @click="addProductFormatSizes()">Añadir</button>
                    </div>
                </div>
            </div>
        </div>  


    </div>

@endsection

@push("scripts")

    <script>
        
        const app = new Vue({
            el: '#dev-products',
            data(){
                return{
                    cloudinaryAPI:"https://api.cloudinary.com/v1_1/laliberty/upload",
                    cloudinaryPreset:"ml_default",
                    workImages:[],
                    imagesToUpload:[],
                    picture:"",
                    imagePreview:"",
                    clientName:"",
                    title:"",
                    createdDate:"",
                    isFashionMerch:false,
                    description:"",
                    action:"create",
                    secondaryPicture:"",
                    secondaryPreviewPicture:"",
                    errors:[],
                    loading:false,
                    file:"",
                    fileType:"",
                    fileName:"",
                    pictureOriginalName:"",
                    pictureStatus:"",
                    finalPictureName:"",
                    imageProgress:0
                }
            },
            methods:{
                
                create(){
                    this.action = "create"
                    this.secondaryPicture = ""
                    this.secondaryPreviewPicture = ""
                },
                store(){

                    if(this.workImages.length > 0){
                        
                        var completeUploading = true

                        this.workImages.forEach((data) => {
                            if(data.status == 'subiendo'){
                                completeUploading = false
                            }
                        })
                        
                        if(completeUploading && this.pictureStatus == "listo"){
                            this.loading = true

                            this.workImages.forEach((data) => {
                                this.imagesToUpload.push({type:data.type, finalName:data.finalName})
                            })
 
                            axios.post("{{ url('/works/store') }}", {title:this.title, image: this.finalPictureName, workImages: this.imagesToUpload, description: this.description, clientName: this.clientName, isFashionMerch: this.isFashionMerch, createdDate: this.createdDate}).then(res => {
                                this.loading = false
                                if(res.data.success == true){

                                    swal({
                                        title: "Excelente!",
                                        text: "Work creado!",
                                        icon: "success"
                                    }).then(function() {
                                        window.location.href = "{{ url('/works/list') }}";
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
                                text:"Aún hay imágenes cargandose",
                                icon:"warning"
                            })
                        }
                    
                    }else{

                        swal({
                            title: "Oops!",
                            text: "Debe añadir imagenes secundarias para continuar!",
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
                            
                            console.log("test", data, res.data)
                            console.log("name", data.originalName.toLowerCase(), res.data.original_filename+"."+res.data.format.toLowerCase())

                            if(data.originalName.toLowerCase() == res.data.original_filename.toLowerCase()+"."+res.data.format.toLowerCase()){
                                this.workImages[index].status = "listo";
                                this.workImages[index].finalName = res.data.secure_url
                            }

                        })

                    }).catch(err => {
                        console.log(err)
                    })

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
                addProductFormatSizes(){

                    if(this.secondaryPicture != null){
                        this.uploadSecondaryImage()
                        this.workImages.push({image: this.secondaryPicture, status: "subiendo", type:this.fileType, originalName:this.fileName, finalName:"", progress:0})

                        this.secondaryPicture = ""
                        this.secondaryPreviewPicture = ""
 
                    }else{
                        swal({
                            title: "Oppss!",
                            text: "Debes añadir una imágen",
                            icon: "error"
                        });
                    }
                    

                },
                deleteWorkImage(index){

                    this.workImages.splice(index, 1)

                },



            }
        })
    
    </script>

@endpush