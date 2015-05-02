<?php

require('connec.php');
require('fonctionetudiant.php');

echo '<form method="post" enctype="multipart/form-data" action="CSVETUDIANT.php"> ';
echo ' <p> ';
echo ' <input type="file" name="fichier" size="30"> ';
echo ' <input type="submit" name="upload" value="Uploader"> ';
echo ' </p> ';
echo ' </form> ';
        

if( isset($_POST['upload']) ) // si formulaire soumis
{
    $content_dir = 'C:\wamp\www\pro\'; // dossier où sera déplacé le fichier
 
    $tmp_file = $_FILES['fichier']['tmp_name'];

    if( !is_uploaded_file($tmp_file) )
    {
        exit("Le fichier est introuvable");
    }

    // on vérifie maintenant l'extension
    $type_file = $_FILES['fichier']['type'];

    if( !strstr($type_file, 'text/csv') && !strstr($type_file, 'text/anytext') && !strstr($type_file, 'application/txt') && !strstr($type_file, 'application/octet-stream') && !strstr($type_file, 'application/vnd.msexcel') && !strstr($type_file, 'application/csv') && !strstr($type_file, 'text/comma-separated-values') && !strstr($type_file, 'application/excel')  && !strstr($type_file, 'application/vnd.ms-excel'))
    {
        exit("Le fichier n'est pas une image");
    }

    // on copie le fichier dans le dossier de destination
    $name_file = $_FILES['fichier']['name'];

    if( !move_uploaded_file($tmp_file, $content_dir . $name_file) )
    {
        exit("Impossible de copier le fichier dans $content_dir");
    }

    echo "Le fichier a bien été uploadé";
}

?>     

