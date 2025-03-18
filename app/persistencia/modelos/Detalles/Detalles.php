<?php

class Detalles extends ModeloGenerico {

    protected $inIdDetalle;
    protected $vcNombreDetalle;
    protected $vcDescDetalle;
    protected $vcUrlImagenDetalle;
    protected $vcTipoImagenDetalle;
    protected $tsFechaCreacion;
    protected $tsFechaModificacion;
    protected $tsFechaEliminacion;
    protected $inVersion;
    protected $inHabilitado;


    public function __construct($propiedades = null){
        parent::__construct("tb_detalles", Detalles::class, $propiedades);
    }

    public function getInIdDetalle(){
        return $this->inIdDetalle;
    }

    public function setInIdDetalle($inIdDetalle){
        $this->inIdDetalle = $inIdDetalle;
    }

    public function getVcNombreDetalle(){
        return $this->vcNombreDetalle;
    }

    public function setVcNombreDetalle($vcNombreDetalle){
        $this->vcNombreDetalle = $vcNombreDetalle;
    }

    public function getVcDescDetalle(){
        return $this->vcDescDetalle;
    }

    public function setVcDescDetalle($vcDescDetalle){
        $this->vcDescDetalle = $vcDescDetalle;
    }

    public function getVcUrlImagenDetalle(){
        return $this->vcUrlImagenDetalle;
    }

    public function setVcUrlImagenDetalle($vcUrlImagenDetalle){
        $this->vcUrlImagenDetalle = $vcUrlImagenDetalle;
    }

    public function getVcTipoImagenDetalle(){
        return $this->vcTipoImagenDetalle;
    }

    public function setVcTipoImagenDetalle($vcTipoImagenDetalle){
        $this->vcTipoImagenDetalle = $vcTipoImagenDetalle;
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