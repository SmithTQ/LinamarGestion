<?php

class Crud{

    protected $tabla;
    protected $conexion;
    protected $wheres = "";
    protected $sql = null;

    public function __construct($tabla = null) {
        $this->conexion = (new Conexion())->conectar();
        $this->tabla = $tabla;
    }

    public function get($query = null, $parameters = null) {
        try {
            if(empty($query) || $query == null){
                $this->sql = "SELECT * FROM {$this->tabla} {$this->wheres}";
            }else{
                $this->sql = $query;
            }
            
            $sth = $this->conexion->prepare($this->sql);
            $sth->execute($parameters);
            return $sth->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function first($query = null, $parameters = null) {
        $lista = $this->get($query = null, $parameters = null);
        if (is_array($lista) && count($lista) > 0) {
            return $lista[0];
        } else {
            return null;
        }
    }

    public function insert($obj) {
        try {
            $campos = implode("`, `", array_keys($obj)); //nombre`, `apellido`, `edad
            $valores = ":" . implode(", :", array_keys($obj)); //:nombre, :apellido, :edad
            
            $this->sql = "INSERT INTO {$this->tabla} (`{$campos}`) VALUES ({$valores})";
            $this->ejecutar($obj);

            return $this->lastInsertId();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function update($obj) {
        try {
            $campos = "";
            foreach ($obj as $llave => $valor) {
                $campos .= "`$llave`=:$llave,"; //`nombres`=:nombres,`edad`=:edad
            }
            $campos = rtrim($campos, ",");

            $this->sql = "UPDATE {$this->tabla} SET {$campos} {$this->wheres}";

            return $this->ejecutar($obj);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function delete() {
        try {
            //$this->sql = "DELETE FROM {$this->tabla} {$this->wheres}";
            $this->sql = "UPDATE {$this->tabla} SET `inHabilitado`=0 {$this->wheres}";
            return $this->ejecutar();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function where($llave, $condicion, $valor) {
        $this->wheres .= (strpos($this->wheres, "WHERE")) ? " AND " : " WHERE ";
        $this->wheres .= "`$llave` $condicion " . ((is_string($valor)) ? "\"$valor\"" : $valor) . " ";
        return $this;
    }

    public function orWhere($llave, $condicion, $valor) {
        $this->wheres .= (strpos($this->wheres, "WHERE")) ? " OR " : " WHERE ";
        $this->wheres .= "`$llave` $condicion " . ((is_string($valor)) ? "\"$valor\"" : $valor) . " ";
        return $this;
    }

    private function ejecutar($obj = null) {
        $sth = $this->conexion->prepare($this->sql);
        if ($obj !== null) {
            foreach ($obj as $llave => $valor) {
                //echo $llave . " => " . $valor . "<br>";
                if (empty($valor)) {
                    $valor = NULL;
                }
                $sth->bindValue(":$llave", $valor);
            }
        }
        $sth->execute();
        $this->reiniciarValores();
        return $sth->rowCount();
    }

    public function lastInsertId() {

        try {
            // La tabla obligatoriamente debe tener un campo tsFechaCreación
            $this->sql = "SELECT * FROM {$this->tabla} ORDER BY tsFechaCreacion DESC LIMIT 1";

            $sth = $this->conexion->prepare($this->sql);
            $sth->execute();
            return $sth->fetch(PDO::FETCH_NUM)[0];
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            return 0;
        }
    }

    /* unction getCorrelative($conexion) {
        $sql = "SELECT MAX(inCod) AS inCod FROM mi_tabla"; // Cambia "id" y "mi_tabla"
        $resultado = $conexion->query($sql);
        $fila = $resultado->fetch(PDO::FETCH_ASSOC);
        return $fila['ultimo'] + 1;
    } */

    private function reiniciarValores() {
        $this->wheres = "";
        $this->sql = null;
    }

}
