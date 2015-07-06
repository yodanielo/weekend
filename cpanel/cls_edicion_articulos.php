<?php

include("cls_MantixBase20.php");

class Registro extends MantixBase {

    function __construct() {
        $this->ini_datos("wee_ediciondigital_articulos", "id");
    }
    function formulario() {
        $m_Form = new MantixForm();
        $m_Form->atributos = array("texto_submit" => "Registro");
        $m_Form->datos = $this->datos;
        $m_Form->controles = array(
            array("label" => "Título:", "campo" => "titulo"),
            array("label" => "Imagen:", "campo" => "edmini", "tipo" => "archivogg",
                "tooltip" => "Formatos permitidos: jpg<br/>Tamaño ideal: 220 x 280px",
                "extensiones" => "*.jpg",
                "descripcion" => "Archivos JPG",
            ),
            array("label" => "Archivo PDF:", "campo" => "contenido", "tipo" => "archivogg",
                "tooltip" => "Formatos permitidos: pdf",
                "extensiones" => "*.pdf",
                "descripcion" => "Archivos PDF",
            ),
            array("label" => "Archivo Flash:", "campo" => "flashlibro", "tipo" => "archivogg",
                "tooltip" => "Formatos permitidos: swf",
                "extensiones" => "*.swf",
                "descripcion" => "Archivos Flash",
            ),
        );
        $res = $m_Form->ver();
        return $res;
    }

    function lista() {
        $r = new MantixGrid();
        $sql = "select * from wee_ediciondigital_articulos";
        $r->atributos = array("sql" => $sql, "nropag" => "20", "ordenar" => "id desc");
        $r->columnas = array(
            array("titulo" => "Título", "campo" => "titulo"),
        );
        return $r->ver();
    }
    function pre_del(){
        //varios
        if ($_POST["cid"]) {
            $res = $this->datos->ejecutar("select * from wee_ediciondigital_articulos where id in(" . implode(",", $_POST["cid"]) . ")");
            while ($r = mysql_fetch_object($res)) {
                if ($r->edmini)
                    $rpt=unlink("../images/recursos/$r->edmini");
                if ($r->contenido)
                    $rpt=unlink("../images/recursos/$r->contenido");
                if ($r->flashlibro)
                    $rpt=unlink("../images/recursos/$r->flashlibro");
            }
        }else {
            $res = $this->datos->ejecutar("select * from wee_ediciondigital_articulos where id = ".$_POST["idobj"]);
            if($r=mysql_fetch_object($res)){
                if ($r->edmini)
                    $rpt=unlink("../images/recursos/$r->edmini");
                if ($r->contenido)
                    $rpt=unlink("../images/recursos/$r->contenido");
                if ($r->flashlibro)
                    $rpt=unlink("../images/recursos/$r->flashlibro");
            }
        }
    }
}

?>