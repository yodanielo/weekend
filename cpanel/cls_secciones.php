<?php
include("cls_MantixBase20.php");

class Registro extends MantixBase {
    function __construct() {
        $this->ini_datos("wee_secciones","id");
    }
    function getPubTop() {
        $sql="select * from wee_publicidad where formato like '960 x 90'";
        $res=$this->datos->ejecutar($sql);
        $cad='';
        while($r=mysql_fetch_object($res)) {
            $cad.='<option value="'.$r->id.'">'.$r->titulo.'</option>';
        }
        return $cad;
    }
    function formulario() {
        $m_Form = new MantixForm();
        $m_Form->atributos=array("texto_submit"=>"Registro");
        $m_Form->datos=$this->datos;
        $m_Form->controles=array(
                array("label"=>"Título","campo"=>"titulo"),
                array("label"=>"Publicidad Top:","campo"=>"pubtop","tipo"=>"select","opciones"=>$this->getPubTop()),
                array("label"=>"Banners","campo"=>"banners","tipo"=>"transferencia","tabla_asoc"=>"wee_publicidad","campo_asoc"=>"recurso","id_asoc"=>"id")
        );
        $res = $m_Form->ver();
        return  $res;
    }
    function lista() {
        $r = new MantixGrid();
        $sql="select * from wee_secciones";
        $r->atributos=array("sql"=>$sql,"nropag"=>"20","ordenar"=>"id desc","ver_eliminar"=>"0");
        $r->columnas=array(
                array("titulo"=>"Título","campo"=>"titulo"),
        );
        return $r->ver();
    }
    function toURL($a) {
        $a=preg_replace('/([\/|\?| ]+)/','-',$a);
        $a=str_replace(array("á","é","í","ó","ú","ñ"),array("a","e","i","o","u","n"),$a);
        return $a;
    }
    function pre_ins() {
        $marca=mktime();
        $this->datos->ejecutar("insert into wee_marcatodos values('".$marca."')");
        $this->datos->agregar("slug",$this->toURL($_POST["titulo"]));
        $this->datos->agregar("marca",$marca);
    }
    function pre_upd() {
        $this->datos->agregar("slug",$this->toURL($_POST["titulo"]));
    }
    function pre_del() {
        if(count($_POST["cid"])>0) {
            $marca=$this->datos->get_simple("select marca from wee_secciones where id=",$_POST["idobj"]);
            $this->datos->ejecutar("delete from wee_marcatodos where marca='".$marca."'");
        }else {
            foreach($_POST["cid"] as $cid) {
                $marca=$this->datos->get_simple("select marca from wee_secciones where id=",$cid);
                $this->datos->ejecutar("delete from wee_marcatodos where marca='".$marca."'");
            }
        }
    }
}
?>