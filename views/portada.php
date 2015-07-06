<?php
$ls = $cfg["site"]["livesite"];
$sc = $params["scroll"];
//$ultder = $params["ultimas2"];
$ultizq = $params["ultimas1"];
if (count($params["destacados"]) > 0) {
?>
    <div id="lofslidecontent45" class="lof-slidecontent">
        <div class="preload"><div></div></div>
        <!-- MAIN CONTENT -->
        <div class="lof-main-outer">
            <ul class="lof-main-wapper">
            <?php
            if (count($params["destacados"]) > 0)
                foreach ($params["destacados"] as $r) {
            ?>
                    <li>
                        <img src="<?= $ls . "/tumber.php?w=600&height=363&src=" . ($r->imgart?$cfg["site"]["livesite"] . "/images/recursos/".$r->imgart:'') ?>" title="<?= $r->titulo . ' ' . $r->titulo2 ?>"/>
                        <div class="lof-main-item-desc">
                            <a target="_parent" title="<?= $r->titulo . " " . $r->titulo2 ?>" href="<?= pathById($r->id) ?>">
                                <h3><?= limitar_letras($r->titulo . ' ' . $r->titulo2, 45) ?></h3>
                                <p><?= limitar_letras(strip_tags($r->contenido), 70) ?></p></h3>
                            </a>
                        </div>
                    </li>
            <?php
                }
            ?>
        </ul>
    </div>
    <!-- END MAIN CONTENT -->
    <!-- NAVIGATOR -->
    <div class="lof-navigator-outer">
        <ul class="lof-navigator">
            <?php
            if (count($params["destacados"]) > 0)
                foreach ($params["destacados"] as $r) {
            ?>
                    <li>
                        <div>
                            <div class="imgminislider"><img src="<?= $ls . "/tumber.php?w=131&height=60&src=" . ($r->imgart?$cfg["site"]["livesite"] . "/images/recursos/".$r->imgart:'') ?>" /></div>
                            <table class="tbldes_slider" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td valign="bottom"><h3><span style="position:relative;top:-5px;"><?= limitar_letras($r->titulo . ' ' . $r->titulo2, 30) ?></span><br/><span style="font-weight: normal;"><?= limitar_letras(strip_tags($r->contenido), 50) ?></span></h3></td>
                                </tr>
                            </table>
                        </div>
                    </li>
            <?php
                }
            ?>
        </ul>
    </div>
</div>
<?php
        } else {
?>
            <div class="entrada" style="width: 100%"><div id="nohay" style="width: 100%">No hay destacados para mostrar.</div></div>
<?php
        }
?>
        <div id="modulescroll">
            <div id="tituloscroll">
                <div id="navscroll">
                    <div id="scrollleft"></div>
                    <div id="scrollright"></div>
                </div>
                <div id="pagerscroll"></div>
                PUBLICIDAD
            </div>
            <div id="visorscroll">
        <?php
        if (count($sc) > 0) {
            $sp = array_chunk($sc, 5);
            foreach ($sp as $p) {
        ?>
                <div class="gruposcroll">
            <?php
                if (count($p) > 0)
                    foreach ($p as $is) {
            ?>
                        <a class="itemscroll" rel="Publicidad" href="<?= $cfg["site"]["livesite"] ?>/images/recursos/<?= $is->recurso2 ?>" title="<?= $is->url ?>"><img src="<?= $cfg["site"]["livesite"] ?>/tumber.php?w=145&h=182&src=<?= $cfg["site"]["livesite"] ?>/images/recursos/<?= $is->recurso2 ?>"/></a>
            <?php
                    }
            ?>
            </div>
        <?php
            }
        }
        ?>
    </div>
</div>
<div id="ultimasnoticias">
    <?php
        $first = true;
        if (count($ultizq) > 0) {
            $i = 1;
            foreach ($ultizq as $u) {
                $ruta = pathById($u->id);
    ?>
                <div class="itemun"<?= ($i % 3 == 0 ? ' style="margin-right:0px"' : '') ?>>
                    <a title="<?= $u->titulo ?>" class="iun_imagen" href="<?= $ruta ?>"><img style="width:155px;" src="<?=$cfg["site"]["livesite"].'/tumber.php?w=155&src='.($u->imgart?$cfg["site"]["livesite"] . "/images/recursos/".$u->imgart:'')?>" /></a>
                    <a title="<?= $u->titulo ?>" href="<?= $ruta ?>" class="iun_titulo1"><table cellpadding="0" cellspacing="0" border="0"><tr><td valign="bottom"><?= $u->seccion ?></td></tr></table></a>
                    <a title="<?= $u->titulo ?>" href="<?= $ruta ?>" class="iun_col2">
                        <span class="iun_titulo2"><?= limitar_letras($u->titulo, 45) ?></span><br/>
                        <span class="iun_resumen"><?= limitar_letras(strip_tags($u->contenido), 170) ?></span>
                    </a>
                </div>
    <?php
                $i++;
            }
        }
        else
            echo '<div class="izqnohay">No hay registros para mostrar.</div>';
    ?>
</div>
