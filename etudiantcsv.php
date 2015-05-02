a<?php

require('connec.php');

function programme($id)
{
	$labels = array('Bidon','TC', 'SRT', 'ISI', 'SM');
	if (is_numeric($id) && $id >= 1 && $id < count($labels))
		return $labels[$id];
	else
		return $labels[1];
}


function LabeltoKey($label) {
    switch ($label) {
    case "TC":
        return 1;
    case "SRT":
        return 2;
    case "ISI":
        return 3;
} 
}

function ajoutEtudiant($db,$programme,$nom,$prenom,$semestre){
    $db->prepare('INSERT INTO ETUDIANT VALUES(NULL,NULL, ?, ?, ?, ?)')
		   ->execute(array(intval($programme),htmlspecialchars($nom), htmlspecialchars($prenom), intval($semestre)));

		echo '<div class="ok">L\'&eacute;tudiant <em>' . htmlspecialchars($nom) . htmlspecialchars($prenom) . '</em> a &eacute;t&eacute; ajout&eacute; ! </div>';

}

function EtudiantAjout($nom,$prenom,$semestre,$programme){

    $programme_cle = LabeltoKey($programme);
    
    
    
}




        

                 
if (isset($_GET['doCSV'])) {
        //if($_FILES["file"]["type"] != "application/vnd.ms-excel"){
	//die("Ce n'est pas un fichier de type .csv"); }
    echo "UP";

}
else
{
                echo '<h2>Ajout d\'etudiant via csv</h2>' . "\n";
		echo '<form method="post" action="" onsubmit="return doCSV();"><p>';
		echo '<input name="file" type="file" />';
                echo '<input type="submit" value="Envoyez le fichier" />';
                echo '</form>';
      
}

                
?>
