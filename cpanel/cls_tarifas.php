<?php

include("cls_MantixBase20.php");

class Registro extends MantixBase {

    function __construct() {
        $this->ini_datos("wee_estaticos", "id");
        $this->onlyUpdate(2);
    }

    function getPubTop() {
        $sql = "select * from wee_publicidad where formato like '960 x 90'";
        $res = $this->datos->ejecutar($sql);
        $cad = '';
        while ($r = mysql_fetch_object($res)) {
            $cad.='<option value="' . $r->id . '">' . $r->titulo . '</option>';
        }
        return $cad;
    }

    function formulario() {
        $m_Form = new MantixForm();
        $m_Form->atributos = array("texto_submit" => "Registro");
        $m_Form->datos = $this->datos;
        $m_Form->controles = array(
            array("label" => "Título:", "campo" => "titulo"),
            array("label" => "Contenido:", "campo" => "contenido", "tipo" => "fck"),
            array("label" => "Publicidad Top:", "campo" => "pubtop", "tipo" => "muchosauno", "tabla_asoc" => "wee_publicidad", "campo_asoc" => "recurso", "id_asoc" => "id", "formato"=>"960 x 90"),
            array("label" => "Banners", "campo" => "banners", "tipo" => "transferencia", "tabla_asoc" => "wee_publicidad", "campo_asoc" => "recurso", "id_asoc" => "id")
        );
        $res = $m_Form->ver();
        return $res;
    }

    function lista() {
        $r = new MantixGrid();
        $sql = "select * from wee_estaticos where id=2";
        $r->atributos = array("sql" => $sql, "nropag" => "20", "ordenar" => "id desc");
        $r->columnas = array(
            array("titulo" => "Título", "campo" => "titulo"),
        );
        return $r->ver();
    }

}

?>