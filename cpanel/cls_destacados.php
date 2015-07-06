<?php

include("cls_MantixBase20.php");

class Registro extends MantixBase {

    function __construct() {
        $this->ini_datos("wee_noticias", "id");
        /*if ($_POST["accion"] != 20 && $_POST["accion"] != 2) {
            header("location: portada.php");
        }*/
    }

    function getpublidadtop() {
        $sql = "select * from wee_publicidad where formato='960 x 90'";
        $res = $this->datos->ejecutar($sql);
        $cad = '';
        while ($r = mysql_fetch_object($res)) {
            $cad.='<option value="' . $r->id . '">' . $r->titulo . '</option>';
        }
        return $cad;
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
        $m_Form->controles=array(
            array("label"=>"Título:","campo"=>"titulo"),
            array("label"=>"Subtítulo:","campo"=>"titulo2"),
            array("label"=>"Imagen:","campo"=>"imgart","tipo"=>"archivogg",
                "extensiones"=>"*.jpg",
                "descripcion"=>"Imagenes JPG",
                "tooltip"=>"Formatos permitidos: jpg<br/>Tamaño ideal:700 x 424px"
                ),
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
            wee_subsecciones.titulo as 'subseccion', wee_noticias.*,if(destacado=1,'Destacado Slider','') as dslider,
            if(portada_chica=1,'Portada (Columna 1)','') as dcol1,if(portada_grande=1,'Portada (Columna 2)','') as dcol2
            FROM `wee_noticias` inner join wee_subsecciones on wee_noticias.seccion=wee_subsecciones.marca
            where destacado=1 or portada_chica=1 or portada_grande=1";
        $r->atributos = array("sql" => $sql, "nropag" => "20", "ordenar" => "id desc", "ver_eliminar" => "0");
        $r->columnas = array(
            array("titulo" => "Título", "campo" => "noticia"),
            array("titulo" => "Seccion", "campo" => "subseccion"),
            array("titulo" => "Destacado Slider", "campo"=>"dslider"),
            array("titulo" => "Portada (Columna 1)", "campo"=>"dcol1"),
            array("titulo" => "Portada (Columna 2)", "campo"=>"dcol2"),

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
    function pre_del(){
        //varios
        if ($_POST["cid"]) {
            $res = $this->datos->ejecutar("select * from wee_noticias where id in(" . implode(",", $_POST["cid"]) . ")");
            while ($r = mysql_fetch_object($res)) {
                if ($r->imgart)
                    $rpt=unlink("../images/recursos/$r->imgart");
            }
        }else {
            $res = $this->datos->ejecutar("select * from wee_noticias where id = ".$_POST["idobj"]);
            if($r=mysql_fetch_object($res)){
                if ($r->imgart)
                    $rpt=unlink("../images/recursos/$r->imgart");
            }
        }
    }
}

?>