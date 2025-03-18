<?php

//VISTAS
Route::get("/", ControladorUsuarios::class);
Route::get("/listar_usuarios", ControladorUsuarios::class);
Route::get("/usuarios/form/crear", ControladorUsuarios::class."@formCrearUsuario");
Route::get("/usuarios/form/edicion/:id", ControladorUsuarios::class."@formEdicionUsuario");

// -- USUARIOS
Route::post("/usuarios/registrar", ControladorUsuarios::class."@insertarUsuario");

// -- DistritosLima
Route::get("/listar", ControladorDistritosLima::class."@index");
Route::get("/listar_distritoslima", ControladorDistritosLima::class);
Route::post("/distritos/actualizar", ControladorDistritosLima::class."@actualizarDistritoLima");
Route::post("/distritos/consultarDistritoLimaPorId", ControladorDistritosLima::class."@buscarDistritosLimaPorId");
Route::post("/distritos/eliminarDistritoLimaPorId", ControladorDistritosLima::class."@eliminarDistritosLimaPorId");

// -- Detalles
Route::get("/detalles/listar", ControladorDetalles::class."@index");
Route::get("/detalles/listar_detalles", ControladorDetalles::class."@listarDetalles");
Route::post("/detalles/registrar", ControladorDetalles::class."@registrarDetalle");
Route::post("/detalles/actualizar", ControladorDetalles::class."@actualizarDistritoLima");
Route::post("/detalles/consultarDistritoLimaPorId", ControladorDetalles::class."@buscarDistritosLimaPorId");
Route::post("/detalles/eliminarDistritoLimaPorId", ControladorDetalles::class."@eliminarDistritosLimaPorId");

// -- Login
Route::POST("/login", ControladorAuthentication::class."@login");
