<template>
	<div>
		<div class="modal" tabindex="-1" role="dialog" id="modal">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
		  			<div class="modal-header">
		    			<h5 class="modal-title">{{titulo}}</h5>
		    			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		      				<span aria-hidden="true">&times;</span>
		    			</button>
		  			</div>
		  			<div class="modal-body">
		    			<slot name="modal-body"></slot>
		  			</div>
		  			<div class="modal-footer">
		  				<slot name="modal-footer">
		    				<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
		    				<button type="button" class="btn btn-success">Guardar</button>
		  				</slot>
		  			</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	
	export default {

		props:['titulo']

	}

</script>