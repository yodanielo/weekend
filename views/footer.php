    </div>
</div>

<div id="footer">
    <div class="pagina">
        <div id="siguenos">
            <a id="correo" href="mailto:info@weekendpublicaciones.com">info@weekendpublicaciones.com</a>
            <strong>Síguenos en:</strong> <a href="http://www.facebook.com/pages/Semanal-Weekend/118820648189819" target="_blank"><img src="<?=$cfg["site"]["livesite"]?>/images/rs-facebook.png"/></a><img src="<?=$cfg["site"]["livesite"]?>/images/rs-tuenti.png"/>
      </div>
        <div id="foocol1">
            <?php
            $res=$params["secciones"];
            foreach($res as $r) {
                echo '<a href="'.$cfg["site"]["livesite"]."/".$r->slug.'">'.$r->titulo.'</a>';
            }
            ?>
        </div>
        <div id="foocol2">
            <?php
            $res=$params["subsecciones"];
            foreach($res as $r) {
                echo '<a href="'.$cfg["site"]["livesite"]."/".$r->sec_slug."/".$r->slug.'">'.$r->titulo.'</a>';
            }
            ?>
        </div>
        <div id="foocol3">
            <?php
            $res=$params["footer"];
            foreach($res as $r) {
                if($r->id==4)
                    echo '<a id="favoritos" href="'.$cfg["site"]["livesite"]."/footer/".$r->slug.'">'.$r->titulo.'</a>';
                else
                    echo '<a href="'.$cfg["site"]["livesite"]."/footer/".$r->slug.'">'.$r->titulo.'</a>';
            }
            ?>
        </div>
        <div id="foocol4">
            <img src="<?=$cfg["site"]["livesite"]?>/images/logo-weekend-footer.png" id="logofooter"/>
            c/Santa Engracia Nº 17-6º Madrid 28010<br/>
            Tel.: 0034 91 594 22 55<br/>
            Fax.: 0034 91 594 32 42<br/>
            <a id="mailtofooter" href="mailto:info@weekendpublicaciones.com">info@weekendpublicaciones.com</a><br/>
            <br/>
            <strong>&copy; <?=date("Y")?>, WEEKEND</strong>
        </div>
    </div>
</div>
</body>
</html>