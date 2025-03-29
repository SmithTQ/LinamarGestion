<?php

require_once 'app/libraries/JWT/JWTExceptionWithPayloadInterface.php';
require_once 'app/libraries/JWT/ExpiredException.php';
require_once 'app/libraries/JWT/SignatureInvalidException.php';
require_once 'app/libraries/JWT/BeforeValidException.php';
require_once 'app/libraries/JWT/JWT.php';
require_once 'app/libraries/JWT/Key.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class ControladorAuthentication extends Controller {

    private $secretKey = '4b3403665fea6bfb1b9e6e8d7a9f8e7c4b3403665fea6bfb1b9e6e8d7a9f8e7c'; // Cambia esto por una clave secreta segura

    public function index() {
        $variables = [
            "titulo" => "Login | Linamar"
        ];
        return $this->view("login/login", $variables);
    }

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