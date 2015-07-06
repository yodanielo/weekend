<?php
$arts=$params["articulos"];
$tripas=destripar();
?>
<div id="weecol1">
    <div class="title">
        <span id="breadcrumb">
            <?php
            if(count($arts)>0)
                echo '<a href="'.$cfg["site"]["livesite"].'">Se encontraron las siguentes coincidencias para&nbsp;</a>';
            else
                echo '<a href="'.$cfg["site"]["livesite"].'">No se encontraron las siguentes coincidencias para&nbsp;</a>';

            ?>
            
            <a href="<?=$cfg["site"]["livesite"]."/buscar/?query=".$_GET["query"]?>"><?=htmlspecialchars(str_replace("'","",$_GET["query"]))?></a>
        </span>
    </div>
    <div id="notlistado1">
        <?php
        if(count($arts)>0)
            foreach($arts as $a) {
                if($a->id==$params["defecto"]) {
                    echo '<a class="active" href="'.$cfg["site"]["livesite"]."/".$params["ruta"].$a->id.'">&nbsp;<span class="middot"></span> '.$a->titulo." ".$a->titulo2.'</a>';
                    $cuerpo=$a;
                }
                else
                    echo '<a href="'.$cfg["site"]["livesite"]."/".$params["ruta"].$a->id.'">&nbsp;<span class="middot"></span> '.$a->titulo." ".$a->titulo2.'</a>';
            }
        ?>
        <a id="separadorlistado"><img src="<?=$cfg["site"]["livesite"]?>/images/separador-listado-desplegado.jpg"/></a>
    </div>
    <?php if($params["defecto"]) { ?>
    <div class="entrada">
        <div class="mytitle"><?=$cuerpo->titulo?></div>
        <div class="subtitle"><?=$cuerpo->titulo2?></div>
        <div class="cuerpoentrada">
                <?=$cuerpo->contenido?>
        </div>
    </div>
        <?php }else {
        //echo '<div class="entrada"><div id="nohay">No hay registros para mostrar.</div></div>';
    }?>
    
    <div id="notlistado2">
        <?php
        if(count($arts)>0)
            foreach($arts as $a) {
                if($a->id==$params["defecto"]) {
                    echo '<a class="active" href="'.$cfg["site"]["livesite"]."/".$params["ruta"].$a->id.'">&nbsp;<span class="middot"></span> '.$a->titulo." ".$a->titulo2.'</a>';
                    $cuerpo=$a;
                }
                else
                    echo '<a href="'.$cfg["site"]["livesite"]."/".$params["ruta"].$a->id.'">&nbsp;<span class="middot"></span> '.$a->titulo." ".$a->titulo2.'</a>';
            }
        ?>
    </div>
</div>
<div id="weecol2">
    <?php
    if(count($params["banners"])>0) {
        echo '<div class="title" id="titpublicidad">PUBLICDAD</div>';
        foreach($params["banners"] as $b) {
            ?>
    <div class="item_banner">
        <img src="<?=$cfg["site"]["livesite"]."/images/recursos/".($b->recurso3?$b->recurso3:$b->recurso2) ?>"/>
    </div>
            <?php
        }
    }
    ?>
</div>