<?php

class Usuarios extends ModeloGenerico {

    protected $inIdUsuario;
    protected $vcNombreUsuario;
    protected $vcCorreoUsuario;
    protected $vcContrasenaUsuario;
    protected $tsFechaCreacion;
    protected $tsFechaModificacion;
    protected $tsFechaEliminacion;  
    protected $inHabilitado;


    public function __construct($propiedades = null) {
        parent::__construct("tb_usuarios", Usuarios::class, $propiedades);
    }

    function getInIdUsuario() {
        return $this->inIdUsuario;
    }
    
    function setInIdUsuario($inIdUsuario) {
        $this->inIdUsuario = $inIdUsuario;
    }

    function getVcNombreUsuario() {
        return $this->vcNombreUsuario;
    }

    function setVcNombreUsuario($vcNombreUsuario) {
        $this->vcNombreUsuario = $vcNombreUsuario;
    }

    function getVcCorreoUsuario() {
        return $this->vcCorreoUsuario;
    }

    function setVcCorreoUsuario($vcCorreoUsuario) {
        $this->vcCorreoUsuario = $vcCorreoUsuario;
    }

    function getVcContrasenaUsuario() {
        return $this->vcContrasenaUsuario;
    }

    function setVcContrasenaUsuario($vcContrasenaUsuario) {
        $this->vcContrasenaUsuario = $vcContrasenaUsuario;
    }

    function getTsFechaCreacion() {
        return $this->tsFechaCreacion;
    }

    function setTsFechaCreacion($tsFechaCreacion) {
        $this->tsFechaCreacion = $tsFechaCreacion;
    }

    function getTsFechaModificacion() {
        return $this->tsFechaModificacion;
    }

    function setTsFechaModificacion($tsFechaModificacion) {
        $this->tsFechaModificacion = $tsFechaModificacion;
    }

    function getTsFechaEliminacion() {
        return $this->tsFechaEliminacion;
    }

    function setTsFechaEliminacion($tsFechaEliminacion) {
        $this->tsFechaEliminacion = $tsFechaEliminacion;
    }

    function getInHabilitado() {
        return $this->inHabilitado;
    }

    function setInHabilitado($inHabilitado) {
        $this->inHabilitado = $inHabilitado;
    }

}
