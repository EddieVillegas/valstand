<template>
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<a class="navbar-brand" href="#">{{brand}}</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item active">
					<a class="nav-link" href="#" @click="agregar" title="Agregar">
						<i class="fa fa-plus" aria-hidden="true"></i>
						<span class="sr-only">(current)</span>
					</a>
				</li>
			</ul>
			<form class="form-inline my-2 my-lg-0">
				<input class="form-control mr-sm-2" type="search" placeholder="Buscar..." aria-label="Search" @keyup="buscar" v-model="elemento">
			</form>
		</div>
	</nav>
</template>

<script>
	
	export default {

		props:['brand'],

		data(){
			return {
				elemento: ''
			}
		},

		methods:{
			agregar(){
				this.$emit('agregar');
			},
			buscar(){
				this.$emit('buscar', this.elemento);
			}
		}
	}
</script>