<?php
include("cls_MantixBase20.php");

class Registro extends MantixBase {
    var $idseccion=1;
    function __construct() {
        $this->ini_datos("wee_noticias","id");
        $this->orden=array("ordenar"=>"orden","agrupar"=>"seccion='$this->idseccion'");
    }
    function categorias(){
        $cad='';
        $sql="select a.marca as mm, a.titulo from wee_subsecciones a where a.esmodulo=0 and a.idseccion=$this->idseccion";
        $res=$this->datos->ejecutar($sql);
        while($r=mysql_fetch_object($res)){
            $cad.='<option value="'.utf8_encode($r->mm).'">'.utf8_encode($r->titulo).'</option>';
        }
        return $cad;
    }
    function formulario() {
        $m_Form = new MantixForm();
        $m_Form->atributos=array("texto_submit"=>"Registro");
        $m_Form->datos=$this->datos;
        $m_Form->controles=array(
            array("label"=>"Título:","campo"=>"titulo"),
            array("label"=>"Subtítulo:","campo"=>"titulo2"),
            array("label"=>"Sub-Seccion","campo"=>"seccion","tipo"=>"select","opciones"=>$this->categorias()),
            array("label"=>"Contenido:","campo"=>"contenido","tipo"=>"fck"),
            array("label"=>"Destacado Slider:","campo"=>"destacado","tipo"=>"checkbox"),
            array("label"=>"Mostrar en portada: (Columna 1):","campo"=>"portada_chica","tipo"=>"checkbox"),
            array("label"=>"Mostrar en portada: (Columna 2):","campo"=>"portada_grande","tipo"=>"checkbox"),
        );
        $res = $m_Form->ver();
        return  $res;
    }
    function lista() {
        $r = new MantixGrid();
        $sql="select c.*,if(destacado=1,'Destacado','') as destacado2,
            (select a.titulo from wee_secciones a where a.marca=c.seccion union
            select b.titulo from wee_secciones a
            inner join wee_subsecciones b on a.id=b.idseccion where b.marca=c.seccion order by titulo
            limit 1) as seccion from wee_noticias c inner join wee_subsecciones d on c.seccion=d.marca
            where d.idseccion=$this->idseccion";
        $r->atributos=array("sql"=>$sql,"nropag"=>"20","ordenar"=>"orden desc");
        //$r->orden=array("ordenar"=>"orden","agrupar"=>"seccion='$this->idseccion'");
        $r->columnas=array(
                array("titulo"=>"Título","campo"=>"titulo"),
                array("titulo"=>"Título 2","campo"=>"titulo2"),
                array("titulo"=>"Sección","campo"=>"seccion"),
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
}
?>