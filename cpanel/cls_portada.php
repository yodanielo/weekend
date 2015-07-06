<?php

include("cls_MantixBase20.php");

class Registro extends MantixBase {

    function __construct() {
        $this->ini_datos("wee_portada", "id");
        if ($_POST["accion"] != 20 && $_POST["accion"] != 2) {
            $_POST["accion"] = 20;
            $_POST["idobj"] = "1";
        }
    }

    function get_articulos() {
        $sql = "select * from wee_noticias";
        $res = $this->datos->ejecutar($sql);
        $cad = '';
        while ($r = mysql_fetch_object($res)) {
            $cad.='<option value="' . $r->id . '">' . utf8_encode($r->titulo) . '</option>';
        }
        return $cad;
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
            array("label" => "Publicidad Top:", "campo" => "pubtop", "tipo" => "muchosauno", "tabla_asoc" => "wee_publicidad", "campo_asoc" => "recurso", "id_asoc" => "id", "formato"=>"960 x 90"),
            array("label" => "Publicidad Slider:", "campo" => "minibanners", "tipo" => "transferencia", "tabla_asoc" => "wee_publicidad", "campo_asoc" => "recurso2", "id_asoc" => "id","formato"=>"%%","width"=>140,"height"=>175,"consulta"=>"slider"),
                //array("label" => "Banners", "campo" => "banners", "tipo" => "transferencia", "tabla_asoc" => "wee_publicidad", "campo_asoc" => "recurso", "id_asoc" => "id")
        );
        $res = $m_Form->ver();
        return $res;
    }

    function lista() {
        $r = new MantixGrid();
        $sql = "SELECT concat(wee_noticias.titulo,' ',wee_noticias.titulo2) as noticia,
            wee_subsecciones.titulo as 'subseccion', wee_noticias.*,if(destacado=1,'Destacado Slider','') as dslider,
            if(portada_chica=1,'Portada','') as dcol1,if(portada_grande=1,'Portada (Columna 2)','') as dcol2
            FROM `wee_noticias` inner join wee_subsecciones on wee_noticias.seccion=wee_subsecciones.marca
            where destacado=1 or portada_chica=1 or portada_grande=1";
        $r->atributos = array("sql" => $sql, "nropag" => "20", "ordenar" => "id desc", "ver_eliminar" => "0");
        $r->columnas = array(
            array("titulo" => "Título", "campo" => "noticia"),
            array("titulo" => "Seccion", "campo" => "subseccion"),
            array("titulo" => "Destacado Slider", "campo" => "dslider"),
            array("titulo" => "Portada", "campo" => "dcol1"),
            //array("titulo" => "Portada (Columna 2)", "campo" => "dcol2"),
        );
        return "&nbsp;";
        return $r->ver();
    }

}

?>