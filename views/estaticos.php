<?php
$tripas=destripar();
$cuerpo=$params["articulo"];
?>
<div id="weecol1">
    <div class="title">
        <div id="togglearticulos"></div>
        <span id="breadcrumb"><?=breadcrumb()?></span>
    </div>
    <script type="text/javascript">
        a=$(".sec_selected:first").text();
        if(a=="La Revista")
            $("#togglearticulos").show();
        else
            $("#togglearticulos").hide();
    </script>
    <?php if($cuerpo){ ?>
    <div class="entrada">
        <div class="mytitle"><?=$cuerpo->titulo2?></div>
        <div class="subtitle"><?=$cuerpo->titulo?></div>
        <div class="cuerpoentrada">
            <?=$cuerpo->contenido?>
        </div>
    </div>
    <?php }else{
        echo '<div class="entrada"><div id="nohay">No hay contenido para mostrar.</div></div>';
    }?>
    <script type="text/javascript">
        a=$(".sec_selected:first").text();
        if(a=="La Revista"){
            $(".articulotitlefooter").show();
        }
        else{
            $(".articulotitlefooter").hide();
        }
    </script>
</div>
<div id="weecol2">
    <?php
    if(count($params["banners"])>0 && $params["banners"][0]->recurso2) {
        echo '<div class="title" id="titpublicidad">PUBLICIDAD</div>';
        foreach($params["banners"] as $b) {
            if($b->recurso2){
            ?>
    <a class="item_banner" title="<?=$b->url?>" rel="publicidad left" href="<?=$cfg["site"]["livesite"]."/images/recursos/".($b->recurso3?$b->recurso3:$b->recurso2) ?>">
        <img src="<?=$cfg["site"]["livesite"]."/images/recursos/".($b->recurso3?$b->recurso3:$b->recurso2) ?>"/>
    </a>
            <?php
            }
        }
    }
    ?>
</div>