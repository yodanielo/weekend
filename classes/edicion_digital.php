<?php

class edicion_digital extends seccion {

    function index() {
        global $cfg;
        //saco primero la publicidad top
        $db = dbInstance();
        $params1["publicidad"] = $this->do_pubtop("portada", 1);
        //articulos
        $sql = "select * from #_ediciondigital_articulos where estado=1";
        $params2["articulos"] = $db->loadObjectList($sql);
        //footer
        $params3 = $this->do_footer();
        //obteniendo publicidad por defecto
        $sql = "select banners from wee_ediciondigital where id=1";
        $idb = $db->loadResult($sql);
        $first = "select * from wee_publicidad where date(now()) between wee_publicidad.fechaini and wee_publicidad.fechafin and wee_publicidad.estado=1 and id = ";
        $second = " union ";
        if (trim($idb) != "") {
            $sql = $first . str_replace(",", $second . $first, $idb);
        }else
            $sql="";
        $params2["banners"] = $db->loadObjectList($sql);
        //saco secciones
        $params1["secciones"] = $this->do_menu1();
        $params1["subsecciones"] = $this->do_menu2();
        loadHTML("header.php", $params1);
        loadHTML("ediciondigital.php", $params2);
        loadHTML("footer.php", $params3);
    }

    function detalleflash($id) {
        global $cfg;
        //saco primero la publicidad top
        $db = dbInstance();
        $params1["publicidad"] = $this->do_pubtop("portada", 1);
        //sacarslim
        $sql = "select * from #_ediciondigital_articulos where id=" . intval($id);
        $params2["ed"] = $db->loadObjectRow($sql);
        //obteniendo publicidad por defecto
        $sql = "select banners from wee_ediciondigital where id=1";
        $idb = $db->loadResult($sql);
        $first = "select * from wee_publicidad where date(now()) between wee_publicidad.fechaini and wee_publicidad.fechafin and wee_publicidad.estado=1 and id = ";
        $second = " union ";
        if (trim($idb) != "") {
            $sql = $first . str_replace(",", $second . $first, $idb);
        }else
            $sql="";
        //footer
        $params3 = $this->do_footer();
        $params2["banners"] = $db->loadObjectList($sql);
        $params1["secciones"] = $this->do_menu1();
        $params1["subsecciones"] = $this->do_menu2();
        $params1["scripts"][]="swfobject.js";
        loadHTML("ediciondetalle.php", $params2);
    }

}

?>
