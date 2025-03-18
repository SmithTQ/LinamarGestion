<?php

class AuthMiddleware {

    private $controladorAutenticacion;

    public function __construct() {
        $this->controladorAutenticacion = new ControladorAutenticacion();
    }

    public function handle($request, $next) {
        $headers = getallheaders();
        if (isset($headers['Authorization'])) {
            $token = str_replace('Bearer ', '', $headers['Authorization']);
            $usuario = $this->controladorAutenticacion->validarToken($token);
            if ($usuario) {
                $request->usuario = $usuario;
                return $next($request);
            }
        }
        return new Respuesta(EMensajes::ERROR, "No autorizado.");
    }
}