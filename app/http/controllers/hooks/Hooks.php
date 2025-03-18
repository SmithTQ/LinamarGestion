<?php

class Hooks {

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

    function formatNumber($numero, $metodo = 'number_format') {
        switch ($metodo) {
            case 'round':
                return round($numero, 2); // Devuelve un float
            case 'sprintf':
                return sprintf("%.2f", $numero); // Devuelve un string
            case 'number_format':
            default:
                return number_format($numero, 2, '.', ''); // Devuelve un string
        }
    }

    function guardarImagen($archivo, $id, $carpetaDestino = "assets/images/archivos/otros") {
        // Verificar si se subió un archivo
        if (!isset($archivo) || $archivo["error"] != 0) {
            return "Error al subir la imagen.";
        }
    
        // Validar que sea una imagen
        $permitidos = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($archivo["type"], $permitidos)) {
            return "Formato no permitido. Solo JPG, PNG y GIF.";
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
            $result->setCodigo(EMensajes::CORRECTO);
            $result->setDatos([
                "ruta" => $rutaCompleta,
                "nombre" => $nombreArchivo,
                "tipo" => $tipoArchivo
            ]);

            return "Imagen guardada en: " . $rutaCompleta;
        } else {
            $result->setCodigo(EMensajes::ERROR);
        }

        return $result;
    }

}

?>