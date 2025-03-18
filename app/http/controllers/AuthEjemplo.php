<?php

require_once 'App\Http\Controllers\hooks\Hooks.php';
require_once 'app\libraries\JWT.php';
require_once 'app\libraries\Key.php';

class ControladorDetalles extends Controller {
    
    private $hooks;
    private $contanerImagenes = "/assets/images/archivos/detalles/";
    private $authMiddleware;

    function __construct() {
        parent::__construct();     
        $this->hooks = new Hooks();
        $this->authMiddleware = new AuthMiddleware();
    }

    public function index(Request $request) {
        $this->authMiddleware->handle($request, function($request) {
            $variables = [
                "titulo" => "Detalles | Linamar",
                "navbar" => $this->view("global/navbar"),
                "header" => $this->view("global/header", ["titulo" => "DETALLES"])
            ];
            return $this->view("detalles/listardetalles", $variables);
        });
    }

    // Otros métodos...
}