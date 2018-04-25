<template>
	<div>
		<!--Componente modal de boostrap para agregar y editar-->
		<modal :titulo="titulo">
			<template slot="modal-body">
				<form class="form-horizontal">

					<div class="form-group">
						<label for="nombre" class="control-label">Nombre:</label>
						<input type="text" name="nombre" id="nombre" placeholder="nombre" v-model="subasta.nombre" class="form-control">
						<span class="help-block" v-if="errors['nombre']">
							<em>{{errors['nombre'][0]}}</em>
						</span>
					</div>

					<div class="form-group">
						<label for="descripcion" class="control-label">Descrípcion:</label>
						<textarea name="descripcion" id="descripcion" placeholder="descripcion" v-model="subasta.descripcion" class="form-control" rows="5"></textarea>
						<span class="help-block" v-if="errors['descripcion']">
							<em>{{errors['descripcion'][0]}}</em>
						</span>
					</div>

					<form class="form-horizontal">
						<div class="form-group">
							<label for="caratula" class="control-label">Caratula</label>
							<input type="file" name="caratula" ref="caratula" id="caratula" class="form-control" @change="addfile">
							<span class="help-block" v-if="errors['caratula']">
								<em>{{errors['caratula'][0]}}</em>
							</span>
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

		<!-- Barra de navegacion -->
		<nav aria-label="breadcrumb">
  			<ol class="breadcrumb">
    			<li class="breadcrumb-item">
    				<a href="panel">Panel</a>
    			</li>
    			<li class="breadcrumb-item active" aria-current="page">Subastas</li>
  			</ol>
		</nav>

		<!--Barra de navegacion-->
		<navbar 
			:brand="'Subastas'"
			@agregar="agregar"
			@buscar="buscar">
		</navbar>

		<!-- tabla para mostrar los registro-->
		<div class="row">
			<div class="col-sm-3" v-for="subasta in subastas">
				<div class="card text-center" style="width: 18rem;">
					<div class="card-header">{{subasta.nombre}}</div>
					<img class="card-img-top" :src="`img/${subasta.caratula}`" :alt="`${subasta.caratula}`">
		  			<div class="card-body">    
		  				<h5 class="card-title">{{subasta.status}}</h5>
		    			<p class="card-text">{{subasta.descripcion}}</p>
		    			<div class="btn-group">
			    			<button class="btn btn-info btn-sm">
			    				<i class="fa fa-eye" aria-hidden="true"></i>
			    			</button>
			    			<button class="btn btn-warning btn-sm" alt="editar" @click="editar(subasta)">
			    				<i class="fa fa-pencil-alt" aria-hidden="true"></i>
			    			</button>
			    			<button class="btn btn-danger btn-sm" alt="eliminar" @click="eliminar(subasta)">
			    				<i class="fa fa-trash" aria-hidden="true"></i>
			    			</button>
		    			</div>
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

	import {Subasta, alert, limpiar_errores} from '../../clases'
	import swal from 'sweetalert2';
	import 'vue2-dropzone/dist/vue2Dropzone.css'

	export default {
		
		data() {
			return {

				file: '',

				show: false,

				titulo: '',

				subastas: [],

				errors:{
					nombre:[],
					descripcion:[],
					caratula:[]
				},
				
				subasta: new Subasta(),

				pagination: {
                    total: 0, 
                    per_page: 2,
                    from: 1,
                    to: 0,
                    current_page: 1
                }
          	}
		},

		created(){
			this.obtener(this.pagination.current_page);
		},

		methods:{

			addfile(){
				this.file = this.$refs.caratula.files[0];
			},

			obtener(page) {
				let url = `subastas/create?page=${page}`;
				axios.get(url).then(response => {
					this.pagination = response.data.pagination;
					this.subastas = response.data.data.data;
				});
			},

			editar(subasta) {
				limpiar_errores(this.errors);
				this.titulo = 'Editar';
				this.show = false;
				this.subasta = new Subasta(subasta.nombre, subasta.descripcion, subasta.caratula, subasta.estatus, subasta.id);
				$("#modal").modal();
			},

			eliminar(subasta) {
				let url = `subastas/${subasta.id}`;
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
				let url = 'subastas';
				limpiar_errores(this.errors);
				this.subasta = new Subasta();
				this.show = true;
				this.titulo = 'Agregar';
				$("#modal").modal();
			},

			guardar() {
				if(this.validar(this.subasta)){
					const formData = new FormData();
					formData.append('nombre', this.subasta.nombre);
					formData.append('descripcion', this.subasta.descripcion);
					formData.append('file', this.file);
					axios.post('subastas',formData).then(response => {
						$("#modal").modal('hide');
						alert(response.data, 'success');
						this.obtener(this.pagination.current_page);
					});
				}
			},

			actualizar(){
				let url = `subastas/${this.subasta.id}`;
				if(this.validar(this.subasta)){
					const formData = new FormData();
					formData.append('nombre', this.subasta.nombre);
					formData.append('descripcion', this.subasta.descripcion);
					formData.append('file', this.file);
					axios.post(url, formData).then(response => {
						$("#modal").modal('hide');
						alert(response.data, 'success');
						this.obtener(this.pagination.current_page);
					}).catch(error => {
						this.errors['password'] = error.response.data.errors['password'];
					});
				}

			},

			buscar(elemento){
				let url = 'subastas/buscar';
				axios.post(url, {'nombre': elemento}).then(response => {
                    if(elemento)
                        this.subastas = response.data;
                    else
                        this.obtener(this.pagination.current_page);
                });
			},

			changePage(page) {
                //$("#tbody").fadeOut('fast');
                this.pagination.current_page = page;
                this.obtener(page);
                //$("#tbody").fadeIn('fast');
            },

			validar(subasta){
				
				if(!subasta.nombre){
					this.errors['nombre'].push('Agregar nombre');
					return false;
				} else {
					this.errors['nombre'] = [];	
				}
				
				if(!subasta.descripcion) {
					this.errors['descripcion'].push('Agregar descripcion');
					return false;
				} else {
					this.errors['descripcion'] = [];
				}

				if(!this.file){
					this.errors['caratula'].push('Agregar una imagen');
					return false;
				} else {
					this.errors['caratula'] = [];
				}

				return true;
			}
		}
	}
</script>

<style scoped>
	
	span{
		color: red;
	}

	textarea {
		resize: none;
	}
</style>