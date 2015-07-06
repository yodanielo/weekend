<?php
include("cls_MantixBase20.php");

class Registro extends MantixBase {
    function __construct() {
        $this->ini_datos("wee_noticias","id");
    }
    function categorias(){
        $cad='';
        $sql="select a.marca as mm, a.titulo from wee_secciones a where (select count(*) from wee_subsecciones where idseccion=a.id)=0 and esmodulo=0 union 
                select b.marca, concat(a.titulo,' - ',b.titulo) from wee_secciones a inner join wee_subsecciones b on a.id=b.idseccion
                where b.esmodulo=0
                order by titulo";
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
            array("label"=>"Imagen:","campo"=>"imgart","tipo"=>"archivogg",
                "extensiones"=>"*.jpg",
                "descripcion"=>"Imagenes JPG",
                "tooltip"=>"Formatos permitidos: jpg<br/>Tamaño ideal:700 x 424px"
                ),
            array("label"=>"Seccion","campo"=>"seccion","tipo"=>"select","opciones"=>$this->categorias()),
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
        $sql="select *,if(destacado=1,'Destacado','') as destacado2,
            (select a.titulo from wee_secciones a where a.marca=wee_noticias.seccion union
            select concat(a.titulo,' - ',b.titulo) from wee_secciones a
            inner join wee_subsecciones b on a.id=b.idseccion where b.marca=wee_noticias.seccion order by titulo
            limit 1) as seccion from wee_noticias";
        $r->atributos=array("sql"=>$sql,"nropag"=>"20","ordenar"=>"orden asc");
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
    }
    function pre_ins(){
        if($_POST["portada_grande"]=="1")
            $this->datos->ejecutar("update wee_noticias set portada_grande=0");
    }
}
?>