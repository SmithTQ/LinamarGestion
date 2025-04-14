<?php

require_once 'app/libraries/JWT/JWT.php';
require_once 'app/libraries/JWT/Key.php';

class ControladorDistritosLima extends Controller {

    private $menuGenerator;
    private $authMiddleware;

    function __construct() {
        parent::__construct();
        $this->authMiddleware = new AuthMiddleware();
        $this->menuItems = new MenuItems();
    }

    public function index() {
        $variables = [
            "titulo" => "Distritos Lima | LinaMar",
            "navbar" => $this->view("global/navbar", ["menuItems" => $this->menuItems->items, "activeItem" => "Distritos"]),
            "header" => $this->view("global/header", ["titulo" => "DISTRITOS"]),
            "uri" => "distritos/listardistritoslima"
        ];
        return $this->view("distritos/listardistritoslima", $variables);
    }

    public function formCrearDistritoLima() {
        return $this->view("distritos/distritosLima");
    }

    public function formEdicionDistritoLima($id) {
        $variables = [
            "titulo" => "Actualizar Distrito",
            "idDistrito" => base64_decode($id)
        ];
        return $this->view("distritos/registrardistritoslima", $variables);
    }

    public function listarDistritosLima(Request $request) {
        return $this->authMiddleware->handle($request, function($request) {

            $distritosLimaModel = new DistritosLima();
            $lista = $distritosLimaModel->where("inIdprovincia", "=", "1501")->get();

            $v = count($lista);

            $respuesta = new Respuesta($v ? EMensajes::CORRECTO : EMensajes::ERROR);
            $respuesta->setDatos($lista);

            return $respuesta;
            
        });
    }

    public function buscarDistritosLimaPorId(Request $request) {
        $idDistrito = $request->idDistrito;
        $distritosLimaModel = new DistritosLima();
        $distritoLima = $distritosLimaModel->where("id", "=", $idDistrito)->first();
        $v = ($distritoLima != null);
        $respuesta = new Respuesta($v ? EMensajes::CORRECTO : EMensajes::NO_HAY_REGISTROS);
        $respuesta->setDatos($distritoLima);
        return $respuesta;
    }
    
    public function actualizarDistritoLima(Request $request) {
        $distritosLimaModel = new DistritosLima();
        $actualizados = $distritosLimaModel->where("id", " = ", $request->idDistrito)
        ->update($request->all());
        $v = ($actualizados >= 0);
        return new Respuesta($v ? EMensajes::ACTUALIZACION_EXITOSA : EMensajes::ERROR_ACTUALIZACION);
    }
    
    public function eliminarDistritoLima($idDistrito) {
        $distritosLimaModel = new DistritosLima();
        $eliminados = $distritosLimaModel->where("id", " = ", $idDistrito)->delete();
        $v = ($eliminados > 0);
        return new Respuesta($v ? EMensajes::ELIMINACION_EXITOSA : EMensajes::ERROR_ELIMINACION);
    }

    public function eliminarDistritosLimaPorId(Request $request) {
        $idDistrito = $request->idDistrito;
        $distritosLimaModel = new DistritosLima();
        $filasFectadas = $distritosLimaModel->where("id", "=", $idDistrito)->delete();
        $respuesta = new Respuesta($filasFectadas > 0? EMensajes::CORRECTO : EMensajes::ERROR);
        return $respuesta;
    }
}
