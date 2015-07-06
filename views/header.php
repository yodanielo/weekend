<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=<?=$cfg["site"]["charset"]?>" />
        <title><?php echo $cfg["site"]["sitename"]; ?></title>
        <meta name="Description" content="<?php echo $cfg["site"]["sitedescription"]; ?>" />
        <meta name="Keywords" content="<?php echo $cfg["site"]["keywords"]; ?>" />
        <meta name="author" content="<?php echo $cfg["site"]["author"]; ?>" />
        <meta name="owner" content="<?php echo $cfg["site"]["owner"]; ?>" />
        <meta name="robots" content="index, follow" />
        <meta HTTP-EQUIV="Expires" CONTENT="Tue, 01 Jan 1980 1:00:00 GMT"/>
        <meta HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE"/>
        <meta HTTP-EQUIV="Cache-Control" CONTENT="no-cache"/>
        <?php
        if(count($params["css"])>0) {
            foreach($params["css"] as $key=>$sc) {
                if(substr($sc,0,7)=="http://")
                    echo '<link rel="stylesheet" type="text/css" href="'.$sc.'" />'."\n";
                else
                    echo '<link rel="stylesheet" type="text/css" href="'.$cfg["site"]["livesite"].'/css/'.$sc.'" />'."\n";
            }
        }
        ?>
        <style type="text/css">
            @font-face {
                font-family: 'MyriadProRegular';
                src: url('<?=$cfg["site"]["livesite"]?>/fuente/myriadpro-regular-webfont.eot');
                src: local('☺'), url('<?=$cfg["site"]["livesite"]?>/fuente/myriadpro-regular-webfont.woff') format('woff'), url('<?=$cfg["site"]["livesite"]?>/fuente/myriadpro-regular-webfont.ttf') format('truetype'), url('<?=$cfg["site"]["livesite"]?>/fuente/myriadpro-regular-webfont.svg#webfont2cDQOnRc') format('svg');
                font-weight:bold;
            }
        </style>
        <link rel="stylesheet" type="text/css" href="<?=$cfg["site"]["livesite"]?>/images/fancybox/jquery.fancybox-1.3.1.css" />
        <link rel="stylesheet" type="text/css" href="<?=$cfg["site"]["livesite"]?>/css/nav.css" />
        <!--[if IE ]>
	<link rel="stylesheet" type="text/css" href="<?=$cfg["site"]["livesite"]?>/css/ie.css" />
        <![endif]-->
        <!--[if lte IE 7]>
	<link rel="stylesheet" type="text/css" href="<?=$cfg["site"]["livesite"]?>/css/ie7.css" />
        <![endif]-->
        <script type="text/javascript" src="<?=$cfg["site"]["livesite"]?>/js/jquery-1.4.4.min.js"></script>
        <script type="text/javascript" src="<?=$cfg["site"]["livesite"]?>/images/fancybox/jquery.fancybox-1.3.1.js"></script>
        <?php
        if(count($params["scripts"])>0) {
            foreach($params["scripts"] as $key=>$sc) {
                if(substr($sc,0,7)=="http://")
                    echo '<script type="text/javascript" src="'.$sc.'"></script>'."\n";
                else
                    echo '<script type="text/javascript" src="'.$cfg["site"]["livesite"].'/js/'.$sc.'"></script>'."\n";
            }
        }
        ?>
        <script type="text/javascript" src="<?=$cfg["site"]["livesite"]?>/js/generales.js"></script>
    </head>
    <body>
        <?php
        $pt=$params["publicidad"];
        ?>
        <div id="pubcontenedortop">
            <?php if($pt->recurso){ ?>
            <div id="puntop">
                <div id="btnpublicidad"></div>
                <a class="banbtn" href="<?=$cfg["site"]["livesite"]?>/images/recursos/<?=$pt->recurso2?>"><div id="topdescripcion"><?=$pt->titulo."<br/>".$pt->descripcion?></div><img src="<?=$cfg["site"]["livesite"]?>/images/recursos/<?=$pt->recurso?>"/></a>
            </div>
            <?php }else{ ?>
            <div id="espaciotop">
                <div id="btnpublicidad"></div>
                <div id="txtespaciolibre">Espacio Publicitario Disponible
                </div>
            </div>
            <?php } ?>
        </div>
        <div style="display:none">
            <img src="<?=$cfg["site"]["livesite"]?>/images/recursos/<?=$pt->recurso?>"/>
        </div>
        <div id="bodycontenedor">
            <img src="<?=$cfg["site"]["livesite"]?>/images/san-valentin-2011.png" id="san-valentin"/>
            <div class="pagina">
                <div id="desptop">
                    <div id="despimg"></div>
                    <div id="desbbar"><div id="cerrarpubtxt"><img src="<?=$cfg["site"]["livesite"]?>/images/ico-zoom-.png"/>  cerrar publicidad</div><label><?=$pt->titulo."&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;".$pt->descripcion.'&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a target="_blank" href="'.$pt->url.'">'.$pt->url.'</a>'?></label></div>
                </div>
                <div id="barratitulo">
                    <a id="logo" href="<?=$cfg["site"]["livesite"]?>"><img src="<?=$cfg["site"]["livesite"]?>/images/logo_weekend.png"/></a>
                    <div id="clima">
                        <div id="climacont">
                        <div id="c_86f010f7b254c31da6624a931da6329d" class="ancho"><h2 style="color: #000000; margin: 0 0 3px; padding: 2px; font: bold 13px/1.2 Verdana; text-align: center;"><a href="http://www.eltiempo.es/madrid.html" style="color: #000000; text-decoration: none;">meteo Madrid</a></h2></div><script type="text/javascript" src="http://www.eltiempo.es/widget/widget_loader/86f010f7b254c31da6624a931da6329d"></script>
                        </div>
                    </div>
                    <div id="fecha"><?=hacer_fecha()?></div>
                </div>
                <div id="barrasecciones1">
                    <div id="buscador">
                        <form id="frmbus" name="frmbus" action="<?=$cfg["site"]["livesite"]?>/buscar">
                            <input type="submit" id="submitquery" value="" />
                            <input type="text" name="query" id="query" value="<?=str_replace('"',"",$_GET["query"])?>" />
                        </form>
                    </div>
                    <?=$params["secciones"]?>
                </div>
                <div id="barrasecciones2">
                    <?=$params["subsecciones"]?>
                </div>
