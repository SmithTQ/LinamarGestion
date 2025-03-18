<?php

require_once 'App\Http\Controllers\hooks\Hooks.php';

class ControladorDetalles extends Controller {
    
    private $hooks;
    private $contanerImagenes = "/assets/images/archivos/detalles/";

    function __construct() {
        parent::__construct();     
        $this->hooks = new Hooks();
    }

    public function index() {
        $variables = [
            "titulo" => "Detalles | Linamar",
            "navbar" => $this->view("global/navbar"),
            "header" => $this->view("global/header", ["titulo" => "DETALLES"])
        ];
        return $this->view("detalles/listardetalles", $variables);
    }

    public function formCrearDetalles() {
        return $this->view("detalles/detalle");
    }

    public function formEdicionDetalle($id) {
        $variables = [
            "titulo" => "Actualizar Detalle",
            "idDetalle" => base64_decode($id)
        ];
        return $this->view("detalles/registrardetalle", $variables);
    }

    public function registrarDetalle(Request $request) {

        $detalleModel = new Detalles();

        $detalle = $detalleModel->where("vcNombreDetalle", "=", $request->vcNombreDetalle)->first();
        if ($detalle) {
            return new Respuesta(EMensajes::ERROR, "Ya se encuentra registrado un detalle con el mismo nombre.");
        }

        $request = $this->getRequestDetalle($request);
        $id = $detalleModel->insert($request->all());
        $v = ($id > 0);

        // Insertar precio detalle
        $idPrecio = 0;
        $v2 = false;
        if($v){
            $idPrecio = $this->registrarPrecioDetalle($request, $id);
            $image = $this->hooks->guardarImagen($_FILES['imagen'], $id, "assets/images/archivos/detalles/");
        }
        $v2 = ($idPrecio > 0);

        $respuesta = new Respuesta($v && $v2? EMensajes::INSERCION_EXITOSA : EMensajes::ERROR_INSERSION);
        $respuesta->setDatos($id);

        return $respuesta;
    }

    private function registrarPrecioDetalle(Request $request, $idDetalle) {
        $precioDetalleModel = new PrecioDetalles();

        $request = $this->getRequestPrecioDetalle($request, $idDetalle);
        $id = $precioDetalleModel->insert($request->all());
        $v = ($id > 0);

        return $v;
    }

    public function listarDetalles() {
        $listDetallesModel = new ListDetalles();

        $query = "SELECT d.*, COALESCE(pd.inSolPrecioDetalle, '0.00') as inSolPrecioDetalle, COALESCE(pd.inDolarPrecioDetalle, '0.00') as inDolarPrecioDetalle  FROM tb_detalles d
                    left join tb_preciodetalles pd on d.inIdDetalle = pd.inIdDetalle order by d.tsFechaCreacion desc";
        $lista = $listDetallesModel->get($query);

        $v = count($lista);

        $respuesta = new Respuesta($v ? EMensajes::CORRECTO : EMensajes::ERROR);
        $respuesta->setDatos($lista);

        return $respuesta;
    }

    public function buscarDetallePorId(Request $request) {
        $idDetalle = $request->idDetalle;
        $detallesModel = new Detalles();
        $detalle = $detallesModel->where("id", "=", $idDetalle)->first();
        $v = ($detalle != null);
        $respuesta = new Respuesta($v ? EMensajes::CORRECTO : EMensajes::NO_HAY_REGISTROS);
        $respuesta->setDatos($detalle);
        return $respuesta;
    }
    
    public function actualizarDetalle(Request $request) {
        $detalleModel = new Detalles();
        $actualizados = $detalleModel->where("id", " = ", $request->idDetalle)->update($request->all());
        $v = ($actualizados >= 0);
        return new Respuesta($v ? EMensajes::ACTUALIZACION_EXITOSA : EMensajes::ERROR_ACTUALIZACION);
    }



    private function getRequestDetalle(Request $request) {

        $id = $this->hooks->getUUID();
        $tipoImagen = null;
        $rutaImagen = null;

        if (isset($_FILES['imagen'])) {
            $tipoImagen = pathinfo($_FILES['imagen']["name"], PATHINFO_EXTENSION);
            $rutaImagen = URL::base() . $this->contanerImagenes . $id . ".". $tipoImagen;
       }   
        
        $request->inIdDetalle = $id;
        $request->tsFechaCreacion = $this->hooks->todayTimestamp();
        $request->vcUrlImagenDetalle = $rutaImagen != null ? $rutaImagen : null;
        $request->vcTipoImagenDetalle = $tipoImagen != null ? $tipoImagen : null;
        $request->inVersion = 1;
        $request->inHabilitado = 1;

        return $request;
    }
    
    private function getRequestPrecioDetalle(Request $request, $idDetalle) {

        $precioSol = (float) $this->hooks->formatNumber($request->inSolPrecioDetalle, 'round');
        $precioDolar = (float) $this->hooks->formatNumber((isset($request->inDolarPrecioDetalle) ? $request->inDolarPrecioDetalle : 0.00), 'round');
        
        $request->inIdPrecioDetalle = $this->hooks->getUUID();
        $request->inIdDetalle = $idDetalle;
        $request->inSolPrecioDetalle = $precioSol;
        $request->inDolarPrecioDetalle = $precioDolar;
        $request->tsFechaCreacion = $this->hooks->todayTimestamp();
        $request->inVersion = 1;
        $request->inHabilitado = 1;

        return $request;
    }
}
