import swal from 'sweetalert2';

export class Administrador {

	constructor(nombre = '', apellido_paterno = '', apellido_materno = '', usuario = '', email = '', id = '', password = '', password_confirmation = '') {
		this.nombre = nombre;
		this.apellido_paterno = apellido_paterno;
		this.apellido_materno = apellido_materno;
		this.usuario = usuario;
		this.email = email;
		this.password = password;
		this.password_confirmation = password_confirmation;
		this.id = id;
	}
}

export class Noticia {
	constructor(caratula = '', titulo = '', tema = '', contenido = '', created_at = '', id = ''){
		this.caratula = caratula;
		this.titulo = titulo;
		this.tema = tema;
		this.contenido = contenido;
		this.created_at = created_at;
		this.id = id;
	}
}

export class Proyecto {

	constructor(nombre = '', descripcion = '', imagenes = [], id = '') {
		this.nombre = nombre;
		this.descripcion = descripcion;
		this.imagenes = imagenes;
		this.id = id;
	}

}

export class Socio {
	constructor(nombre = '', logotipo = '', id = '') {
		this.nombre = nombre;
		this.logotipo = logotipo;
		this.id = id;
	}
}

export class Subasta{ 
	constructor(nombre = '', descripcion = '', caratula = '', estatus = '', id = ''){
		this.nombre =  nombre;
		this.descripcion = descripcion;
		this.caratula =  caratula;
		this.estatus = estatus;
		this.id = id;
	}
}

export var alert = (title, type) => {
    swal({
        'title': title,
        'type': type,
        'showCloseButton': false,
        'showConfirmButton': false,
        'focusConfirm': false,
        'timer': 1500,
        'width': 500
    });
};

export var limpiar_errores = (errors) => {
	for(let e in errors){
		errors[e] = [];
	}
}
