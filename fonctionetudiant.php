<?php
require('connec.php');
// Fonction qui affiche tout les étudiants avec leurs tuteurs. :
function displayAll($db) {
    echo '<h1>Liste des &eacute;tudiants avec leurs tuteurs.</h1>' . "\n";
    echo '<div><a href="#" onclick="return addEtudiant();">Nouvel &eacute;tudiant</a></div>' . "\n";
    echo '<div><a href="#" onclick="return etudiantcsv();">Ajouter etudiantCSV</a></div>' . "\n";
    echo '<div><a href="#" onclick="return doTC();">Visualiser étudiant du TCg</a></div>' . "\n";
    echo '<div><a href="#" onclick="return doSRT();">Visualiser étudiant de SRT</a></div>' . "\n";
    echo '<div><a href="#" onclick="return doISI();">Visualiser étudiant de ISI</a></div>' . "\n";
    echo '<div><a href="#" onclick="return doSM();">Visualiser étudiant de SM</a></div>' . "\n";
    echo '<div><a href="#" onclick="return doOR();">Visualiser étudiant orphelin</a></div>' . "\n";
    echo '<div><a href="#" onclick="return tutueurA();">Le tuteur pour tous</a></div>' . "\n";
    echo '<div><a href="#" onclick="return delAll();">Supprimer tout les étudiants</a></div>' . "\n";
    echo '<table><thead><th>Numero</th><th>Nom Etudiant</th><th>Prenom Etudiant</th><th>Prorgramme</th><th>Semestre</th><th>Tuteur Nom</th><th>Tuteur prénom</th><th>Actions</th></thead>' . "\n";

    foreach ($db->query('SELECT ET_NUM,ET_NOM, ET_Prenom,PR_LIBELLE, ET_SEMESTRE, EC_PRENOM, EC_NOM FROM ETUDIANT LEFT JOIN ec USING ( EC_ID ) LEFT JOIN programme USING (PR_ID)') as $etudiant) {
        echo '<tr><td><em>' . $etudiant['ET_NUM'] . '</em></td>';
        echo '<td>' . $etudiant['ET_NOM'] . '</td>';
        echo '<td>' . $etudiant['ET_Prenom'] . '</td>';
        echo '<td>' . $etudiant['PR_LIBELLE'] . '</td>';
        echo '<td>' . $etudiant['ET_SEMESTRE'] . '</td>';
        echo '<td>' . (empty($etudiant['EC_NOM']) ? '<em>Aucun Tuteur</em>' : $etudiant['EC_NOM']) . '</td>'; // à la place utiliser une fonction qui retourne le nom du professeur
        echo '<td>' . (empty($etudiant['EC_PRENOM']) ? '<em><a href="#" onclick="return addTut(' . $etudiant['ET_NUM'] . ');">Ajouter Tuteur</a></em>' : $etudiant['EC_PRENOM']) . '</td>';
        echo '<td><a href="#" onclick="return etudiant(' . $etudiant['ET_NUM'] . ');">Modifier</a><br /><a href="#" onclick="return deletu(' . $etudiant['ET_NUM'] . ');">Supprimer</a></td></tr>' . "\n";
    }

    echo '</table>';
}


//Fonction qui affiche uniquement les étudiants.
function displayetudiant($db) {
    echo '<h1>Liste des &eacute;tudiants</h1>' . "\n";
    echo '<div><a href="#" onclick="return addEtudiant();">Nouvel &eacute;tudiant</a></div>' . "\n";
    echo '<div><a href="#" onclick="return delAll();">Supprimer tout les étudiants</a></div>' . "\n";
    echo '<table><thead><th>Numero</th><th>Nom Etudiant</th><th>Prenom Etudiant</th><th>Programme</th><th>Semestre</th><th>Actions</th></thead>' . "\n";

    foreach ($db->query('SELECT ET_NUM,ET_NOM, ET_Prenom,PR_LIBELLE, ET_SEMESTRE FROM ETUDIANT LEFT JOIN programme USING (PR_ID)') as $etudiant) {
        echo '<tr><td><em>' . $etudiant['ET_NUM'] . '</em></td>';
        echo '<td>' . $etudiant['ET_NOM'] . '</td>';
        echo '<td>' . $etudiant['ET_Prenom'] . '</td>';
        echo '<td>' . $etudiant['PR_LIBELLE'] . '</td>';
        echo '<td>' . $etudiant['ET_SEMESTRE'] . '</td>';
        echo '<td><a href="#" onclick="return etudiant(' . $etudiant['ET_NUM'] . ');">Modifier</a><br /><a href="#" onclick="return deletu(' . $etudiant['ET_NUM'] . ');">Supprimer</a></td></tr>' . "\n";
    }

    echo '</table>';
}

//fonction qui affiche uniquement les étudiants sans tuteurs.
function displayetudiant_sanstuteur($db) {
    echo '<h1>Liste des &eacute;tudiants avec leurs tuteurs.</h1>' . "\n";
    echo '<div><a href="#" onclick="return addEtudiant();">Nouvel &eacute;tudiant</a></div>' . "\n";
    echo '<div><a href="#" onclick="return doTC();">Visualiser étudiant du TCg</a></div>' . "\n";
    echo '<div><a href="#" onclick="return doSRT();">Visualiser étudiant de SRT</a></div>' . "\n";
    echo '<div><a href="#" onclick="return doISI();">Visualiser étudiant de ISI</a></div>' . "\n";
    echo '<div><a href="#" onclick="return doSM();">Visualiser étudiant de SM</a></div>' . "\n";
    echo '<div><a href="#" onclick="return doOR();">Visualiser étudiant orphelin</a></div>' . "\n";
    echo '<div><a href="#" onclick="return tutueurA();">Le tuteur pour tous</a></div>' . "\n";
    echo '<div><a href="#" onclick="return delAll();">Supprimer tout les étudiants</a></div>' . "\n";
    echo '<table><thead><th>Numero</th><th>Nom Etudiant</th><th>Prenom Etudiant</th><th>Prorgramme</th><th>Semestre</th><th>Tuteur Nom</th><th>Tuteur prénom</th><th>Actions</th></thead>' . "\n";

    foreach ($db->query('SELECT ET_NUM,ET_NOM, ET_Prenom,PR_LIBELLE, ET_SEMESTRE, EC_PRENOM, EC_NOM FROM ETUDIANT LEFT JOIN ec USING ( EC_ID ) LEFT JOIN programme USING (PR_ID) where EC_ID is null ') as $etudiant) {
        echo '<tr><td><em>' . $etudiant['ET_NUM'] . '</em></td>';
        echo '<td>' . $etudiant['ET_NOM'] . '</td>';
        echo '<td>' . $etudiant['ET_Prenom'] . '</td>';
        echo '<td>' . $etudiant['PR_LIBELLE'] . '</td>';
        echo '<td>' . $etudiant['ET_SEMESTRE'] . '</td>';
        echo '<td>' . (empty($etudiant['EC_NOM']) ? '<em>Aucun Tuteur</em>' : $etudiant['EC_NOM']) . '</td>'; // à la place utiliser une fonction qui retourne le nom du professeur
        echo '<td>' . (empty($etudiant['EC_PRENOM']) ? '<em><a href="#" onclick="return addTut(' . $etudiant['ET_NUM'] . ');">Ajouter Tuteur</a></em>' : $etudiant['EC_PRENOM']) . '</td>';
        echo '<td><a href="#" onclick="return etudiant(' . $etudiant['ET_NUM'] . ');">Modifier</a><br /><a href="#" onclick="return deletu(' . $etudiant['ET_NUM'] . ');">Supprimer</a></td></tr>' . "\n";
    }

    echo '</table>';
}

//fonction quii affiche uniquement les étudiants d'un programme donnée :

function displayetudiant_programme($db, $programme) {
    echo '<h1>Liste des &eacute;tudiants avec leurs tuteurs.</h1>' . "\n";
    echo '<div><a href="#" onclick="return addEtudiant();">Nouvel &eacute;tudiant</a></div>' . "\n";
    echo '<div><a href="#" onclick="return tutueurA();">Le tuteur pour tous</a></div>' . "\n";
        echo '<div><a href="#" onclick="return doTC();">Visualiser étudiant du TCg</a></div>' . "\n";
    echo '<div><a href="#" onclick="return doSRT();">Visualiser étudiant de SRT</a></div>' . "\n";
    echo '<div><a href="#" onclick="return doISI();">Visualiser étudiant de ISI</a></div>' . "\n";
    echo '<div><a href="#" onclick="return doSM();">Visualiser étudiant de SM</a></div>' . "\n";
    echo '<div><a href="#" onclick="return doOR();">Visualiser étudiant orphelin</a></div>' . "\n";
    echo '<div><a href="#" onclick="return delAll();">Supprimer tout les étudiants</a></div>' . "\n";
    echo '<table><thead><th>Numero</th><th>Nom Etudiant</th><th>Prenom Etudiant</th><th>Prorgramme</th><th>Semestre</th><th>Tuteur Nom</th><th>Tuteur prénom</th><th>Actions</th></thead>' . "\n";

    foreach ($db->query('SELECT ET_NUM,ET_NOM, ET_Prenom,PR_LIBELLE, ET_SEMESTRE, EC_PRENOM, EC_NOM FROM ETUDIANT LEFT JOIN ec USING ( EC_ID ) LEFT JOIN programme USING (PR_ID) where PR_ID = "' . $programme . '"') as $etudiant) {
        echo '<tr><td><em>' . $etudiant['ET_NUM'] . '</em></td>';
        echo '<td>' . $etudiant['ET_NOM'] . '</td>';
        echo '<td>' . $etudiant['ET_Prenom'] . '</td>';
        echo '<td>' . $etudiant['PR_LIBELLE'] . '</td>';
        echo '<td>' . $etudiant['ET_SEMESTRE'] . '</td>';
        echo '<td>' . (empty($etudiant['EC_NOM']) ? '<em>Aucun Tuteur</em>' : $etudiant['EC_NOM']) . '</td>'; // à la place utiliser une fonction qui retourne le nom du professeur
        echo '<td>' . (empty($etudiant['EC_PRENOM']) ? '<em><a href="#" onclick="return addTut(' . $etudiant['ET_NUM'] . ');">Ajouter Tuteur</a></em>' : $etudiant['EC_PRENOM']) . '</td>';
        echo '<td><a href="#" onclick="return etudiant(' . $etudiant['ET_NUM'] . ');">Modifier</a><br /><a href="#" onclick="return deletu(' . $etudiant['ET_NUM'] . ');">Supprimer</a></td></tr>' . "\n";
    }

    echo '</table>';
}

// ajout d'un tuteur
function ajouterTuteur($id, $db) {

    $programme = $db->query('Select PR_ID from ETUDIANT where ET_NUM =' . $id);
    $programme_final = $programme->fetch();
    $programme_number = $programme_final['PR_ID'];
    $min = $db->query('Select Min(nbe) from (SELECT Count(et.ec_id) AS nbe FROM   etudiant et  where exists (Select * from habilite hab2 where hab2.ec_id = et.ec_id and hab2.pr_id = ' . $programme_number . ')  GROUP  BY ec_id) e ');
    $min_final = $min->fetch();
    $min_number = $min_final['Min(nbe)'];
    $nouveau_prof = $db->query('Select ec1.ec_id From EC ec1 where not exists (Select * from etudiant et where  et.ec_id = ec1.ec_id) and exists (Select * from habilite ha where ha.pr_id = ' . $programme_number . ' and ha.ec_id = ec1.ec_id) LIMIT 0,1'); // vérifie si il n'existe pas un nouveau prof n'ayant pas encore d'élève.
    $nouveau_prof_final = $nouveau_prof->fetch();
    $nouveau_prof_number = $nouveau_prof_final['ec_id'];
    $nomEtudiant = $db->query('Select ET_NOM from ETUDIANT where ET_NUM =' . $id);
    $nomEtudiant_final = $nomEtudiant->fetch();
    $nomEtudiant_number = $nomEtudiant_final['ET_NOM'];
    $prenomEtudiant = $db->query('Select ET_PRENOM from ETUDIANT where ET_NUM =' . $id);
    $prenomEtudiant_final = $prenomEtudiant->fetch();
    $prenomEtudiant_number = $prenomEtudiant_final['ET_PRENOM'];
    if ($nouveau_prof_number != '') {

        $db->prepare('UPDATE ETUDIANT SET EC_id=? WHERE ET_NUM=' . $id)
                ->execute(array($nouveau_prof_number));
        echo '<div class="ok">L\'&eacute;tudiant <em>' . $nomEtudiant_number . " " . $prenomEtudiant_number . '</em> a bien &eacute;t&eacute; un nouveau tuteur; ! </div>';
    } else {
        $professeur = $db->query(' SELECT e1.ec_id FROM   etudiant e1 JOIN (SELECT ec_id FROM   etudiant GROUP  BY ec_id HAVING Count(*) = ' . $min_number . ') e2 ON e1.ec_id = e2.ec_id LIMIT 0,1');
        $professeur_final = $professeur->fetch();
        $professeur_number = $professeur_final['ec_id'];
        $db->prepare('UPDATE ETUDIANT SET EC_id=? WHERE ET_NUM=' . $id)
                ->execute(array($professeur_number));

        echo '<div class="ok">L\'&eacute;tudiant <em>' . $nomEtudiant_number . " " . $prenomEtudiant_number . '</em> a bien &eacute;t&eacute; un nouveau tuteur; ! </div>';
    }
}

//ajout d'un tuteur à tout les étudiants n'en ayant pas.
function tutueurAll($db) {
    foreach ($db->query('SELECT * FROM `etudiant` WHERE EC_ID is null') as $etudiant) {
        ajouterTuteur($etudiant['ET_NUM'], $db);
    }
}

// retourne le programme en fonction d'un id.
function programme($id)
{
	$labels = array('Bidon','TC', 'SRT', 'ISI', 'SM');
	if (is_numeric($id) && $id >= 1 && $id < count($labels))
		return $labels[$id];
	else
		return $labels[1];
}

// retourne le la clef associé à un label
function LabeltoKey($label) {
    switch ($label) {
    case "TC":
        return 1;
    case "SRT":
        return 2;
    case "ISI":
        return 3;
    case "ISI":
        return 4;
} 
}





//vérifie les doublons. Retourne le nombre de doublon existant..
function verifdoublon($nom,$prenom,$db){
$nbr = $db->query('Select count(*) as nbe from ETUDIANT where ET_NOM = "' . $nom .'"');
$nbr_final = $nbr->fetch();
$nbr_number = $nbr_final['nbe'];


return $nbr_number;
}

//ajoute un Etudiant à la base.

function EtudiantAjout($nom,$prenom,$semestre,$programme,$db){

$count = verifdoublon($nom,$prenom,$db);


 If($count > 0 ) {
   echo $prenom . " " . $nom . ' existe déjà dans la base';
 }
else {
    $db->prepare('INSERT INTO ETUDIANT VALUES(NULL,NULL, ?, ?, ?, ?)')
    ->execute(array($programme,$nom, $prenom, $semestre));
echo $count;
echo '<div class="ok">L\'&eacute;tudiant <em>' . htmlspecialchars($_GET['nom']) . '</em> a &eacute;t&eacute; ajout&eacute; ! </div>' . $count;;
displayAll($db);
}    
    
}


//formulaire suppression de tout les étudiants.

function supprimetous($db){
    
    $db->query('DELETE FROM ETUDIANT');
	echo '<div class="ok">Les eleves ont biens tous ete supprimes</div>';
}


//vérifie si le tuteur est habilité au programme passé en parametre
function verif($db,$prog,$ec) {
$nbr = $db->query('Select count(*) as nbe from HABILITE where EC_ID = "' . $ec .'" and PR_ID = "' . $prog .'"');
$nbr_final = $nbr->fetch();
$nbr_number = $nbr_final['nbe'];
return $nbr_number;
}
?>
