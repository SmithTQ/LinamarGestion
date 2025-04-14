<?php

class AuthMiddleware extends Controller {

    private $controladorAuthentication;

    public function __construct() {
        $this->controladorAuthentication = new ControladorAuthentication();
    }

    public function handle($request, $next) {
        
        $headers = getallheaders();
        if (isset($headers['Authorization'])) {
            $token = str_replace('Bearer ', '', $headers['Authorization']);
            //echo $token;
            $usuario = $this->controladorAuthentication->validarToken($token);
            if ($usuario) {
                $request->usuario = $usuario;
                return $next($request);
            }
        }
        return new Respuesta(EMensajes::NO_AUTORIZADO);
    }
}