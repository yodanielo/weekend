<?php
//portada col 2
include("cls_MantixBase20.php");

class Registro extends MantixBase {

    function __construct() {
        $this->ini_datos("wee_noticias", "id");
        $this->orden=array("ordenar"=>"orden","agrupar"=>"portada_grande=1");
        /*if ($_POST["accion"] != 20 && $_POST["accion"] != 2) {
            header("location: portada.php");
        }*/
    }
    function formulario() {

        $m_Form = new MantixForm();
        $m_Form->atributos = array("texto_submit" => "Registro");
        $m_Form->datos = $this->datos;
        $m_Form->controles=array(
            array("label"=>"Título:","campo"=>"titulo"),
            array("label"=>"Subtítulo:","campo"=>"titulo2"),
            //array("label"=>"Seccion","campo"=>"seccion","tipo"=>"select","opciones"=>$this->categorias()),
            array("label"=>"Contenido:","campo"=>"contenido","tipo"=>"fck"),
            array("label"=>"Destacado Slider:","campo"=>"destacado","tipo"=>"checkbox"),
            array("label"=>"Mostrar en portada: (Columna 1):","campo"=>"portada_chica","tipo"=>"checkbox"),
            array("label"=>"Mostrar en portada: (Columna 2):","campo"=>"portada_grande","tipo"=>"checkbox"),
        );
        $res = $m_Form->ver();
        if ($_POST["accion"] == 20 || $_POST["accion"] == 2) {
            return $res;
        }else{
            return "&nbsp;";
        }
    }

    function lista() {
        $r = new MantixGrid();
        $sql = "SELECT concat(wee_noticias.titulo,' ',wee_noticias.titulo2) as noticia,
            wee_subsecciones.titulo as 'subseccion', wee_noticias.*
            FROM `wee_noticias` inner join wee_subsecciones on wee_noticias.seccion=wee_subsecciones.marca
            where portada_grande=1";
        $r->atributos = array("sql" => $sql, "nropag" => "20", "ordenar" => "id desc", "ver_eliminar" => "0");
        $r->orden=array("ordenar"=>"orden","agrupar"=>"portada_grande=1");
        $r->columnas = array(
            array("titulo" => "Título", "campo" => "noticia"),
            array("titulo" => "Seccion", "campo" => "subseccion"),

        );
        return $r->ver();
    }
    function pre_upd(){
        if($_POST["portada_grande"]=="1")
            $this->datos->ejecutar("update wee_noticias set portada_grande=0 where id!=".$this->id);
        $this->datos->agregar("seccion","$this->marca");
        if(!$_POST["portada_grande"])
            $this->datos->agregar("portada_grande","0");
        if(!$_POST["portada_chica"])
            $this->datos->agregar("portada_chica","0");
        if(!$_POST["destacado"])
            $this->datos->agregar("destacado","0");
    }
    function pre_ins(){
        if($_POST["portada_grande"]=="1")
            $this->datos->ejecutar("update wee_noticias set portada_grande=0");
        $this->datos->agregar("seccion","$this->marca");
    }
}

?>