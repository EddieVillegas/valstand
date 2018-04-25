<template>
	<div>
		<!--Componente modal de boostrap para agregar y editar-->
		<modal :titulo="titulo">
			<template slot="modal-body">
				<form class="form-horizontal">

					<div class="form-group">
						<label for="nombre" class="control-label">Nombre:</label>
						<input type="text" name="nombre" id="nombre" placeholder="nombre" v-model="proyecto.nombre" class="form-control">
						<span class="help-block" v-if="errors['nombre']">
							<em>{{errors['nombre'][0]}}</em>
						</span>
					</div>

					<div class="form-group">
						<label for="descripcion" class="control-label">Descrípcion:</label>
						<textarea name="descripcion" id="descripcion" placeholder="descripcion" v-model="proyecto.descripcion" class="form-control" rows="5"></textarea>
						<span class="help-block" v-if="errors['descripcion']">
							<em>{{errors['descripcion'][0]}}</em>
						</span>
					</div>

					<form class="form-horizontal">
						<div class="form-group">
							<vue-dropzone 
								ref="myVueDropzone" 
								id="dropzone" 
								:options="options" 
								@vdropzone-sending="guardar" 
								@vdropzone-complete="complete" 
								@vdropzone-removed-file="del">
							</vue-dropzone>
						</div>
					</form>

				</form>
			</template>
			<template slot="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
				<button type="button" class="btn btn-success" @click="guardar" v-show="show">Guardar</button>
				<button type="button" class="btn btn-success" @click="actualizar" v-show="!show">Actualizar</button>
			</template>
		</modal>

		<!-- Mostrar y Agregar Imagenes -->
		<div class="modal" tabindex="-1" role="dialog" id='imagenes'>
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Imagenes</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
							<div class="carousel-inner">
								<div :class="[{'carousel-item': true}, index == 0 ? 'active' : '']" v-for="(imagen, index) in proyecto.imagenes">
									<img class="d-block w-100" :src="`img/${imagen.nombre}`" :alt="`${imagen.nombre}`">
								</div>
							</div>
		  					<a class="carousel-control-prev" href="#carouselExampleControls" role="button"data-slide="prev">
		    					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
		    					<span class="sr-only">Previous</span>
		  					</a>
		  					<a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
		    					<span class="carousel-control-next-icon" aria-hidden="true"></span>
		    					<span class="sr-only">Next</span>
		  					</a>
			  			</div>
					</div>
		    	</div>
		    </div>
		</div>

		<!-- Barra de navegacion -->
		<nav aria-label="breadcrumb">
  			<ol class="breadcrumb">
    			<li class="breadcrumb-item">
    				<a href="panel">Panel</a>
    			</li>
    			<li class="breadcrumb-item active" aria-current="page">Proyectos</li>
  			</ol>
		</nav>

		<!--Barra de navegacion-->
		<navbar 
			:brand="'Proyectos'"
			@agregar="agregar"
			@buscar="buscar">
		</navbar>

		<!-- tabla para mostrar los registro-->
		<div class="row">
			<div class="col-sm-3" v-for="proyecto in proyectos">
				<div class="card text-center" style="width: 18rem;">
					<div class="card-header">{{proyecto.nombre}}</div>
		  			<div class="card-body">
		    			<p class="card-text">{{proyecto.descripcion}}</p>
		    			<a href="#" class="btn btn-info" alt="ver imagenes" @click="ver(proyecto)">
		    				<i class="fas fa-images"></i>
		    			</a>
		    			<a href="#" class="btn btn-warning" alt="editar" @click="editar(proyecto)">
		    				<i class="fa fa-pencil-alt" aria-hidden="true"></i>
		    			</a>
		    			<a href="#" class="btn btn-danger" alt="eliminar" @click="eliminar(proyecto)">
		    				<i class="fa fa-trash" aria-hidden="true"></i>
		    			</a>
		  			</div>
				</div>
			</div>
		</div>

		<!-- Paginator -->
		<paginator
			:pagination="pagination" :offset='8' @changepage="changePage">
		</paginator>

	</div>
</template>

<script>

	import {Proyecto, alert} from '../../clases'
	import swal from 'sweetalert2';
	import 'vue2-dropzone/dist/vue2Dropzone.css'

	export default {
		
		data() {
			return {

				show: false,

				titulo: '',

				proyectos: [],

				errors:{
					nombre:[],
					descripcion:[],
				},
				
				proyecto: new Proyecto(),

				pagination: {
                    total: 0, 
                    per_page: 2,
                    from: 1,
                    to: 0,
                    current_page: 1
                },

                 options: {
        		 	url: 'proyectos',
          			thumbnailWidth: 200,
          			maxFilesize: 1,
          			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          			dictDefaultMessage: "<i class='fas fa-cloud-upload-alt'></i>Cargar imagenes del proyecto...",
          			uploadMultiple: true,
          			parallelUploads: 5,
          			maxfilesreached: 5,
          			addRemoveLinks: true,
          			dictRemoveFile: 'Eliminar',
          			dictMaxFilesExceeded: 'No puedes subir mas de 5 Imagenes',
          			acceptedFileTypes: '.jpg,.png'
          		}
          	}
		},

		created(){
			this.obtener(this.pagination.current_page);
		},

		methods:{

			del(file, error, xhr){
				//this.$refs.myVueDropzone.removeAllFiles();
				// let url = `imagenes/${file.id}`;
				// axios.delete(url).then(response => {
				// 	this.obtener(this.pagination.current_page);
				// 	this.cargarImagenes(this.proyecto);
				// });
				console.log(file.id);
			},

			ver(proyecto){
				this.proyecto = proyecto;
				$("#imagenes").modal();
			},

			obtener(page) {
				let url = `proyectos/create?page=${page}`;
				axios.get(url).then(response => {
					this.pagination = response.data.pagination;
					this.proyectos = response.data.data.data;
				});
			},

			editar(proyecto) {
				this.titulo = 'Editar';
				this.show = false;
				this.proyecto = new Proyecto(proyecto.nombre, proyecto.descripcion, proyecto.imagenes, proyecto.id);
				this.$refs.myVueDropzone.removeAllFiles();
				this.cargarImagenes(this.proyecto);
				this.$refs.myVueDropzone.setOption('url', `proyectos/${proyecto.id}`);
				$("#modal").modal();
			},

			cargarImagenes(proyecto){
				let file = { 
					size: 123, 
					name: 'icon'
				}, url = '';
				// for(let imagen of proyecto.imagenes){
				// 	file.name = imagen.nombre;
				// 	file.id = imagen.id;
				// 	url = `img/${imagen.nombre}`;
				// }
				this.$refs.myVueDropzone.manuallyAddFile(file, url);
				//this.$refs.myVueDropzone.manuallyAddFile(file, url);
			},

			eliminar(proyecto) {
				let url = `proyectos/${proyecto.id}`;
				swal({
					title: 'Estas seguro?',
					text: "Esta accion no podra revertirse!",
				  	type: 'warning',
				  	showCancelButton: true,
				  	confirmButtonColor: '#3085d6',
				  	cancelButtonColor: '#d33',
				  	confirmButtonText: 'Si, eliminar!',
				  	cancelButtonText: 'No, cancelar!',
				  	confirmButtonClass: 'btn btn-success',
				  	cancelButtonClass: 'btn btn-danger',
				  	buttonsStyling: false,
				  	reverseButtons: true
				  }).then((result) => {
				  	if (result.value) {
				  		axios.delete(url).then(response => {
				  			alert(response.data, 'success');
				  			this.obtener(this.pagination.current_page);
						});
				  } else if (
				    result.dismiss === swal.DismissReason.cancel
				  ) {
				    alert('Accion cancelada', 'error');
				  }
				})
			},

			agregar(){
				let url = 'proyectos';
				this.proyecto = new Proyecto();
				this.show = true;
				this.titulo = 'Agregar';
				$("#modal").modal();
				this.$refs.myVueDropzone.setOption('url', url);
				this.$refs.myVueDropzone.removeAllFiles();
			},

			guardar(file, xhr, formData) {
				formData.append('nombre', this.proyecto.nombre);
				formData.append('descripcion', this.proyecto.descripcion);
			},

			complete(file){
				this.obtener(this.pagination.current_page);
			},

			actualizar(){
				let url = `proyectos/${this.proyecto.id}`;
				if(this.validar(this.proyecto)){
					axios.put(url, this.proyecto).then(response => {
						$("#modal").modal('hide');
						alert(response.data, 'success');
						this.obtener(this.pagination.current_page);
					}).catch(error => {
						this.errors['password'] = error.response.data.errors['password'];
					});
				}

			},

			buscar(elemento){
				let url = 'proyectos/buscar';
				axios.post(url, {'nombre': elemento}).then(response => {
                    if(elemento)
                        this.proyecto = response.data;
                    else
                        this.obtener(this.pagination.current_page);
                });
			},

			changePage(page) {
                $("#tbody").fadeOut('fast');
                this.pagination.current_page = page;
                this.obtener(page);
                $("#tbody").fadeIn('fast');
            },

			validar(proyecto){
				
				if(!proyecto.nombre){
					this.errors['nombre'].push('Agregar nombre');
					return false;
				} else {
					this.errors['nombre'] = [];	
				}
				
				if(!proyecto.descripcion) {
					this.errors['descripcion'].push('Agregar descripcion');
					return false;
				} else {
					this.errors['descripcion'] = [];
				}

				return true;
			}
		}
	}
</script>

<style scoped>
	textarea {
		resize: none;
	}
</style>