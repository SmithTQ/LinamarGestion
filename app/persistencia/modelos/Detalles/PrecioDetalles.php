<?php

class PrecioDetalles extends ModeloGenerico {

    protected $inIdPrecioDetalle;
    protected $inIdDetalle;
    protected $inSolPrecioDetalle;
    protected $inDolarPrecioDetalle;
    protected $tsFechaCreacion;
    protected $tsFechaModificacion;
    protected $tsFechaEliminacion;
    protected $inVersion;
    protected $inHabilitado;


    public function __construct($propiedades = null){
        parent::__construct("tb_preciodetalles", PrecioDetalles::class, $propiedades);
    }

    public function getInIdPrecioDetalle(){
        return $this->inIdPrecioDetalle;
    }

    public function setInIdPrecioDetalle($inIdPrecioDetalle){
        $this->inIdPrecioDetalle = $inIdPrecioDetalle;
    }

    public function getInIdDetalle(){
        return $this->inIdDetalle;
    }

    public function setInIdDetalle($inIdDetalle){
        $this->inIdDetalle = $inIdDetalle;
    }

    public function getInSolPrecioDetalle(){
        return $this->inSolPrecioDetalle;
    }

    public function setInSolPrecioDetalle($inSolPrecioDetalle){
        $this->inSolPrecioDetalle = $inSolPrecioDetalle;
    }

    public function getInDolarPrecioDetalle(){
        return $this->inDolarPrecioDetalle;
    }

    public function setInDolarPrecioDetalle($inDolarPrecioDetalle){
        $this->inDolarPrecioDetalle = $inDolarPrecioDetalle;
    }

    public function getTsFechaCreacion(){
        return $this->tsFechaCreacion;
    }

    public function setTsFechaCreacion($tsFechaCreacion){
        $this->tsFechaCreacion = $tsFechaCreacion;
    }

    public function getTsFechaModificacion(){
        return $this->tsFechaModificacion;
    }

    public function setTsFechaModificacion($tsFechaModificacion){
        $this->tsFechaModificacion = $tsFechaModificacion;
    }

    public function getTsFechaEliminacion(){
        return $this->tsFechaEliminacion;
    }

    public function setTsFechaEliminacion($tsFechaEliminacion){
        $this->tsFechaEliminacion = $tsFechaEliminacion;
    }

    public function getInVersion(){
        return $this->inVersion;
    }

    public function setInVersion($inVersion){
        $this->inVersion = $inVersion;
    }
    
    public function getInHabilitado(){
        return $this->inHabilitado;
    }

    public function setInHabilitado($inHabilitado){
        $this->inHabilitado = $inHabilitado;
    }

}