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
    if($w==778 && $h==486)
        echo $narchivo;
    else{
        unlink($ruta0);
        echo 'Error: La imagen debe medir 778 x 486px';
    }
    //clipImage($ruta0, $ruta0, 180, 90);
}
?>