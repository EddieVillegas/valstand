@extends('layouts.master')
@section('title','Panel')
@section('content')

<div class="row">
	
	<div class="col-sm-3">
		<div class="card text-center" style="width: 18rem;">
			<div class="card-header">
				<i class="fas fa-key fa-5x"></i>
			</div>
			<div class="card-body">
				<h5 class="card-title">
					<a href="{{route('administradores.index')}}" class="btn btn-primary">Administradores</a>
				</h5>
			</div>
		</div>
	</div>

	<div class="col-sm-3">
		<div class="card text-center" style="width: 18rem;">
			<div class="card-header">
				<i class="fas fa-newspaper fa-5x"></i>
			</div>
			<div class="card-body">
				<h5 class="card-title">
					<a href="{{route('noticias.index')}}" class="btn btn-primary">Noticias</a>
				</h5>
			</div>
		</div>
	</div>

	<div class="col-sm-3">
		<div class="card text-center" style="width: 18rem;">
			<div class="card-header">
				<i class="fas fa-file-alt fa-5x	"></i>
			</div>
			<div class="card-body">
				<h5 class="card-title">
					<a href="{{route('proyectos.index')}}" class="btn btn-primary">Proyectos</a>
				</h5>
			</div>
		</div>
	</div>

	<div class="col-sm-3">
		<div class="card text-center" style="width: 18rem;">
			<div class="card-header">
				<i class="fas fa-handshake fa-5x"></i>
			</div>
			<div class="card-body">
				<h5 class="card-title">
					<a href="{{route('socios.index')}}" class="btn btn-primary">Socios</a>
				</h5>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-3">
		<div class="card text-center" style="width: 18rem;">
			<div class="card-header">
				<i class="fas fa-users fa-5x"></i>
			</div>
			<div class="card-body">
				<h5 class="card-title">
					<a href="{{route('usuarios.index')}}" class="btn btn-primary">Usuarios</a>
				</h5>
			</div>
		</div>
	</div>
	<div class="col-sm-3">
		<div class="card text-center" style="width: 18rem;">
			<div class="card-header">
				<i class="fas fa-dollar-sign fa-5x"></i>
			</div>
			<div class="card-body">
				<h5 class="card-title">
					<a href="{{route('subastas.index')}}" class="btn btn-primary">Subastas</a>
				</h5>
			</div>
		</div>
	</div>
</div>
@endsection