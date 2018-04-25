<template>
	<div>
		<modal :titulo="titulo">
			<template slot="modal-body">
				<form class="form-horizontal">
					<div class="form-group">
						<label for="nombre" class="control-label">Nombre:</label>
						<input type="text" name="nombre" id="nombre" placeholder="nombre" v-model="socio.nombre" class="form-control">
						<span class="help-block" v-if="errors['nombre']">
							<em>{{errors['nombre'][0]}}</em>
						</span>
					</div>
					<div class="form-group">
						<label for="logotipo" class="control-label">Logotipo</label>
						<input type="file" id="logotipo" name="logotipo" class="form-control" ref="logotipo" @change="addfile">
						<span class="help-block" v-if="errors['logotipo']">
							<em>{{errors['logotipo'][0]}}</em>
						</span>
						<!-- <vue-dropzone 
							ref="myVueDropzone" 
							id="dropzone" 
							:options="options" 
							@vdropzone-sending="guardar" 
							@vdropzone-complete="complete">
						</vue-dropzone> -->
					</div>
				</form>
			</template>
			<template slot="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
				<button type="button" class="btn btn-success" @click="guardar" v-show="show">Guardar</button>
				<button type="button" class="btn btn-success" @click="actualizar" v-show="!show">Actualizar</button>
			</template>
		</modal>

		<nav aria-label="breadcrumb">
  			<ol class="breadcrumb">
    			<li class="breadcrumb-item">
    				<a href="panel">Panel</a>
    			</li>
    			<li class="breadcrumb-item active" aria-current="page">Socios</li>
  			</ol>
		</nav>

		<navbar 
			:brand="'Socios'"
			@agregar="agregar"
			@buscar="buscar">
		</navbar>

		<div class="row">
			<div class="col-sm-4" v-for="socio in socios">
				<div class="card" style="width: 18rem;">
					<div class="card-header">{{socio.nombre}}</div>
					<img class="card-img-top" :src="`img/${socio.logotipo}`" :alt="socio.logotipo">
					<div class="card-body">
						<a href="#" class="btn btn-warning" alt="editar" @click="editar(socio)">
		    				<i class="fa fa-pencil-alt" aria-hidden="true"></i>
		    			</a>
		    			<a href="#" class="btn btn-danger" alt="eliminar" @click="eliminar(socio)">
		    				<i class="fa fa-trash" aria-hidden="true"></i>
		    			</a>
		    		</div>
		    	</div>
			</div>
		</div>
	</div>

</template>

<script>

	import {Socio, alert} from '../../clases';
	import swal from 'sweetalert2';

	export default {
		
		data() {
			return {

				show: false,

				titulo: '',

				socios: [],

				errors:{
					nombre: [],
					logotipo:[]
				},
				
				socio: new Socio(),

				pagination: {
                    total: 0, 
                    per_page: 2,
                    from: 1,
                    to: 0,
                    current_page: 1
                },
                file: ''
			}
		},

		created(){
			this.obtener(this.pagination.current_page);
		},

		methods:{

			addfile(){
				this.file = this.$refs.logotipo.files[0];
			},

			obtener(page) {
				let url = `socios/create?page=${page}`;
				axios.get(url).then(response => {
					this.pagination = response.data.pagination;
					this.socios = response.data.data.data;
				});
			},

			editar(socio) {
				this.titulo = 'Editar';
				this.show = false;
				this.socio = new Socio(socio.nombre, socio.descripcion, socio.caratula, socio.estatus, socio.id);
				$("#modal").modal();
			},

			eliminar(socio) {
				let url = `socios/${socio.id}`;
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

			agregar() {
				this.socio = new Socio();
				this.show = true;
				this.titulo = 'Agregar';
				$("#modal").modal();
			},

			guardar() {
				if(this.validar(this.socio)){
					const formData = new FormData();
					formData.append('nombre', this.socio.nombre);
					formData.append('file', this.file);
					axios.post('socios', formData).then(response => {
						$('#modal').modal('hide');
						alert(response.data, 'success');
						this.obtener(this.pagination.current_page)
					});
				}
			},

			actualizar(){
				let url = `socios/${this.socio.id}`;
				const formData = new FormData();
				formData.append('nombre', this.socio.nombre);
				formData.append('descripcion', this.socio.descripcion);
				formData.append('file', this.file);
				axios.post(url, formData).then(response => {
					alert(response.data, 'success');
					$("#modal").modal('hide');
					this.obtener(this.pagination.current_page)
				});
			},

			buscar(elemento){
				let url = 'socios/buscar';
				axios.post(url, {'nombre': elemento}).then(response => {
                    if(elemento)
                        this.socios = response.data;
                    else
                        this.obtener(this.pagination.current_page);
                });
			},

			changePage(page) {
                this.pagination.current_page = page;
                this.obtener(page);
            },

			validar(socio){
				
				if(!socio.nombre){
					this.errors['nombre'] = [];	
					this.errors['nombre'].push('Agregar nombre');
					return false;
				} else {
					this.errors['nombre'] = [];	
				}
					
				if(!this.file) {
					this.errors['logotipo'] = [];
					this.errors['logotipo'].push('Agregar logotipo');
					return false;
				} else {
					this.errors['logotipo'] = [];
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