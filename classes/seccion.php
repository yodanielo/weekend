<?php
class seccion {
    function do_menu1() {
        global $cfg;
        $tripas=destripar();
        if(!$tripas[1])
            $tripas[1]="la-revista";
        $db=dbInstance();
        $sql="select * from wee_secciones";
        $res=$db->loadObjectList($sql);
        $cad='';
        foreach($res as $r) {
            if($r->id==5)
                $cad.='<a href="'.$cfg["site"]["livesite"].'/'.$r->slug.'" class="'.(strtolower($r->slug)==strtolower($tripas[1])?'sec_selected':'').'" >'.$r->titulo.'</a>';
            else
                $cad.='<a href="'.$cfg["site"]["livesite"].'/'.$r->slug.'" class="'.(strtolower($r->slug)==strtolower($tripas[1])?'sec_selected':'').'" >'.$r->titulo.'</a>';
        }
        return $cad;
    }
    function do_menu2() {
        global $cfg;
        $db=dbInstance();
        $tripas=destripar();
        if(!$tripas[1])
            $tripas[1]="la-revista";
        if(!$tripas[2])
            $tripas[2]=$db->loadResult("select b.slug from #_secciones a inner join #_subsecciones b on a.id=b.idseccion where a.slug like '".$tripas[1]."'");
        $sql="select b.titulo,b.slug from #_secciones a inner join #_subsecciones b on a.id=b.idseccion where a.slug like '".$tripas[1]."'";
        $res=$db->loadObjectList($sql);
        $cad='';
        if(count($res)>0)
            foreach($res as $r) {
                $cad.='<a href="'.$cfg["site"]["livesite"].'/'.$tripas[1].'/'.$r->slug.'" class="'.(strtolower($r->slug)==strtolower($tripas[2])?'sec_selected':'').'" >'.$r->titulo.'</a>';
            }
        $cad=str_replace("</a><a ",'</a><strong><img src="'.$cfg["site"]["livesite"]."/images/vineta0.png".'" style="width:5px;height:5px;"/></strong><a ',$cad);
        return $cad;
    }
    function do_footer(){
        global $cfg;
        $db=dbInstance();
        $sql="select * from #_secciones where estado=1";
        $secciones=$db->loadObjectList($sql);
        $sql="select b.*,a.slug as sec_slug from wee_subsecciones b inner join wee_secciones a on a.id=b.idseccion where b.estado=1";
        $subsecciones=$db->loadObjectList($sql);
        $sql="select * from #_footer where estado=1";
        $footer=$db->loadObjectList($sql);
        return array("secciones"=>$secciones,"subsecciones"=>$subsecciones,"footer"=>$footer);
    }
    function do_pubtop($tabla,$id){
        global $cfg;
        $db=dbInstance();
        $sql="select wee_publicidad.* from wee_$tabla
                    inner join wee_publicidad on wee_$tabla.pubtop=wee_publicidad.id
                    where date(now()) between wee_publicidad.fechaini and wee_publicidad.fechafin and wee_$tabla.id=$id";
        $res=$db->loadObjectList($sql);
        return $res[0];
    }
}
?>
