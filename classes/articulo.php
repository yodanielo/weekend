<?php
class articulo extends seccion{
    function index($a,$b=null,$c=null){
        //protejo
        $a=str_replace("'","",$a);
        $b=str_replace("'","",$b);
        $c=str_replace("'","",$c);

        $tripas=destripar();

        //hallo el articulo asociado
        $db=dbInstance();
        $num=0;
        $psql="";
        if(is_numeric($c)){
            $num=$c;
            $psql="select * from wee_publicidad inner join wee_subsecciones 
                    on wee_publicidad.id=wee_subsecciones.pubtop where date(now()) between wee_publicidad.fechaini and wee_publicidad.fechafin and wee_publicidad.estado=1 and wee_subsecciones.slug like '".$b."'";
        }
        elseif(is_numeric($b)){
            $num=$b;
            $psql="select * from wee_publicidad inner join wee_secciones
                    on wee_publicidad.id=wee_secciones.pubtop where date(now()) between wee_publicidad.fechaini and wee_publicidad.fechafin and wee_publicidad.estado=1 and wee_secciones.slug like '".$a."'";
        }else{
            $psql= "select wee_publicidad.* from wee_publicidad inner join wee_secciones
                    on wee_publicidad.id=wee_secciones.pubtop where date(now()) between wee_publicidad.fechaini and wee_publicidad.fechafin and wee_publicidad.estado=1 and wee_secciones.slug like '".$a."' union";
            $psql=" select wee_publicidad.* from wee_publicidad inner join wee_subsecciones
                    on wee_publicidad.id=wee_subsecciones.pubtop where date(now()) between wee_publicidad.fechaini and wee_publicidad.fechafin and wee_publicidad.estado=1 and wee_subsecciones.slug like '".$b."'";
        }
        //obtengo los demas articulos asociados
        if($num>0){
            $sql="select * from wee_noticias where wee_noticias.estado=1 and seccion=(select a.seccion from wee_noticias a where a.id=".intval($num).") order by orden";
        }else{
            if($b){
                $sql="select wee_noticias.* from wee_noticias
                    inner join wee_subsecciones on wee_noticias.seccion=wee_subsecciones.marca
                    where wee_noticias.estado=1 and wee_subsecciones.slug like '".$b."' order by wee_noticias.orden";
            }else{
                $sql="select wee_noticias.* from wee_noticias
                    inner join wee_secciones on wee_noticias.seccion=wee_secciones.marca
                    where wee_noticias.estado=1 and wee_secciones.slug like '".$a."' order by wee_noticias.orden";
            }
        }
        //publicidad top
        $params1["publicidad"]=$db->loadObjectRow($psql);
        //footer
        $params3=$this->do_footer();
        //saco secciones
        $params1["secciones"]=$this->do_menu1();
        $params1["subsecciones"]=$this->do_menu2();
        //listo articulos
        $params2["articulos"]=$db->loadObjectList($sql);
        //hallando ruta de los links
        $m=$params2["articulos"][0]->seccion;
        $s=$db->loadResult("select slug from wee_subsecciones where wee_subsecciones.estado=1 and marca='$m'");
        if($s){
            $rsubsec=$s;
            $rsec=$db->loadResult("select wee_secciones.slug from wee_secciones
                    inner join wee_subsecciones on wee_secciones.id=wee_subsecciones.idseccion
                    where wee_secciones.estado=1 and wee_subsecciones.slug like '$rsubsec'");
            $miruta=$rsec."/".$rsubsec."/";
        }else{
            $rsec=$db->loadResult("select slug from wee_secciones where wee_secciones.estado=1 and marca='$m'");
            $miruta=$rsec."/";
        }
        $params2["ruta"]=$miruta;
        //articulo defecto
        if(!$tripas[3])
            $params2["defecto"]=$params2["articulos"][0]->id;
        else
            $params2["defecto"]=$tripas[3];
        //obteniendo publicidad lateral
        $sql="select banners from wee_subsecciones where wee_subsecciones.estado=1 and wee_subsecciones.slug='".($tripas[2]?$tripas[2]:$tripas[1])."'";
        $idb=$db->loadResult($sql);
        $first="select * from wee_publicidad where date(now()) between wee_publicidad.fechaini and wee_publicidad.fechafin and wee_publicidad.estado=1 and id = ";
        $second=" union ";
        if(trim($idb)!=""){
            $sql=$first.str_replace(",",$second.$first,$idb);
        }else
            $sql="";
        $params2["banners"]=$db->loadObjectList($sql);
        loadHTML("header.php",$params1);
        loadHTML("articulo.php",$params2);
        loadHTML("footer.php",$params3);
    }
}
?>
