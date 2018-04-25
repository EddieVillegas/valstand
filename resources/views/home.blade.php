@extends('layouts.master')
@section('title','Inicio')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        	<main role="main" class="inner cover">
				<form>
					<div class="form-group">
						<label for="latitud" class="control-label">Latitud</label>
						<input type="text" name="latitud" id="latitud" class="form-control"  placeholder="latitud">
					</div>
					<div class="form-group">
						<label for="longitud" class="control-label">Logitud</label>
						<input type="text" name="longitud" id="longitud" class="form-control" placeholder="longitud">
					</div>
					<div class="form-group">
						<label for="direccion" class="control-label">Direccion</label>
						<input type="text" name="direccion" id="direccion" class="form-control" placeholder="Direccion">
					</div>
					<div class="form-group">
						<label for="telefono" class="control-label">Telefono</label>
						<input type="text" name="telefono" id="telefono" class="form-control" placeholder="telefono">
					</div>
				</form>
      		</main>
      		<footer class="mastfoot mt-auto">
        		<div class="inner">
          			<i class="fab fa-facebook-square"></i>
					<i class="fab fa-twitter-square"></i>
					<i class="fab fa-instagram"></i>
					<i class="fab fa-linkedin"></i>
        		</div>
      		</footer>
        </div>
    </div>
</div>
@endsection