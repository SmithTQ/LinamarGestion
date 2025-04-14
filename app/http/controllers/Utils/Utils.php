<?php

class Utils {

    protected $formatTimestamp = "Y-m-d H:i:s";

    public function todayTimestamp() {
        date_default_timezone_set("America/Lima");
        return date($this->formatTimestamp);
    }

    public function getUUID() {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000, // 4 indica UUID versión 4
            mt_rand(0, 0x3fff) | 0x8000, // 8, 9, A o B indica variante
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    public function getNewCodigo($tabla, $campo, $prefijo = "", $longitud = 5) {
        $codigo = $prefijo . str_pad($this->getUltimoCodigo($tabla, $campo, $prefijo) + 1, $longitud, "0", STR_PAD_LEFT);
        return $codigo;
    }

    public function getUltimoCodigo($tabla, $campo, $prefijo = "") {

        $ultimoCodigo = new UltimoCodigo($tabla);

        $query = "SELECT MAX(" 
                    . (empty($prefijo) ? $campo : "SUBSTRING($campo, LENGTH(:prefijo) + 1)")
                    . ") as vcUltimoCodigo FROM $tabla"
                    . (empty($prefijo) ? "" : " WHERE $campo LIKE :prefijo");

        $params = (empty($prefijo) ? null : [":prefijo" => "$prefijo%"]);

        $resultado = $ultimoCodigo->first($query);

        if (empty($resultado)) {
            return 0;
        }
        
        return (int)$resultado->vcUltimoCodigo;
    }

    function formatNumber($numero, $metodo = 'number_format') {
        switch ($metodo) {
            case 'round':
                return round($numero, 2); // Devuelve un float
            case 'sprintf':
                return sprintf("%.2f", $numero); // Devuelve un string
            case 'number_format':
                return number_format($numero, 2, '.', ''); // Devuelve un string
            default:
                return number_format($numero, 2, '.', ''); // Devuelve un string
        }
    }

    function guardarImagen($archivo, $id, $carpetaDestino = "assets/images/archivos/otros") {
        // Verificar si se subió un archivo
        if (!isset($archivo) || $archivo["error"] != 0) {
            $respuesta = new Respuesta(EMensajes::ERROR, "Error al subir la imagen.");
            return $respuesta;
        }
    
        // Validar que sea una imagen
        $permitidos = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($archivo["type"], $permitidos)) {
            $respuesta = new Respuesta(EMensajes::ERROR, "Formato no permitido. Solo JPG, PNG y GIF.");
            return $respuesta;
        }
    
        // Crear la carpeta si no existe
        if (!file_exists($carpetaDestino)) {
            mkdir($carpetaDestino, 0777, true);
        }
    
        // Generar un nombre único para evitar reemplazos
        $tipoArchivo = pathinfo($archivo["name"], PATHINFO_EXTENSION);
        $nombreArchivo = $id . "." . $tipoArchivo;
    
        // Ruta completa donde se guardará
        $rutaCompleta = $carpetaDestino . $nombreArchivo;
    
        // Mover la imagen al destino
        $result = new Respuesta();

        if (move_uploaded_file($archivo["tmp_name"], $rutaCompleta)) {

            // Guardar thumbnail
            $thumbnailRuta = $carpetaDestino . "thumb_" . $nombreArchivo;
            $this->guardarThumbnailImagen($rutaCompleta, $thumbnailRuta, 200, 200);

            $respuesta = new Respuesta(EMensajes::CORRECTO, "Imagen guardada correctamente.");
            $respuesta->setDatos([
                "ruta" => $rutaCompleta,
                "nombre" => $nombreArchivo,
                "tipo" => $tipoArchivo
            ]);
        } else {
            $respuesta = new Respuesta(EMensajes::ERROR, "Error al mover la imagen.");
        }

        return $respuesta;
    }

    function guardarThumbnailImagen($origen, $destino, $anchoMax = 200, $altoMax = 200) {
        // Obtener la información de la imagen original
        list($anchoOriginal, $altoOriginal, $tipo) = getimagesize($origen);
    
        // Calcular escala
        $escala = min($anchoMax / $anchoOriginal, $altoMax / $altoOriginal);
        $anchoNuevo = (int)($anchoOriginal * $escala);
        $altoNuevo = (int)($altoOriginal * $escala);
    
        // Crear una imagen vacía para el thumbnail
        $thumbnail = imagecreatetruecolor($anchoNuevo, $altoNuevo);
    
        // Crear la imagen original desde archivo
        switch ($tipo) {
            case IMAGETYPE_JPEG:
                $original = imagecreatefromjpeg($origen);
                break;
            case IMAGETYPE_PNG:
                $original = imagecreatefrompng($origen);
                imagealphablending($thumbnail, false);
                imagesavealpha($thumbnail, true);
                break;
            case IMAGETYPE_GIF:
                $original = imagecreatefromgif($origen);
                break;
            default:
                return false; // Tipo no soportado
        }
    
        // Copiar y redimensionar
        imagecopyresampled($thumbnail, $original, 0, 0, 0, 0, $anchoNuevo, $altoNuevo, $anchoOriginal, $altoOriginal);
    
        // Guardar el thumbnail
        switch ($tipo) {
            case IMAGETYPE_JPEG:
                imagejpeg($thumbnail, $destino);
                break;
            case IMAGETYPE_PNG:
                imagepng($thumbnail, $destino);
                break;
            case IMAGETYPE_GIF:
                imagegif($thumbnail, $destino);
                break;
        }
    
        // Liberar memoria
        imagedestroy($original);
        imagedestroy($thumbnail);
    
        return true;
    }


    function validarImagen($archivo) {
    
        // Validar que sea una imagen
        $permitidos = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($archivo["type"], $permitidos)) {
            return false;
        }
    
        return true;
    }

}

?>