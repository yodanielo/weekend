<?php
class buscar extends seccion {
    function index(){
        $q=str_replace("'","",$_GET["query"]);
        $db=dbInstance();
        //listo articulos
        $sql="select distinct * from wee_noticias where titulo like '%$q%' or contenido like '%$q%' or titulo2 like '%$q%' order by inserted desc";
        $params2["articulos"]=$db->loadObjectList($sql);
        //saco publicidad
        $params1["publicidad"]=$this->do_pubtop("portada",1);
        //saco menus
        $params1["secciones"]=$this->do_menu1();
        $params1["subsecciones"]=$this->do_menu2();
        //saco defecto
        /*if(!$_GET["id"]){
            $params2["defecto"]=$params2["articulos"][0]->id;
        }
        else{*/
            $params2["defecto"]=intval($_GET["id"]);
        /*}
        $sql="select banners from wee_secciones where wee_secciones.estado=1 and marca='".$params2["articulos"][0]->seccion."' union
                select banners from wee_subsecciones where wee_subsecciones.estado=1 and marca='".$params2["articulos"][0]->seccion."'";*/
        $sql="select banners from wee_subsecciones where wee_subsecciones.estado=1 and slug like 'portada'";
        $idb=$db->loadResult($sql);
        $first="select * from wee_publicidad where date(now()) between wee_publicidad.fechaini and wee_publicidad.fechafin and wee_publicidad.estado=1 and id = ";
        $second=" union ";
        if(trim($idb)!=""){
            $sql=$first.str_replace(",",$second.$first,$idb);
        }else
            $sql="";
        $params2["banners"]=$db->loadObjectList($sql);
        //saco ruta
        $params2["ruta"]="buscar?query=".$q."&id=";
        loadHTML("header.php", $params1);
        loadHTML("buscar.php", $params2);
        loadHTML("footer.php", $this->do_footer());
    }
}
?>
