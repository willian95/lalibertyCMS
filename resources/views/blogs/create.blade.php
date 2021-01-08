@extends("layouts.main")

@section("content")

    <div class="d-flex flex-column-fluid">
        
        <!--begin::Container-->
        <div class="container">
            <!--begin::Card-->
            <div class="card card-custom">
                <!--begin::Header-->
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h3 class="card-label">Crear Blog
                    </div>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body">
                    <div class="row" id="dev-products">
                        
                        <div class="loader-cover-custom" v-if="loading == true">
                            <div class="loader-custom"></div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title">Título</label>
                                <input type="text" class="form-control" v-model="title">
                                <small v-if="errors.hasOwnProperty('title')">@{{ errors['title'][0] }}</small>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="image">Imágen</label>
                                <input type="file" class="form-control" ref="file" @change="onImageChange" accept="image/*" style="overflow: hidden;">

                                <img id="blah" :src="imagePreview" class="full-image" style="margin-top: 10px; width: 40%">
                                <small v-if="errors.hasOwnProperty('image')">@{{ errors['image'][0] }}</small>
                            </div>
                        </div>

                        <button style="display:none" @click="store()" id="create-click"></button>

                    </div>
                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description">Descripción</label>
                                <textarea rows="3" id="editor1"></textarea>
                                
                            </div>
                        </div>

                    </div>


                    <div class="row">
                        <div class="col-12">
                            <p class="text-center">
                                <button class="btn btn-success" onclick="create()">Crear</button>
                            </p>
                        </div>
                    </div>


                </div>
                <!--end::Body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->


    </div>

@endsection

@push("scripts")

    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace( 'editor1' );

        function create(){
            $("#create-click").click()
        }

    </script>

    <script>
        
        const app = new Vue({
            el: '#dev-products',
            data(){
                return{
                    picture:"",
                    imagePreview:"",
                    title:"",
                    description:"",
                    errors:[],
                    createdDate:"",
                    loading:false,
                }
            },
            methods:{
                
                store(){

                    
                    this.description = CKEDITOR.instances.editor1.getData()

                    if(this.description == ""){

                        swal({
                            text: "Debes agregar una descripción",
                            icon: "error"
                        })

                    }else{

                        this.loading = true
                        axios.post("{{ url('/blogs/store') }}", {title:this.title, image: this.picture, description: this.description, createdDate: this.createdDate}).then(res => {
                        this.loading = false
                            if(res.data.success == true){

                                swal({
                                    title: "Excelente!",
                                    text: "Blog creado!",
                                    icon: "success"
                                }).then(function() {
                                    window.location.href = "{{ url('/blogs/list') }}";
                                });
                                

                            }else{
                                
                                alert(res.data.msg)
                            }

                        }).catch(err => {
                            this.loading = false
                            this.errors = err.response.data.errors
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
                    let reader = new FileReader();
                    let vm = this;
                    reader.onload = (e) => {
                        vm.picture = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }

            }
        })
    
    </script>

@endpush