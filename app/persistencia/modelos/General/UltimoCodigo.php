<?php

class UltimoCodigo extends ModeloGenerico {

    protected $vcUltimoCodigo;

    public function __construct($tabla, $propiedades = null){
        parent::__construct($tabla, UltimoCodigo::class, $propiedades);
    }

    public function getVcUltimoCodigo(){
        return $this->vcUltimoCodigo;
    }

    public function setVcUltimoCodigo($vcUltimoCodigo){
        $this->vcUltimoCodigo = $vcUltimoCodigo;
    }

}