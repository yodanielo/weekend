<?php
class la_revista extends seccion {
    function portada() {
        $db=dbInstance();
        //saco primero la publicidad top
        $db=dbInstance();
        $params2["publicidad"]=$this->do_pubtop("portada",1);
        //saco destacados
        $res=$db->loadObjectList("select wee_noticias.* from wee_noticias
inner join wee_subsecciones on wee_noticias.seccion=wee_subsecciones.marca
where wee_noticias.estado=1 and wee_noticias.destacado=1
order by wee_subsecciones.titulo");
        $params["destacados"]=$res;
        //saco secciones
        $params2["secciones"]=$this->do_menu1();
        $params2["subsecciones"]=$this->do_menu2();
        //articulos destacados
        $sql="select * from #_portada where id=1";
        $des=$db->loadObjectRow($sql);
        $sql="
            select * from wee_noticias where wee_noticias.estado=1 and id = ".$des->destacado1_col1." union
            select * from wee_noticias where wee_noticias.estado=1 and id = ".$des->destacado2_col1." union
            select * from wee_noticias where wee_noticias.estado=1 and id = ".$des->destacado3_col1."
        ";
        $params["dtd1"]=$db->loadObjectList($sql);
        $params["dtd2"]=$db->loadObjectRow("select * from wee_noticias where id=$des->destacado_col2");
        $params2["css"]=array(
                "slideshow.css"
        );
        $params2["scripts"]=array(
                "jquery.easing.js",
                "slideshow.js",
                "jquery.cycle.all.2.74.js",
        );
        //publicidad scroll
        $sql="select minibanners from wee_portada where id=1";
        $mbi=$db->loadResult($sql);
        $first= "select * from wee_publicidad where date(now()) between wee_publicidad.fechaini and wee_publicidad.fechafin and estado=1 and id=";
        $second=" union ";
        $sql=$first.str_replace(",",$second.$first,$mbi);
        $params["scroll"]=$db->loadObjectList($sql);
        //ultimas noticias
        $sql="select a.*,b.titulo as seccion  from wee_noticias a
                inner join wee_subsecciones b on a.seccion=b.marca
                where a.estado=1 and a.portada_chica=1 order by b.id limit 6";
        $params["ultimas1"]=$db->loadObjectList($sql);
        /*$sql="select a.*  from wee_noticias a
                inner join wee_subsecciones b on a.seccion=b.marca
                where a.estado=1 and portada_grande=1";
        $params["ultimas2"]=$db->loadObjectRow($sql);*/
        loadHTML("header.php",$params2);
        loadHTML("portada.php",$params);
        loadHTML("footer.php",$this->do_footer());
    }

}
?>
