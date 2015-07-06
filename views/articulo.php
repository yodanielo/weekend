<?php
$arts = $params["articulos"];
$tripas = destripar();
?>
<script type="text/javascript">
    $(document).ready(function(){
        $("#breadcrumb a:last").click(function(){
             $("#notlistado1").slideDown();
            return false;
        });
    });
</script>
<div id="weecol1">
    <div class="title">
        <div id="togglearticulos">
            <img src="<?=$cfg["site"]["livesite"]."/images/icoi11.png"?>" id="icoi"/>
            <span></span>
        </div>
        <span id="breadcrumb"><?= breadcrumb() ?></span>
    </div>
    <script type="text/javascript">
        a=$(".sec_selected:first").text();
        if(a=="La Revista")
            $("#togglearticulos").show();
        else
            $("#togglearticulos").hide();
    </script>
    <div id="notlistado1">
        <?php
        if (count($arts) > 0)
            foreach ($arts as $a) {
                if ($a->id == $params["defecto"]) {
                    echo '<a class="active" href="' . $cfg["site"]["livesite"] . "/" . $params["ruta"] . $a->id . '">&nbsp;<span class="middot"></span> ' . $a->titulo . " " . $a->titulo2 . '</a>';
                    $cuerpo = $a;
                }
                else
                    echo '<a href="' . $cfg["site"]["livesite"] . "/" . $params["ruta"] . $a->id . '">&nbsp;<span class="middot"></span> ' . $a->titulo . " " . $a->titulo2 . '</a>';
            }
        ?>
        <a id="separadorlistado"><img src="<?= $cfg["site"]["livesite"] ?>/images/separador-listado-desplegado.jpg"/></a>
    </div>
    <?php if ($cuerpo) {
    ?>
            <div class="entrada">
                <div class="mytitle"><?= $cuerpo->titulo ?></div>
                <div class="subtitle"><?= $cuerpo->titulo2 ?></div>
                <div class="cuerpoentrada">
                    <?=($cuerpo->imgart?'<p><img id="imgart" style="width:700px" src="'. $cfg["site"]["livesite"] . "/images/recursos/".$cuerpo->imgart.'"/></p>':'')?>
            <?= $cuerpo->contenido ?>
        </div>
    </div>
    <?php
        } else {
            echo '<div class="entrada"><div id="nohay">No hay registros para mostrar.</div></div>';
        }
    ?>
        <div class="title articulotitlefooter">
            <span id="masactualidad"></span>
        </div>
        <div id="notlistado2" class="articulotitlefooter">
        <?php
        if (count($arts) > 0)
            foreach ($arts as $a) {
                if ($a->id == $params["defecto"]) {
                    echo '<a class="active" href="' . $cfg["site"]["livesite"] . "/" . $params["ruta"] . $a->id . '">&nbsp;<span class="middot"></span> ' . $a->titulo . " " . $a->titulo2 . '</a>';
                    $cuerpo = $a;
                }
                else
                    echo '<a href="' . $cfg["site"]["livesite"] . "/" . $params["ruta"] . $a->id . '">&nbsp;<span class="middot"></span> ' . $a->titulo . " " . $a->titulo2 . '</a>';
            }
        ?>
    </div>
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
        if (count($params["banners"]) > 0) {
            echo '<div class="title" id="titpublicidad">PUBLICIDAD</div>';
            foreach ($params["banners"] as $b) {
    ?>
                <a class="item_banner" title="<?= $b->url ?>" rel="publicidad left" href="<?= $cfg["site"]["livesite"] . "/images/recursos/" . ($b->recurso3?$b->recurso3:$b->recurso2) ?>">
                    <img src="<?= $cfg["site"]["livesite"]."/tumber.php?w=240&src=".$cfg["site"]["livesite"] . "/images/recursos/" . ($b->recurso3?$b->recurso3:$b->recurso2) ?>"/>
                </a>
    <?php
            }
        }
    ?>
</div>