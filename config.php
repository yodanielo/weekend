<?php
/**
 * database settings
 */
$cfg["database"]["user"]="db78004_0prg9";
$cfg["database"]["password"]="0dDsrrll9";
$cfg["database"]["database"]="db78004_dbddesarrollo";
$cfg["database"]["server"]="internal-db.s78004.gridserver.com";
$cfg["database"]["prefix"]="wee_";
/**
 * site settings
 */
$cfg["site"]["indexfile"]=basename($_SERVER["PHP_SELF"]);
$cfg["site"]["useFriendlyUrl"]=true;
$cfg["site"]["livesite"]="http://".$_SERVER["HTTP_HOST"].dirname($_SERVER["SCRIPT_NAME"]);
$cfg["site"]["absolutePath"]=dirname(__FILE__);
$cfg["site"]["charset"]="utf-8";
$cfg["site"]["permitted_uri_chars"]="a-z 0-9~%.:_\-";
$cfg["site"]["sitename"]="Weekend";
$cfg["site"]["sitedescription"]="";
$cfg["site"]["keywords"]="weekend";
$cfg["site"]["author"]="";
$cfg["site"]["owner"]="";
?>
