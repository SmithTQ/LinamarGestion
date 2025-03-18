<?php

class DistritosLima extends ModeloGenerico {

    protected $inIdubigeo;
    protected $inIdprovincia;
    protected $vcDescprovincia;
    protected $vcDescdistrito;
    protected $vcMacroregion;
    protected $inHabilitado;

    public function __construct($propiedades = null){
        parent::__construct("tb_ubigeo", DistritosLima::class, $propiedades);
    }

    public function getInIdubigeo(){
        return $this->getInIdubigeo;
    }

    public function setInIdubigeo($inIdubigeo){
        $this->getInIdubigeo = $inIdubigeo;
    }

    public function getInIdprovincia(){
        return $this->inIdprovincia;
    }

    public function setInIdprovincia($inIdprovincia){
        $this->inIdprovincia = $inIdprovincia;
    }

    public function getVcDescprovincia(){
        return $this->vcDescprovincia;
    }

    public function setVcDescprovincia($vcDescprovincia){
        $this->vcDescprovincia = $vcDescprovincia;
    }

    public function getVcDescdistrito(){
        return $this->vcDescdistrito;
    }

    public function setVcDescdistrito($vcDescdistrito){
        $this->vcDescdistrito = $vcDescdistrito;
    }

    public function getVcMacroregion(){
        return $this->vcMacroregion;
    }

    public function setVcMacroregion($vcMacroregion){
        $this->vcMacroregion = $vcMacroregion;
    }

    public function getInHabilitado(){
        return $this->inHabilitado;
    }

    public function setInHabilitado($inHabilitado){
        $this->inHabilitado = $inHabilitado;
    }

}