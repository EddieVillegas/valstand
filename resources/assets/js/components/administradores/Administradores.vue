<template>
	<div class="table-resposive">

		<!--Componente modal de boostrap para agregar y editar-->
		<modal :titulo="titulo">
			<template slot="modal-body">
				<form class="form-horizontal">
					<div class="form-group">
						<label for="nombre" class="control-label">Nombre:</label>
						<input type="text" name="nombre" id="nombre" placeholder="nombre del administrador" v-model="administrador.nombre" class="form-control">
						<span class="help-block" v-if="errors['nombre']">
							<em>{{errors['nombre'][0]}}</em>
						</span>
					</div>
					<div class="form-group">
						<label for="apellido_paterno" class="control-label">Apellido Paterno:</label>
						<input type="text" name="apellido_paterno" id="apellido_paterno" placeholder="apellido paterno del administrador" v-model="administrador.apellido_paterno" class="form-control">
						<span class="help-block" v-if="errors['apellido_paterno']">
							<em>{{errors['apellido_paterno'][0]}}</em>
						</span>
					</div>
					<div class="form-group">
						<label for="apellido_materno" class="control-label">Apellido Materno:</label>
						<input type="text" name="apellido_materno" id="apellido_materno" placeholder="apellido materno del administrador" v-model="administrador.apellido_materno" class="form-control">
						<span class="help-block" v-if="errors['apellido_materno']">
							<em>{{errors['apellido_materno'][0]}}</em>
						</span>
					</div>
					<div class="form-group">
						<label for="usuario" class="control-label">Usuario:</label>
						<input type="text" name="usuario" id="usuario" placeholder="nombre de usuario" v-model="administrador.usuario" class="form-control">
						<span class="help-block" v-if="errors['usuario']">
							<em>{{errors['usuario'][0]}}</em>
						</span>
					</div>
					<div class="form-group">
						<label for="email" class="control-label">Email:</label>
						<input type="email" name="email" id="email" placeholder="email" v-model="administrador.email" class="form-control">
						<span class="help-block" v-if="errors['email']">
							<em>{{errors.email[0]}}</em>
						</span>
					</div>
					<div class="form-group" v-show="show">
						<label for="password" class="control-label">Contraseña:</label>
						<input type="password" name="password" id="password" placeholder="contraseña" v-model="administrador.password" class="form-control">
						<span class="help-block" v-if="errors['password']">
							<em>{{errors['password'][0]}}</em>
						</span>
					</div>
					<div class="form-group" v-if="show">
						<label for="password_confirmation" class="control-label">Confirmacion contraseña:</label>
						<input type="password" name="password_confirmation" id="password_confirmation" placeholder="repetir contraseña" v-model="administrador.password_confirmation" class="form-control">
					</div>
				</form>
			</template>
			<template slot="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
				<button type="button" class="btn btn-success" @click="guardar" v-show="show">Guardar</button>
				<button type="button" class="btn btn-success" @click="actualizar" v-show="!show">Actualizar</button>
			</template>
		</modal>
		
		<!--Barra de navegacion-->
		<nav aria-label="breadcrumb">
  			<ol class="breadcrumb">
    			<li class="breadcrumb-item">
    				<a href="panel">Panel</a>
    			</li>
    			<li class="breadcrumb-item active" aria-current="page">Administradores</li>
  			</ol>
		</nav>
		
		<navbar 
			:brand="'Administradores'"
			@agregar="agregar"
			@buscar="buscar">
		</navbar>

		<!-- tabla para mostrar los registro-->
		<tabla>
			<template slot="thead">
				<th>Nombre</th><th>Usuario</th><th>Email</th><th>Opciones</th>
			</template>
			<template slot="tbody">
				<tr v-for="administrador in administradores">
					<td>{{administrador.nombre}} {{administrador.apellido_paterno}} {{administrador.apellido_materno}}</td>
					<td>{{administrador.usuario}}</td>
					<td>{{administrador.email}}</td>
					<td>
						<div class="btn-group">
							<button class="btn btn-warning btn-sm" @click="editar(administrador)" title="Editar">
								<i class="fa fa-pencil-alt" aria-hidden="true"></i>
							</button>
							<button class="btn btn-danger btn-sm" @click="eliminar(administrador)" title="Eliminar">
								<i class="fa fa-trash" aria-hidden="true"></i>
							</button>
						</div>
					</td>
				</tr>
			</template>
		</tabla>

		<!-- Paginator -->
		<paginator
			:pagination="pagination" :offset='5' @changepage="changePage">
		</paginator>

	</div>
</template>

<script>

	import {Administrador, alert, limpiar_errores} from '../../clases';
	import swal from 'sweetalert2';

	export default {
		
		data() {
			return {

				show: false,

				titulo: '',

				administradores: [],

				errors:{
					nombre:[],
					apellido_paterno:[],
					apellido_materno:[],
					usuario:[],
					email:[],
					password:[]
				},
				
				administrador: new Administrador(),

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

			obtener(page) {
				let url = `administradores/create?page=${page}`;
				axios.get(url).then(response => {
					this.pagination = response.data.pagination;
					this.administradores = response.data.data.data;
				});
			},

			editar(administrador) {
				this.titulo = 'Editar';
				this.show = false;
				this.administrador = new Administrador(administrador.nombre, administrador.apellido_paterno , administrador.apellido_materno, administrador.usuario, administrador.email, administrador.id);
				limpiar_errores(this.errors);
				$("#modal").modal();
			},

			eliminar(administrador) {
				let url = `administradores/${administrador.id}`;
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
				this.administrador = new Administrador();
				this.show = true;
				this.titulo = 'Agregar';
				limpiar_errores(this.errors);
				$("#modal").modal();
			},

			guardar() {
				let url = "administradores";
				if(this.validar(this.administrador)){
					axios.post(url, this.administrador).then(response => {
						$("#modal").modal('hide');
						alert(response.data, 'success');
						this.obtener(this.pagination.current_page);
					}).catch(error => {
						this.errors = error.response.data.errors;
					});
				}
			},

			actualizar(){
				let url = `administradores/${this.administrador.id}`;
				if(this.validar(this.administrador)){
					axios.put(url, this.administrador).then(response => {
						$("#modal").modal('hide');
						//console.log(response.data);
						alert(response.data, 'success');
						this.obtener(this.pagination.current_page);
					}).catch(error => {
						this.errors['password'] = error.response.data.errors['password'];
					});
				}

			},

			buscar(elemento){
				let url = 'administradores/buscar';
				axios.post(url, {'nombre': elemento}).then(response => {
                    if(elemento)
                        this.administradores = response.data;
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

			validar(administrador){
				
				if(!administrador.nombre){
					this.errors['nombre'].push('Agregar nombre');
					return false;
				} else {
					this.errors['nombre'] = [];	
				}
				
				if(!administrador.apellido_paterno) {
					this.errors['apellido_paterno'].push('Agregar apellido paterno');
					return false;
				} else {
					this.errors['apellido_paterno'] = [];
				}

				if(!administrador.apellido_materno){
					this.errors['apellido_materno'].push('Agregar apellido materno');
					return false;
				} else {
					this.errors['apellido_materno'] = [];
				}

				if(!administrador.usuario){
					this.errors['usuario'].push('Agregar usuario');
					return false;
				} else {
					this.errors['usuario'] = [];
				} 

				if(!administrador.email){
					this.errors['email'].push('Agregar correo electronico');
					return false;
				} else {
					this.errors['email'] = [];
				}

				if(!administrador.password && this.show){
					this.errors['password'].push('Ingrese una contraseña');
					return false
				} else {
					this.errors['password'] = []				
				}

				if(!administrador.password.length >= 6 && this.show){
					this.errors['password'].push('La contraseña debe ser mayor de 6 caracteres');
					return false
				} else {
					this.errors['password'] = []				
				}

				return true;
			}

		}
	}

</script>

<style scoped>
	em{
		color: red;
	}
</style>