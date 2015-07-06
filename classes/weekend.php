<?php
class weekend extends seccion{
    function index(){
        $db=dbInstance();
        //publiidad top
        $psql="select * from wee_publicidad inner join wee_estaticos
                    on wee_publicidad.id=wee_estaticos.pubtop where date(now()) between wee_publicidad.fechaini and wee_publicidad.fechafin and wee_publicidad.estado=1 and wee_estaticos.id = 1";
        $params1["publicidad"]=$db->loadObjectRow($psql);
        //articulo
        $sql="select * from wee_estaticos where estado=1 and id=1";
        $params2["articulo"]=$db->loadObjectRow($sql);
        //footer
        $params3=$this->do_footer();
        //obteniendo publicidad slider
        $sql="select banners from wee_estaticos where wee_estaticos.estado=1 and id=1";
        $idb=$db->loadResult($sql);
        $first="select * from wee_publicidad where date(now()) between wee_publicidad.fechaini and wee_publicidad.fechafin and wee_publicidad.estado=1 and id = ";
        $second=" union ";
        if(trim($idb)!=""){
            $sql=$first.str_replace(",",$second.$first,$idb);
        }else
            $sql="";
        $params2["banners"]=$db->loadObjectList($sql);
        //saco secciones
        $params1["secciones"]=$this->do_menu1();
        $params1["subsecciones"]=$this->do_menu2();

        loadHTML("header.php",$params1);
        loadHTML("estaticos.php",$params2);
        loadHTML("footer.php",$params3);
    }
}
?>