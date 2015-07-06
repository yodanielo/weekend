<?php
class MantixMenu {
    var $opciones;

    function __construct() {

    }
    function get_padres() {

        $long=count($this->opciones);
        $base=basename($_SERVER['PHP_SELF']);
        if($base=="otrosproductos.php") {
            $base="productos.php";
        }
        
        for ($a=0;$a<$long;$a++) {
            if($base==$this->opciones[$a]["url"]) {
                return array($this->opciones[$a]["url"]);
            }
            else {
                if(isset($this->opciones[$a]["sub"])) {
                    $m=$this->opciones[$a]["sub"];
                    for($b=0;$b<count($m);$b++) {
                        if($base==$m[$b]["url"]) {
                            return array($this->opciones[$a]["url"],$m[$b]["url"]);
                        }else{
                            $m2=$this->opciones[$a]["sub"][$b]["sub"];
                            for($c=0;$c<count($m2);$c++) {
                                if($base==$m2[$c]["url"]){
                                    return array($this->opciones[$a]["url"],$m[$b]["url"],$m2[$c]["url"]);
                                    $fin=true;
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    function ver() {
        $padres=$this->get_padres();
        $base=basename($_SERVER['PHP_SELF']);
        if($base=="otrosproductos.php") {
            $base="productos.php";
        }
        $m1='<span id="main_menu1" align="center">';
        $m2="";
        $fin=false;
        $long=count($this->opciones);
        for ($a=0;$a<$long;$a++) {
            if($this->opciones[$a]["url"]==$padres[0]) {
                $m1.='<a href="'.$this->opciones[$a]["url"].'"  class="link_menu1over" >'.$this->opciones[$a]["titulo"].'</a><a>'.(($a<$long-1)?"&nbsp;|&nbsp;":"")."</a>";
                if(isset($this->opciones[$a]["sub"]) && !$fin) {
                    $m=$this->opciones[$a]["sub"];
                    $long2=count($m);
                    for($b=0;$b<$long2;$b++) {
                        if($m[$b]["url"]==$padres[1] ||$m[$b]["url"]==$base) {
                            $m2.='<a href="'.$m[$b]["url"].'" class="link_menu2over">'.$m[$b]["titulo"].'</a>'.(($b<$long2-1)?"&nbsp;|&nbsp;":"");
                            if(isset($this->opciones[$a]["sub"][$b]["sub"]) && !$fin){
                                $mer=$this->opciones[$a]["sub"][$b]["sub"];
                                $long3=count($mer);
                                for($c=0;$c<$long3;$c++){
                                    if($mer[$c]["url"]==$padres[2] || $mer[$c]["url"]==$base){
                                        $m3.='<a href="'.$mer[$c]["url"].'" class="link_menu2over">'.$mer[$c]["titulo"].'</a>'.(($c<$long3-1)?"&nbsp;|&nbsp;":"");
                                    }else{
                                        $m3.='<a href="'.$mer[$c]["url"].'" class="link_menu2">'.$mer[$c]["titulo"].'</a>'.(($c<$long3-1)?"&nbsp;|&nbsp;":"");
                                    }
                                }
                            }
                            $fin=true;
                        }
                        else {
                            $m2.='<a href="'.$m[$b]["url"].'" class="link_menu2">'.$m[$b]["titulo"].'</a>'.(($b<$long2-1)?"&nbsp;|&nbsp;":"");
                        }
                    }
                }
            }
            else {
                $m1.='<a href="'.$this->opciones[$a]["url"].'" class="link_menu1">'.$this->opciones[$a]["titulo"].'</a><a>'.(($a<$long-1)?"&nbsp;|&nbsp;":"")."</a>";
            }
        }
        $m1.="</span>";

        if($m2!="") {
            $m2='<span id="main_menu2" align="center">'.$m2.'</span>';
        }
        if($m3!=""){
            $m3='<span id="main_menu3" align="center">'.$m3.'</span>';
        }
        return $m1.$m2.$m3;
    }
}
?>