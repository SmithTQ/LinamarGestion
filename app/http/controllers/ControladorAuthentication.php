<?php

require_once 'app/libraries/firebase/JWT/JWT.php';
require_once 'app/libraries/firebase/JWT/Key.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class ControladorAuthentication extends Controller {

    private $secretKey = '8765421'; // Cambia esto por una clave secreta segura

    public function login(Request $request) {

        $usuario = $request->vcUsuario;
        $contrasena = $request->vcContrasenaUsuario;

        $usuarioModel = new Usuarios();
        $usuario = $usuarioModel->where("vcNombreUsuario", "=", $usuario)->orWhere("vcCorreoUsuario", "=", $usuario)->first();

        if ($usuario && password_verify($contrasena, $usuario->vcContrasenaUsuario)) {
            // Generar token JWT
            $payload = [
                'iss' => URL::base(), // Emisor del token
                'aud' => URL::base(), // Audiencia del token
                'iat' => time(), // Tiempo en que se emitió el token
                'nbf' => time(), // Tiempo antes del cual el token no debe ser aceptado
                'exp' => time() + (60 * 60), // Tiempo de expiración del token (1 hora)
                'data' => [
                    'id' => $usuario->inIdUsuario,
                    'email' => $usuario->vcCorreoUsuario
                ]
            ];

            $jwt = JWT::encode($payload, $this->secretKey, 'HS256');

            return new Respuesta(EMensajes::CORRECTO, "Login exitoso.", ['token' => $jwt]);
        } else {
            return new Respuesta(EMensajes::ERROR, "Credenciales incorrectas.");
        }
    }

    public function validarToken($token) {
        try {
            $decoded = JWT::decode($token, new Key($this->secretKey, 'HS256'));
            return $decoded;
        } catch (Exception $e) {
            return null;
        }
    }
}