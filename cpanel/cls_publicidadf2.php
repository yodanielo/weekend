<?php

include("cls_MantixBase20.php");

class Registro extends MantixBase {

    function __construct() {
        $this->ini_datos("wee_publicidad", "id");
    }

    function getFormatos() {
        $r = '';
        $r.='<option value="960 x 90"> Top 960 x 90</option>';
        //$r.='<option value="180 x 90">180 x 90</option>';
        $r.='<option value="240 x 306">Lateral 240 x 306</option>';
        return $r;
    }

    function formulario() {
        $m_Form = new MantixForm();
        $m_Form->atributos = array("texto_submit" => "Registro");
        $m_Form->datos = $this->datos;
        $m_Form->controles = array(
            array("label" => "Producto:", "campo" => "titulo"),
            array("label" => "Descripción:", "campo" => "descripcion"),
            array("label" => "Publicidad:", "campo" => "recurso3", "tipo" => "archivogg",
                "descripcion" => "Imágenes JPG",
                "tooltip" => "Formatos permtidos: jpg<br/>Tamaño: 778 x 486px",
                "extensiones" => "*.jpg"
            ),
            array("label" => "URL:", "campo" => "url"),
            array("label" => "Fecha de Inicio:", "campo" => "fechaini", "tipo" => "fecha"),
            array("label" => "Fecha de Fin:", "campo" => "fechafin", "tipo" => "fecha"),
                /* array("label" => "Ancho:", "campo" => "width","leyenda"=>"Solo para archivos flash, ingresar ancho y alto"),
                  array("label" => "Alto:", "campo" => "height"), */
        );
        $res = $m_Form->ver();
        return $res;
    }

    function lista() {
        $r = new MantixGrid();
        $sql = "select * from wee_publicidad where recurso3 is not null and recurso3 !=''";
        $r->atributos = array("sql" => $sql, "nropag" => "20", "ordenar" => "id desc");
        $r->columnas = array(
            array("titulo" => "Producto", "campo" => "titulo"),
        );
        return $r->ver();
    }

    function pre_ins() {
//        $this->datos->agregar("recurso",$_POST["recurso2"]);
//        $this->datos->agregar("recurso3",$_POST["recurso2"]);
        if (!$_POST["portada_grande"])
            $this->datos->agregar("portada_grande", "0");
        if (!$_POST["portada_chica"])
            $this->datos->agregar("portada_chica", "0");
        if (!$_POST["destacado"])
            $this->datos->agregar("destacado", "0");
    }

    function pre_del() {
        //varios
        if ($_POST["cid"]) {
            $res = $this->datos->ejecutar("select * from wee_publicidad where id in(" . implode(",", $_POST["cid"]) . ")");
            while ($r = mysql_fetch_object($res)) {
                if ($r->recurso)
                    unlink("../images/recursos/$r->recurso");
                if ($r->recurso2)
                    unlink("../images/recursos/$r->recurso2");
                if ($r->recurso3)
                    unlink("../images/recursos/$r->recurso3");
            }
        }else {
            $res = $this->datos->ejecutar("select * from wee_publicidad where id = ".$_POST["idobj"]);
            if($r=mysql_fetch_object($res)){
                if ($r->recurso)
                    unlink("../images/recursos/$r->recurso");
                if ($r->recurso2)
                    unlink("../images/recursos/$r->recurso2");
                if ($r->recurso3)
                    unlink("../images/recursos/$r->recurso3");
            }
        }
    }

    function alerta() {

    }

}

?>