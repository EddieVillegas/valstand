<?php

Route::post('administradores/buscar','AdministradorController@buscar');
Route::post('subastas/buscar', 'SubastaController@buscar');
Route::post('noticias/buscar', 'NoticiaController@buscar');
Route::post('proyectos/{proyecto}', 'ProyectoController@update');
Route::post('noticias/{noticia}', 'NoticiaController@update');
Route::post('socios/{socio}', 'SocioController@update');
Route::post('subastas/{subasta}', 'SubastaController@update');

Route::get('panel', function(){
	return view('panel.index');
});

Route::resources([
	'administradores' => 'AdministradorController',
	'noticias' => 'NoticiaController',
	'proyectos' => 'ProyectoController',
	'socios' => 'SocioController',
	'imagenes' => 'ImagenController',
	'usuarios' => 'UsuarioController',
	'subastas' => 'SubastaController' 
]);


Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
