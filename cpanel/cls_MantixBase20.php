<?php

include_once("cls_MantixOaD.php");
include_once("cls_MantixForm20.php");
include_once("cls_MantixGrid20.php");
include_once("cls_MantixBD.php");

class MantixBase {

//var $id;
    var $datos;
    var $grid_ordenar_campo;
    var $orden;

//var $tabla;

    function ini_datos($tabla, $ordenar) {
        $this->tabla = $tabla;
        $this->datos = new MantixOaD();
        $this->datos->tabla = $tabla;
        $this->datos->criterio = $ordenar;
        $this->datos->valor = $_POST[$ordenar];
        $this->datos->get_tipos();
        $this->id = $_POST["idobj"];
    }
    function onlyUpdate($id){
        if($_POST["accion"]!=20 && $_POST["accion"]!=2){
            $_POST["accion"]=20;
            $_POST["idobj"]=$id;
        }
    }
    function __destruct() {
        unset($this->datos);
    }

    function get_fila($idu) {
        $this->datos->get_fila($idu);
    }

    function pre_ins() {

    }

    function pre_upd() {

    }

    function pre_del() {

    }

    function post_ins() {

    }

    function post_upd() {

    }

    function post_del() {

    }

    function cbo_activo() {
        return '<option value="1">Activo</option><option value="0">Inactivo</option>';
    }

    function get_decision() {
        return '<option value="1">Sí</option><option value="0">No</option>';
    }

    function insertar_orden() {
        if (is_array($this->orden)) {
            include 'includes/ordenar.php';
            $x = new grid_ordenar($this->datos, $this->tabla,$this->orden["ordenar"],$this->orden["agrupar"]);
            $x->insertar_orden($this->id);
        }
    }

    function eliminar_orden($id) {
        if (is_array($this->orden)) {
            include 'includes/ordenar.php';
            $x = new grid_ordenar($this->datos, $this->tabla,$this->orden["ordenar"],$this->orden["agrupar"]);
            $x->eliminar_orden($id);
        }
    }

    function insertar() {
        $this->datos->agregar_todo();
        $this->datos->agregar("estado", "1");
        $this->datos->agregar("inserted", date("Y-m-d"));
        $this->datos->agregar("user_inserted", $_SESSION["user"]["id"]);
        //$this->datos->agregar("estado",1);
        $this->datos->desmarcar("updated");
        $this->datos->desmarcar("user_updated");
        $this->pre_ins();
        $this->datos->insertar();
        $this->id = $this->datos->lastid();
        $this->insertar_orden($this->id);
        $this->post_ins();
        switch ($this->datos->c_error) {
            case 0: return rawurlencode("Inserci&oacute;n realizada con &eacute;xito");
                break;
            case 16: return mysql_error();
                break;
            case 18: return "No se pudo insertar porque el valor ya existe en la base de datos.";
        }
    }

    function actualizar() {
        $this->datos->agregar_todo();
        $this->datos->agregar("estado", "1");
        $this->datos->agregar("updated", date("Y-m-d h:i:s"));
        $this->datos->agregar("user_updated", $_SESSION["user"]["id"]);
        //$this->datos->desmarcar("estado");
        $this->datos->desmarcar("inserted");
        $this->datos->desmarcar("user_inserted");
        $this->pre_upd();
        $this->datos->actualizar($this->id);
        $this->post_upd();
        if ($this->datos->c_error != 0) {
            return "Se encontr&oacute; un Problema al Intentar Actualizar el Registro. Por favor, comun&iacute;quese con Soporte.";
        } {

            return "Actualizaci&oacute;n realizada con &eacute;xito";
        }
    }

    function verificar_tabla($cad, $tab) {
        for ($t = 0; $t < count($cad); $t++) {
            if ($cad[$t] == $tab) {
                return false;
            }
        }
        return true;
    }

    function validar_fk($cid) {
        global $BD;
        $fk = $BD[$this->tabla]["fk"];
        $cad = array();
        for ($a = 0; $a < count($fk); $a++) {
            if ($this->datos->buscar($fk[$a]["tabla"], $fk[$a]["campo"], $cid)) {
                if ($this->verificar_tabla($cad, $fk[$a]["tabla"]))
                    array_push($cad, $fk[$a]["tabla"]);
            }
        }
        return implode(",", $cad);
    }

    function verificar_fk() {
        global $BD;
        return $BD[$this->tabla]["fk"];
    }

    function validar_cascada($cid) {
        global $BD;
        $fk = $BD[$this->tabla]["cascada"];
        $cad = array();
        for ($a = 0; $a < count($fk); $a++) {
            $this->datos->eliminar_key($fk[$a]["tabla"], $fk[$a]["campo"], $cid);
        }
    }

    function eliminar_simple() {
        $this->pre_del();
        $res_cascada = true;
        $cad = $this->validar_fk($this->id);
        if ($cad != "") {
            return "No se pudo eliminar debido a que existe el valor en " . $cad;
        } else {
            $this->validar_cascada($this->id);
            $this->eliminar_orden($this->id);
            $this->datos->eliminar_simple($this->id);
            $this->post_del();
            return "Eliminaci&oacute;n realizada con &eacute;xito";
        }
    }

    function activar_simple() {
        $this->datos->activar_simple($this->id);
        if ($this->datos->c_error != 0) {
            return "Se encontr&oacute; un Problema al Intentar Activar el Registro. Por favor, comun&iacute;quese con Soporte.";
        } {

            return "Activaci&oacute;n realizada con &eacute;xito";
        }
    }

    function desactivar_simple() {
        $this->datos->desactivar_simple($this->id);
        if ($this->datos->c_error != 0) {
            return "Se encontr&oacute; un Problema al Intentar Desactivar el Registro. Por favor, comun&iacute;quese con Soporte.";
        } {

            return "DesActivaci&oacute;n realizada con &eacute;xito";
        }
    }

    function ordenar() {
        include("includes/ordenar.php");
        $a = new grid_ordenar($this->datos, $this->tabla,$this->orden["ordenar"],$this->orden["agrupar"]);
        $a->ordenar_todos();
    }

    function grid_cambiar_anio() {
        $ord = $_POST["ord"];
        $ord_ant = $_POST["ord_ant"];
        foreach ($ord as $key => $o) {
            if ($ord[$key] != $ord_ant[$key]) {
                $sql = "update wta_torneosanio set nombre ='" . trim($ord[$key]) . "' where nombre like '" . substr($ord_ant[$key], strlen($ord_ant[$key]) - 4) . "'";
                $this->datos->ejecutar($sql);
            }
        }
    }

    function eliminar() {
        $this->pre_del();
        $fk = $this->verificar_fk();
        $cad = array();
        if (isset($fk)) {
            $h = $_POST["cid"];
            for ($x = 0; $x < count($h); $x++) {
                $this->eliminar_orden($x);
                for ($a = 0; $a < count($fk); $a++) {
                    if ($this->datos->buscar($fk[$a]["tabla"], $fk[$a]["campo"], $h[$x])) {
                        $del = false;
                        if ($this->verificar_tabla($cad, $fk[$a]["tabla"]))
                            array_push($cad, $fk[$a]["tabla"]);
                    }
                    else {
                        $del = true;
                        $this->datos->eliminar_key($fk[$a]["tabla"], $fk[$a]["campo"], $h[$x]);
                    }
                }
                if ($del)
                    $this->datos->eliminar_key($this->tabla, "id", $h[$x]);
            }
            $scad = implode(",", $cad);
            if ($scad != "") {
                return "No se pudo eliminar alguno o todos los registros debido a que existe el valor en " . $scad;
            } else {
                return "Eliminaci&oacute;n realizada con &eacute;xito";
            }
        } else {
            $this->datos->eliminar();
        }
        $this->post_del();
        return "Eliminaci&oacute;n realizada con &eacute;xito";
    }

    function activar() {
        $this->datos->activar();
        return "Activaci&oacute;n realizada con &eacute;xito";
    }

    function grid_toggle_estado() {
        $this->datos->toggle_estado();
        return "Cambio de estado realizado con &eacute;xito";
    }

    function desactivar() {
        $this->datos->desactivar();
        return "Desactivaci&oacute;n realizada con &eacute;xito";
    }

    function procesar_galeria($t, $c) {
        $this->datos->ejecutar("delete from " . $t . " where idc=" . $this->id);
        $fo = $_POST[$c];
        $f = explode("/-/", $fo);
        $fotos = new MantixOaD();
        $fotos->tabla = $t;
        $fotos->criterio = "id";
        $fotos->valor = -1;
        $fotos->get_tipos();
        for ($a = 0; $a < count($f); $a++) {
            $fotos->agregar("idc", $this->id);
            $fotos->agregar("imagen", $f[$a]);
            if ($f[$a] != "")
                $fotos->insertar();
        }
    }

}

?>