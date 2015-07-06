<?php
$meses_en=array("January","February","March","April","May","June","July","August","September","October","November","December");
$meses_es=array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Setiembre","Octubre","Noviembre","Diciembre");
$semana_en=array("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");
$semana_es=array("Lunes","Martes","Miércoles","Jueves","Viernes","Sábado","Domingo");
function dbInstance() {
    global $cfg;
    $x=new database($cfg["database"]["server"], $cfg["database"]["user"], $cfg["database"]["password"], $cfg["database"]["database"], $cfg["database"]["prefix"]);
    return $x;
}
function toURL($a) {
    $a=preg_replace('/([\/|\?| ]+)/','-',$a);
    $a=str_replace(array("á","é","í","ó","ú","ñ"),array("a","e","i","o","u","n"),$a);
    return $a;
}
function loadHTML($view,$params=null) {
    global $cfg;
    if(file_exists($cfg["site"]["absolutePath"]."/views/".$view)) {
        require($cfg["site"]["absolutePath"]."/views/".$view);
    }else {
        die("Call to indefined view ".$view);
    }
}
function slugByIdSection($id,$table="secciones",&$esmodulo=false) {
    $db= dbInstance();
    $sql="select slug,esmodulo from #_$table where estado=1 and id=".intval($id);
    $res=$db->loadObjectList($sql);
    $esmodulo=$res[0]->esmodulo;
    return $res[0]->slug;
}
function titleBySlug($slug,$table="secciones",&$esmodulo=false) {
    $db= dbInstance();
    $slug=str_replace("'","",$slug);
    $table=str_replace("'","",$table);
    $sql="select titulo,esmodulo from #_$table where estado=1 and slug like '".$slug."'";
    $res=$db->loadObjectList($sql);
    $esmodulo=$res[0]->esmodulo;
    return $res[0]->titulo;
}
function get($var,$def=null) {
    if($var==null)
        return $def;
    else
        return $var;
}
/**
 * divide la cadena en parte digeribles por el sistema
 */
function destripar() {
    $path='';
    // Is there a PATH_INFO variable?
    $path = (isset($_SERVER['PATH_INFO'])) ? $_SERVER['PATH_INFO'] : @getenv('PATH_INFO');
    if($path=="") {
        // No PATH_INFO?... What about QUERY_STRING?
        $path =  (isset($_SERVER['QUERY_STRING'])) ? $_SERVER['QUERY_STRING'] : @getenv('QUERY_STRING');
        if($path=="") {
            // No QUERY_STRING?... Maybe the ORIG_PATH_INFO variable exists?
            $path = str_replace($_SERVER['SCRIPT_NAME'], '', (isset($_SERVER['ORIG_PATH_INFO'])) ? $_SERVER['ORIG_PATH_INFO'] : @getenv('ORIG_PATH_INFO'));
            if($path=="") {
                // There is not tripas
                $path = '';
            }
        }
    }
    if(substr($path, 0,1)!="/")
        $path="/".$path;
    $trip=explode("/", $path);
    if($trip[1]=="")
        return null;
    else
        return $trip;
}
function hacer_fecha() {
    global $meses_en,$meses_es,$semana_en,$semana_es;
    $x=date("l, d \d\e F \d\e Y | ");
    $y=date("G:i\h");
    $x=str_replace($meses_en,$meses_es,$x);
    $x=str_replace($semana_en,$semana_es,$x);
    echo $x."<span>$y</span>";
}
function limitar_letras($str, $n = 500, $end_char = '&#8230;') {
    if (strlen($str) < $n) {
        return $str;
    }

    $str = preg_replace("/\s+/", ' ', str_replace(array("\r\n", "\r", "\n"), ' ', $str));

    if (strlen($str) <= $n) {
        return $str;
    }

    $out = "";
    foreach (explode(' ', trim($str)) as $val) {
        $out .= $val.' ';

        if (strlen($out) >= $n) {
            $out = trim($out);
            return (strlen($out) == strlen($str)) ? $out : $out.$end_char;
        }
    }
}
function eimage($c) {
    $d=str_replace("\n"," ",$c);
    $output = preg_match_all('/<img.+?src=[\'"]([^\'"]+)[\'"].*>/i', $d, $matches);
    $first_img = $matches[1][0];
    return $first_img;
}
function breadcrumb() {
    global $cfg;
    $tripas=destripar();
    $cad='';
    $url=$cfg["site"]["livesite"];
    $db=dbInstance();
    if($tripas[1]) {
        $titulo=titleBySlug($tripas[1], "secciones");
        $cad.='<a href="'.$url.'/'.$tripas[1].'">'.$titulo.'</a>';
    }
    if($tripas[2]) {
        $titulo=titleBySlug($tripas[2], "subsecciones");
        $cad.='<label>&nbsp;&gt;&nbsp;</label><a href="'.$url.'/'.$tripas[1].'/'.$tripas[2].'">'.$titulo.'</a>';
    }
    /*if($tripas[3]){
        $tripas[3]=$db->loadResult("select title from #_noticias where id=".intval($tripas[3]));

    }*/
    return $cad;
}
function breadcrumb_footer() {
    global $cfg;
    $tripas = destripar();
    $cad = '';
    $url = $cfg["site"]["livesite"];
    $db = dbInstance();
    $titulo = $db->loadResult("select titulo from wee_estaticos where slug like '" . $tripas[2] . "'");
    $cad.='<a href="' . $url . '/' . $tripas[1] . '">' . $titulo . '</a>';
    return $cad;
}
function pathById($id) {
    global $cfg;
    if($id!="") {
        $sql="select 'seccion' as sec,slug from wee_secciones inner join wee_noticias on wee_secciones.marca   =wee_noticias.seccion where wee_secciones.estado=1 and wee_noticias.id=$id  union
          select 'subseccion' ,slug from wee_subsecciones inner join wee_noticias on wee_subsecciones.marca=wee_noticias.seccion where wee_subsecciones.estado=1 and wee_noticias.id=$id ";
        $db=dbInstance();
        $m1=$db->loadObjectRow($sql);
        if($m1->sec=='seccion') {
            $ruta=$cfg["site"]["livesite"]."/".$m1->slug."/".$id;
        }else {
            $sql="select wee_secciones.slug from wee_secciones inner join wee_subsecciones on wee_secciones.id=wee_subsecciones.idseccion where wee_secciones.estado=1 and wee_subsecciones.slug like '".$m1->slug."'";
            $m2=$db->loadResult($sql);
            $ruta=$cfg["site"]["livesite"]."/".$m2."/".$m1->slug."/".$id;
        }
        return $ruta;
    }
    else {
        return "";
    }
}
?>
