<?php


//VISTAS
Route::get("/", ControladorUsuarios::class);
Route::get("/listar_usuarios", ControladorUsuarios::class);
Route::get("/usuarios/form/crear", ControladorUsuarios::class."@formCrearUsuario");
Route::get("/usuarios/form/edicion/:id", ControladorUsuarios::class."@formEdicionUsuario");

// -- Login
Route::GET("/login", ControladorAuthentication::class."@index");
Route::POST("/login", ControladorAuthentication::class."@login");

// -- USUARIOS
Route::post("/usuarios/registrar", ControladorUsuarios::class."@insertarUsuario");

// -- DistritosLima
Route::get("/distritos/listar", ControladorDistritosLima::class."@index");
Route::get("/distritos/listar_distritoslima", ControladorDistritosLima::class."@listarDistritosLima");
Route::post("/distritos/actualizar", ControladorDistritosLima::class."@actualizarDistritoLima");
Route::post("/distritos/consultarDistritoLimaPorId", ControladorDistritosLima::class."@buscarDistritosLimaPorId");
Route::post("/distritos/eliminarDistritoLimaPorId", ControladorDistritosLima::class."@eliminarDistritosLimaPorId");

// -- Detalles
Route::get("/detalles/listar", ControladorDetalles::class."@index");
Route::get("/detalles/listar_detalles", ControladorDetalles::class."@listarDetalles");
Route::post("/detalles/consultarDetallePorId", ControladorDetalles::class."@buscarDetallePorId");
Route::post("/detalles/registrar", ControladorDetalles::class."@registrarDetalle");
Route::post("/detalles/actualizar", ControladorDetalles::class."@actualizarDetalle");
Route::post("/detalles/eliminarDistritoLimaPorId", ControladorDetalles::class."@eliminarDistritosLimaPorId");

// -- Formularios
Route::get("/formularios/listar", ControladorFormularios::class."@index");