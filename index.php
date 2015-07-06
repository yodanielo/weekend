<?php

ini_set('session.use_trans_sid', 0);
ini_set('session.use_cookies', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.gc_maxlifetime', 172800);
session_cache_limiter('private,must-revalidate');
session_start();
header("Cache-control: private");

//inclusiones
include("config.php");
include("includes/database.php");
include("includes/functions.php");
include("classes/seccion.php");
//cojo el path, pero antes recorro los menus
//si el menu es reconocido entonces se carga la pagina y si no, se busca el
//modulo correspondiente
$tripas = destripar();

//variables
$db = dbInstance();
$def_sec = slugByIdSection(1);
//analizo las tripas
//tripa 1 => seccion pero si es numero entonces e trata del numero de edicion
//tripa 2 => subseccion
//tripa 3 => articulo
$seccion = get($tripas[1], $def_sec);
if (strtolower(substr($seccion, 0, 5)) == "query") {
    $seccion = "buscar";
}
if (!$tripas[2]) {
    $sql = "select b.slug from #_secciones a inner join #_subsecciones b on a.id=b.idseccion where a.slug like '$seccion'";
    $subseccion = $db->loadResult($sql);
}else
    $subseccion=$tripas[2];
//aqui solo debo saber si se carga un modulo o se carga una plantilla
if (!$subseccion)
    $sql = "select esmodulo from #_secciones where slug='$seccion'";
else
    $sql="select b.esmodulo from #_secciones a inner join #_subsecciones b on a.id=b.idseccion where a.slug='$seccion' and b.slug='$subseccion'";
$esmodulo = $db->loadResult($sql);
if ($esmodulo == 1) {
    //es un modulo
    $clase = strtolower(str_replace("-", "_", $seccion));
    if (!$subseccion)
        $metodo = "index";
    else
        $metodo=$subseccion;
    include dirname(__FILE__) . '/classes/' . $clase . ".php";
    $obj = new $clase();
    $params = array();
    //a partir de la tripa 3 son parametros
    for ($i = 3; $i < count($tripas); $i++) {
        array_push($params, $tripas[$i]);
    }
    call_user_func_array(array($obj, strtolower(str_replace("-", "_", $metodo))), $params);
} elseif ($esmodulo == 0 && $esmodulo != "") {
    //es un articulo
    $clase = "articulo";
    $metodo = "index";
    include_once 'classes/' . $clase . ".php";
    $obj = new $clase();
    $params = array();
    //a partir de la tripa 3 son parametros
    //la tripa 1 y 2 indican la ruta
    for ($i = 1; $i < count($tripas); $i++) {
        array_push($params, $tripas[$i]);
    }
    call_user_func_array(array($obj, strtolower(str_replace("-", "_", $metodo))), $params);
} elseif (file_exists(dirname(__FILE__) . "/classes/" . $seccion . ".php")) {
    //verificamos que no sea un modulo suelto
    include_once("classes/" . $seccion . ".php");
    $obj = new $seccion();
    if (!$tripas[2])
        $metodo = "index";
    else
        $metodo=$tripas[2];
    $params = array();
    //a partir de la tripa 3 son parametros
    for ($i = 3; $i < count($tripas); $i++) {
        array_push($params, $tripas[$i]);
    }
    call_user_func_array(array($obj, strtolower(str_replace("-", "_", $metodo))), $params);
} else {
    loadHTML("header.php");
    loadHTML("404.php");
    loadHTML("footer");
}
//echo dirname(__FILE__)."/classes/".$seccion.".php";
?>
