<?php

include("cls_MantixMenu.php");
$menu = new MantixMenu();
$menu->opciones = array(
    array("titulo" => "Administradores", "url" => "usuarios.php", "id" => "usuarios"),
    array("titulo" => "Publicidad", "url" => "publicidad.php", "id" => "usuarios","sub"=>array(
        array("titulo" => "Publicidad General", "url" => "publicidad.php", "id" => "usuarios"),
        array("titulo" => "Publicidad Lateral 240 x 150", "url" => "publicidadf2.php", "id" => "usuarios"),
    )),
    array("titulo" => "Apartados", "url" => "weekend.php", "id" => "noticias", "sub" => array(
            array("titulo" => "Weekend", "url" => "weekend.php", "id" => "usuarios"),
            array("titulo" => "Tarifas Publicidad", "url" => "tarifas.php", "id" => "usuarios"),
            array("titulo" => "Números Anteriores", "url" => "edicion_articulos.php", "id" => "usuarios","sub"=>array(
                array("titulo" => "Ediciones", "url" => "edicion_articulos.php", "id" => "usuarios"),
                array("titulo" => "Publicidad", "url" => "edicion.php", "id" => "usuarios"),
            )),
            array("titulo" => "Contacto", "url" => "contacto.php", "id" => "usuarios"),
    )),
    //array("titulo"=>"La Revista"            ,"url"=>"larevista.php"       ,"id"=>"usuarios","sub"=>array(
    array("titulo" => "La Revista", "url" => "destacados.php", "id" => "usuarios", "sub" => array(
            array("titulo" => "Portada", "url" => "destacados.php", "id" => "usuarios", "sub"=>array(
                array("titulo" => "Destacados", "url" => "destacados.php", "id" => "usuarios"),
                array("titulo" => "Publicidad", "url" => "portada.php", "id" => "usuarios"),
            )),
            array("titulo" => "Actualidad", "url" => "actualidad.php", "id" => "usuarios", "sub" => array(
                    array("titulo" => "Artículos", "url" => "actualidad.php", "id" => "usuarios"),
                    array("titulo" => "Publicidad", "url" => "cabactualidad.php", "id" => "usuarios"),
            )),
            array("titulo" => "Belleza", "url" => "belleza.php", "id" => "usuarios", "sub" => array(
                    array("titulo" => "Artículos", "url" => "belleza.php", "id" => "usuarios"),
                    array("titulo" => "Publicidad", "url" => "cabbelleza.php", "id" => "usuarios"),
            )),
            array("titulo" => "Tendencias Mujer", "url" => "tendenciasmujer.php", "id" => "usuarios", "sub" => array(
                    array("titulo" => "Artículos", "url" => "tendenciasmujer.php", "id" => "usuarios"),
                    array("titulo" => "Publicidad", "url" => "cabtendenciasmujer.php", "id" => "usuarios"),
            )),
            array("titulo" => "Tendencias", "url" => "tendencias.php", "id" => "usuarios", "sub" => array(
                    array("titulo" => "Artículos", "url" => "tendencias.php", "id" => "usuarios"),
                    array("titulo" => "Publicidad", "url" => "cabtendencias.php", "id" => "usuarios"),
            )),
            array("titulo" => "Tendencias Hombre", "url" => "tendenciashombre.php", "id" => "usuarios", "sub" => array(
                    array("titulo" => "Artículos", "url" => "tendenciashombre.php", "id" => "usuarios"),
                    array("titulo" => "Publicidad", "url" => "cabtendenciashombre.php", "id" => "usuarios"),
            )),
            array("titulo" => "Estilo Mujer", "url" => "estilomujer.php", "id" => "usuarios", "sub" => array(
                    array("titulo" => "Artículos", "url" => "estilomujer.php", "id" => "usuarios"),
                    array("titulo" => "Publicidad", "url" => "cabestilomujer.php", "id" => "usuarios"),
            )),
            array("titulo" => "Estilo Hombre", "url" => "estilohombre.php", "id" => "usuarios", "sub" => array(
                    array("titulo" => "Artículos", "url" => "estilohombre.php", "id" => "usuarios"),
                    array("titulo" => "Publicidad", "url" => "cabestilohombre.php", "id" => "usuarios"),
            )),
            array("titulo" => "Caprichos", "url" => "caprichos.php", "id" => "usuarios", "sub" => array(
                    array("titulo" => "Artículos", "url" => "caprichos.php", "id" => "usuarios"),
                    array("titulo" => "Publicidad", "url" => "cabcaprichos.php", "id" => "usuarios"),
            )),
            array("titulo" => "Viajes", "url" => "viajes.php", "id" => "usuarios", "sub" => array(
                    array("titulo" => "Artículos", "url" => "viajes.php", "id" => "usuarios"),
                    array("titulo" => "Publicidad", "url" => "cabviajes.php", "id" => "usuarios"),
            )),
            array("titulo" => "Ocio", "url" => "ocio.php", "id" => "usuarios", "sub" => array(
                    array("titulo" => "Artículos", "url" => "ocio.php", "id" => "usuarios"),
                    array("titulo" => "Publicidad", "url" => "cabocio.php", "id" => "usuarios"),
            )),
            array("titulo" => "Con Mucho Gusto", "url" => "conmuchogusto.php", "id" => "usuarios", "sub" => array(
                    array("titulo" => "Artículos", "url" => "conmuchogusto.php", "id" => "usuarios"),
                    array("titulo" => "Publicidad", "url" => "cabconmuchogusto.php", "id" => "usuarios"),
            )),
            array("titulo" => "Lo + de la Semana", "url" => "lomasdelasemana.php", "id" => "usuarios", "sub" => array(
                    array("titulo" => "Artículos", "url" => "lomasdelasemana.php", "id" => "usuarios"),
                    array("titulo" => "Publicidad", "url" => "cablomasdelasemana.php", "id" => "usuarios"),
            )),
    )),
    /*array("titulo" => "Secciones", "url" => "secciones.php", "id" => "usuarios"),
    array("titulo" => "Sub-Secciones", "url" => "subsecciones.php", "id" => "usuarios"),*/
        /* array("titulo"=>"Portada"           ,"url"=>"portada.php"    ,"id"=>"usuarios"), */
);
$img_top = "bg-top.gif";
$usuario = "";
//dentro de apartados: weekend, tarifa publcidad, edicion digital -> la revista no se considera
//la revista, debe salirme las secciones correspondientes, el submenú : portada, actualidad, belleza, etc....
//en los campos del formulario: cuidar los acentos y los dos puntos ( : )
//
//
//
?>