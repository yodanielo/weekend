<?php
if (!empty($_FILES)) {
    $narchivo= mktime().str_replace(" ","",basename(strtolower($_FILES['Filedata']['name'])));
    //la carpeta de donde se parte es la carpeta donde esta este fichero php
    //desde ahi hay que enrutar el archivo subido hacia su ubicacion final
    $ruta0 = "../images/recursos/".strtolower($narchivo);
    move_uploaded_file($_FILES['Filedata']['tmp_name'], $ruta0);
    include_once("fimagenes.php");
    $imSrc  = imagecreatefromjpeg($ruta0 );
    $w      = imagesx($imSrc);
    $h      = imagesy($imSrc);
    if($w==960 && $h==90)
        echo $narchivo;
    else{
        unlink($ruta0);
        echo 'Error: La imagen debe medir 960 x 90px';
    }
}
?>