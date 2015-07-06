<?php
$tripas = destripar();
$arts = $params["articulos"];
?>
<div id="weecol1">
    <div class="title">
        <span id="breadcrumb"><?= breadcrumb() ?></span>
    </div>
    <div class="entrada">
        <div class="subtitle">Números Anteriores</div>
        <!--<div class="subtitle"></div>-->
        <?php
        if (count($arts)) {
            $cad = '';
            $i = 1;
            foreach ($arts as $a) {
                if ($i % 3 == 0)
                    $cad.='<div class="minied" style="margin-right:0px;">';
                else
                    $cad.='<div class="minied">';
                if ($a->flashlibro != "")
                    $cad.='    <a class="miniflash" target="_blank" href="' . $cfg["site"]["livesite"] . '/edicion_digital/detalleflash/' . $a->id . '"><img class="minipreview" src="' . $cfg["site"]["livesite"] . '/images/recursos/' . $a->edmini . '"/></a>';
                else
                    $cad.='    <div class="miniflash"><img class="minipreview" src="' . $cfg["site"]["livesite"] . '/images/recursos/' . $a->edmini . '"/></div>';
                $cad.='    <a href="' . $cfg["site"]["livesite"] . '/images/recursos/' . $a->contenido . '" target="_blank" class="minitext">' . $a->titulo . ': <span>Descargar <img class="miniicopdf" src="' . $cfg["site"]["livesite"] . '/images/ico-pdf.png" /></span></a>';
                $cad.='</div>';
                $i++;
            }
            echo $cad;
        } else {
            echo '<div class="entrada"><div id="nohay">No hay contenido para mostrar.</div></div>';
        }
        ?>
    </div>
</div>
<div id="weecol2">
    <?php
        if (count($params["banners"]) > 0 && $params["banners"][0]->recurso2) {
            echo '<div class="title" id="titpublicidad">PUBLICIDAD</div>';
            foreach ($params["banners"] as $b) {
                if ($b->recurso2) {
    ?>
                    <a class="item_banner" title="<?= $b->url ?>" rel="publicidad left" href="<?= $cfg["site"]["livesite"] . "/images/recursos/" . ($b->recurso3 ? $b->recurso3 : $b->recurso2) ?>">
                        <img style="width:240px;" src="<?= $cfg["site"]["livesite"] . "/images/recursos/" . ($b->recurso3 ? $b->recurso3 : $b->recurso2) ?>"/>
                    </a>
    <?php
                }
            }
        }
    ?>
</div>
