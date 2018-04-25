<template>

	<div>
		<!--Componente modal de boostrap para agregar y editar-->
		<modal :titulo="titulo">
			<template slot="modal-body">
				<form class="form-horizontal">
					<div class="form-group">
						<label for="titulo" class="control-label">Titulo:</label>
						<input type="text" name="titulo" id="titulo" placeholder="titulo" v-model="noticia.titulo" class="form-control">
						<span class="help-block" v-if="errors['titulo']">
							<em>{{errors['titulo'][0]}}</em>
						</span>
					</div>
					<div class="form-group">
						<label for="tema" class="control-label">Tema:</label>
						<input type="text" name="tema" id="tema" placeholder="tema" v-model="noticia.tema" class="form-control">
						<span class="help-block" v-if="errors['tema']">
							<em>{{errors['tema'][0]}}</em>
						</span>
					</div>
					<div class="form-group">
						<label for="contenido" class="control-label">Contenido:</label>
						<textarea type="text" name="contenido" id="contenido" placeholder="contenido" v-model="noticia.contenido" class="form-control" rows="4" style="resize: none"></textarea>	
						<span class="help-block" v-if="errors['contenido']">
							<em>{{errors['contenido'][0]}}</em>
						</span>
					</div>
					<div class="form-group">
						<label for="Caratula" class="control-label">Caratula:</label>
						<input type="file" name="file" ref="file" @change="prueba" class="form-control">
						<img :src="`img/${noticia.caratula}`" v-if="noticia.caratula">
						<span class="help-block" v-if="errors['caratula']">
							<em>{{errors['caratula'][0]}}</em>
						</span>
					</div>
				</form>
			</template>
			<template slot="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
				<button type="button" class="btn btn-success" @click="guardar" v-show="show">Guardar</button>
				<button type="button" class="btn btn-success" @click="actualizar" v-show="!show">Actualizar</button>
			</template>
		</modal>

		<!-- Modal para mostrar el contenido de la noticia -->
		<div class="modal" tabindex="-1" role="dialog" id="content">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
	  				<div class="modal-header">
	    				<h5 class="modal-title">Contenido</h5>
	    				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	      					<span aria-hidden="true">&times;</span>
	    				</button>
	  				</div>
	  				<div class="modal-body">
	  					{{contenido}}
	  				</div>
	  				<div class="modal-footer">
	    				<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
	  				</div>
				</div>
			</div>
		</div>
		
		<nav aria-label="breadcrumb">
  			<ol class="breadcrumb">
    			<li class="breadcrumb-item">
    				<a href="panel">Panel</a>
    			</li>
    			<li class="breadcrumb-item active" aria-current="page">Noticias</li>
  			</ol>
		</nav>

		<!--Barra de navegacion-->
		<navbar 
			:brand="'Noticias'"
			@agregar="agregar"
			@buscar="buscar">
		</navbar>

		<!-- tabla para mostrar los registro-->
		<div class="row">
			<div class="col-sm-3" v-for="noticia in noticias">
				<div class="card" style="width: 18rem;">
					<div class="card-header">{{noticia.titulo}}</div>
		  			<img class="card-img-top" :src="`img/${noticia.caratula}`" :alt="noticia.titulo">
		  			<div class="card-body">
		    			<h5 class="card-title">{{noticia.tema}}</h5>
		    			<h6 class="card-subtitle mb-2 text-muted">{{noticia.created_ad}}</h6>
		    			<p class="card-text">{{noticia.created_at}}</p>
		    			<a href="#" class="btn btn-info" alt="ver" @click="ver(noticia)">
		    				<i class="fa fa-eye" aria-hidden="true"></i>
		    			</a>
		    			<a href="#" class="btn btn-warning" alt="editar" @click="editar(noticia)">
		    				<i class="fa fa-pencil-alt" aria-hidden="true"></i>
		    			</a>
		    			<a href="#" class="btn btn-danger" alt="eliminar" @click="eliminar(noticia)">
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

	import {Noticia, alert, limpiar_errores} from '../../clases'
	import swal from 'sweetalert2';

	export default {
		
		data() {
			return {

				contenido: '',

				show: false,

				titulo: '',

				noticias: [],

				errors:{
					caratula:[],
					titulo:[],
					tema:[],
					contenido:[],
				},
				
				noticia: new Noticia(),

				pagination: {
                    total: 0, 
                    per_page: 2,
                    from: 1,
                    to: 0,
                    current_page: 1
                },

                file: '',
			}
		},

		created(){
			this.obtener(this.pagination.current_page);
		},

		methods:{

			prueba(){
				this.file = this.$refs.file.files[0];
			},

			ver(noticia){
				this.contenido  = noticia.contenido;
				$('#content').modal();
			},

			obtener(page) {
				let url = `noticias/create?page=${page}`;
				axios.get(url).then(response => {
					this.pagination = response.data.pagination;
					this.noticias = response.data.data.data;
				});
			},

			editar(noticia) {
				limpiar_errores(this.errors);
				this.titulo = 'Editar';
				this.show = false;
				this.noticia = new Noticia(noticia.caratula, noticia.titulo, noticia.tema , noticia.contenido, noticia.created_at, noticia.id);
				$("#modal").modal();
			},

			eliminar(noticia) {
				let url = `noticias/${noticia.id}`;
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
				limpiar_errores(this.errors);
				this.noticia = new Noticia();
				this.show = true;
				this.titulo = 'Agregar';
				$("#modal").modal();
			},

			guardar() {
				if(this.validar(this.noticia)){
					const formData = new FormData();
					formData.append('file', this.file);
					formData.append('titulo', this.noticia.titulo);
					formData.append('tema', this.noticia.tema);
					formData.append('contenido', this.noticia.contenido);
					axios.post('noticias', formData).then(response => {
						$("#modal").modal('hide');	
						this.obtener(this.pagination.current_page);
					})
					.catch(error => {
						this.errors = error.response.data.errors;
					});
				}
			},

			complete(file, status, xhr){
				file = null;
				this.obtener(this.pagination.current_page);
			},

			actualizar(){
				let url = `noticias/${this.noticia.id}`;
				const formData = new FormData();
				formData.append('file', this.file);
				formData.append('titulo', this.noticia.titulo);
				formData.append('tema', this.noticia.tema);
				formData.append('contenido', this.noticia.contenido);
				if(this.validar(this.noticia)){
					axios.post(url, formData).then(response => {
						$("#modal").modal('hide');
						alert(response.data, 'success');
						this.obtener(this.pagination.current_page);
					}).catch(error => {
						this.errors = error.response.data.errors;
					});
				}
			},

			buscar(elemento){
				let url = 'noticias/buscar';
				axios.post(url, {'nombre': elemento}).then(response => {
                    if(elemento)
                        this.noticias = response.data;
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

			validar(noticia) {
				if(!noticia.titulo) {
					this.errors['titulo'].push('Agregar titulo');
					return false;
				} else {
					this.errors['titulo'] = [];
				}

				if(!noticia.tema){
					this.errors['tema'].push('Agregar tema');
					return false;
				} else {
					this.errors['tema'] = [];
				}

				if(!noticia.contenido){
					this.errors['contenido'].push('Agregar contenido');
					return false;
				} else {
					this.errors['contenido'] = [];
				}

				if(!this.file){
					this.errors['caratula'].push('Agregar caratula');
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
	span {
		color: red;
	}
</style>