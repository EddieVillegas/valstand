<template>
	<div>
		<nav aria-label="breadcrumb">
  			<ol class="breadcrumb">
    			<li class="breadcrumb-item">
    				<a href="panel">Panel</a>
    			</li>
    			<li class="breadcrumb-item active" aria-current="page">Usuario</li>
  			</ol>
		</nav>
		<tabla>
			<template slot="thead">
				<th>Nombre</th>
				<th>Email</th>
				<th>Celular</th>
				<th>Compañia</th>
				<th>Tipo de Registro</th>
				<th>Opciones</th>
			</template>
			<template slot="tbody">
				<tr v-for="usuario in usuarios">
					<td>{{usuario.nombre}}{{usuario.apellido_paterno}}{{usuario.apellido_materno}}</td>
					<td>{{usuario.email}}</td>
					<td>{{usuario.telefono}}</td>
					<td>{{usuario.compañia}}</td>
					<td>{{usuario.registro}}</td>
					<td>
						<div class="btn-group">
							<button type = 'button' class="btn btn-warning" alt="editar" @click="editar(noticia)">
		    					<i class="fa fa-pencil-alt" aria-hidden="true"></i>
		    				</button>
							<button class="btn btn-danger" alt="eliminar" @click="eliminar(noticia)">
		    					<i class="fa fa-trash" aria-hidden="true"></i>
							</button>
						</div>
					</td>
				</tr>
			</template>
		</tabla>
	</div>
</template>

<script>
	export default {
		
		mounted(){
			this.obtener(this.pagination.current_page);
		},

		data(){
			return {
				usuarios: [],
				pagination: {
                    total: 0, 
                    per_page: 2,
                    from: 1,
                    to: 0,
                    current_page: 1
                },
			}
		},
		methods:{
			obtener(page){
				let url = `usuarios/create?page=${page}`;
				axios.get(url).then(response => {
					this.usuarios = response.data.data.data;
					this.pagination = response.data.pagination;
				})
			}
		}
	}
</script>