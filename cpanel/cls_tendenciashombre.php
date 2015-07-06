<?php
include("cls_MantixBase20.php");

class Registro extends MantixBase {
    var $idseccion=6;
    var $marca='1290400232';
    function __construct() {
        $this->ini_datos("wee_noticias","id");
        $this->orden=array("ordenar"=>"orden","agrupar"=>"seccion='$this->marca'");
    }
    function formulario() {
        $m_Form = new MantixForm();
        $m_Form->atributos=array("texto_submit"=>"Registro");
        $m_Form->datos=$this->datos;
        $m_Form->controles=array(
            array("label"=>"Título:","campo"=>"titulo"),
            array("label"=>"Subtítulo:","campo"=>"titulo2"),
            array("label"=>"Imagen:","campo"=>"imgart","tipo"=>"archivogg",
                "extensiones"=>"*.jpg",
                "descripcion"=>"Imagenes JPG",
                "tooltip"=>"Formatos permitidos: jpg<br/>Tamaño ideal:700 x 424px"
                ),
            array("label"=>"Contenido:","campo"=>"contenido","tipo"=>"fck"),
            array("label"=>"Destacado Slider:","campo"=>"destacado","tipo"=>"checkbox"),
            array("label"=>"Destacado Portada:","campo"=>"portada_chica","tipo"=>"checkbox"),
            //array("label"=>"Destacado portada (columna 2):","campo"=>"portada_grande","tipo"=>"checkbox"),
//array("label"=>"Imágen portada (columna 2):","campo"=>"col2img","tipo"=>"fck"),
        );
        $res = $m_Form->ver();
        return  $res;
    }
    function lista() {
        $r = new MantixGrid();
        $sql="select c.*,if(destacado=1,'Destacado','') as destacado2,
            (select a.titulo from wee_secciones a where a.marca=c.seccion union
            select concat(a.titulo,' - ',b.titulo) from wee_secciones a
            inner join wee_subsecciones b on a.id=b.idseccion where b.marca=c.seccion order by titulo
            limit 1) as seccion from wee_noticias c inner join wee_subsecciones d on c.seccion=d.marca
            where d.id=$this->idseccion";
        $r->atributos=array("sql"=>$sql,"nropag"=>"20","ordenar"=>"orden asc");
        $r->orden=array("ordenar"=>"orden","agrupar"=>"seccion='$this->marca'");
        $r->columnas=array(
                array("titulo"=>"Título","campo"=>"titulo"),
                array("titulo"=>"Título 2","campo"=>"titulo2"),
                //array("titulo"=>"Sección","campo"=>"seccion"),
                array("titulo"=>"Destacado slider","campo"=>"destacado2"),
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
    function pre_del() {
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