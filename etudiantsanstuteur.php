e

<?php
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

function EtudiantAjout($nom,$prenom,$semestre,$programme){

    $programme_cle = LabeltoKey($programme);
    
    
    
}





function ajouterTuteur($id,$db) {
    // ajoute le tuteur habilité ayant le moins d'étudiant à l'étudiaant ayant ocmme numéro $id.
    
    $programme = $db->query('Select PR_ID from ETUDIANT where ET_NUM =' .$id);
    $programme_final = $programme->fetch();
    $programme_number = $programme_final['PR_ID'];
    //$min = $db->query('Select Min(nbe) from (SELECT Count(ec_id) AS nbe FROM   etudiant GROUP  BY ec_id) e');
    $min = $db->query('Select Min(nbe) from (SELECT Count(et.ec_id) AS nbe FROM   etudiant et  where exists (Select * from habilite hab2 where hab2.ec_id = et.ec_id and hab2.pr_id = ' .$programme_number .')  GROUP  BY ec_id) e ');
    $min_final = $min->fetch();
    $min_number = $min_final['Min(nbe)'];
    $nouveau_prof = $db->query('Select ec1.ec_id From EC ec1 where not exists (Select * from etudiant et where  et.ec_id = ec1.ec_id) and exists (Select * from habilite ha where ha.pr_id = ' . $programme_number . ' and ha.ec_id = ec1.ec_id) LIMIT 0,1'); // vérifie si il n'existe pas un nouveau prof n'ayant pas encore d'élève.
    $nouveau_prof_final = $nouveau_prof->fetch();
    $nouveau_prof_number = $nouveau_prof_final['ec_id'];
    $nomEtudiant = $db->query('Select ET_NOM from ETUDIANT where ET_NUM =' .$id);
    $nomEtudiant_final = $nomEtudiant->fetch();
    $nomEtudiant_number = $nomEtudiant_final['ET_NOM'];
    $prenomEtudiant = $db->query('Select ET_PRENOM from ETUDIANT where ET_NUM =' .$id);
    $prenomEtudiant_final = $prenomEtudiant->fetch();
    $prenomEtudiant_number = $prenomEtudiant_final['ET_PRENOM'];
   if ($nouveau_prof_number !='')
    {
        
         $db->prepare('UPDATE ETUDIANT SET EC_id=? WHERE ET_NUM=' . $id)
	   ->execute(array($nouveau_prof_number));

	echo '<div class="ok">L\'&eacute;tudiant <em>' . $nomEtudiant_number . " " .$prenomEtudiant_number . '</em> a bien &eacute;t&eacute; un nouveau tuteur; ! </div>';

	
        
    }
    else {
    $professeur = $db->query(' SELECT e1.ec_id FROM   etudiant e1 JOIN (SELECT ec_id FROM   etudiant GROUP  BY ec_id HAVING Count(*) = '. $min_number .') e2 ON e1.ec_id = e2.ec_id LIMIT 0,1');
    //$professeur = $db->query('SELECT e1.ec_id FROM   etudiant e1 JOIN (SELECT ec_id FROM   etudiant GROUP  BY ec_id HAVING Count(*) = ' . $programme_number . ') e2  JOIN (Select ec_id from habilite  where pr_id = ' . $programme_number . ') h1 ON e1.ec_id = e2.ec_id = h1.ec_id');
    
    $professeur_final = $professeur->fetch();
    $professeur_number = $professeur_final['ec_id'];
    
    echo "Professeur numéro :" . $professeur_number;

     $db->prepare('UPDATE ETUDIANT SET EC_id=? WHERE ET_NUM=' . $id)
	   ->execute(array($professeur_number));

	echo '<div class="ok">L\'&eacute;tudiant <em>' . $nomEtudiant_number . " " .$prenomEtudiant_number . '</em> a bien &eacute;t&eacute; un nouveau tuteur; ! </div>';

	
    }
    
    
    /*
   */
}

 function tutueurAll($db)
{
	

	foreach($db->query('SELECT * FROM `etudiant` WHERE EC_ID is null') as $etudiant)


	 {
                
		ajouterTuteur($etudiant['ET_NUM'],$db);
                
	} 
        
	
} 



function displayAll($db)
{
	echo '<h1>Liste des &eacute;tudiants</h1>' . "\n";
	echo '<div><a href="#" onclick="return addEtudiant();">Nouvel &eacute;tudiant</a></div>' . "\n";
        echo '<div><a href="#" onclick="return tutueurA();">Le tuteur pour tous</a></div>' . "\n";
        echo '<div><a href="#" onclick="return delAll();">Supprimer tout les étudiants</a></div>' . "\n";
	echo '<table><thead><th>Numero</th><th>Nom Etudiant</th><th>Prenom Etudiant</th><th>Prorgramme</th><th>Semestre</th><th>Tuteur Nom</th><th>Tuteur prénom</th><th>Actions</th></thead>' . "\n";

	foreach($db->query('SELECT ET_NUM,ET_NOM, ET_Prenom,PR_LIBELLE, ET_SEMESTRE, EC_PRENOM, EC_NOM FROM ETUDIANT   LEFT JOIN ec USING ( EC_ID ) LEFT JOIN programme USING (PR_ID) Where EC_NOM is null') as $etudiant)


	 {
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
if (isset($_GET['delAll']))
{
    $db->query('DELETE FROM ETUDIANT');
	echo '<div class="ok">La table a bien été supprimé</div>';
}
if (isset($_GET['tutueurA'])) {
    tutueurAll($db);
}
if (isset($_GET['del']))
{

	$db->prepare('DELETE FROM ETUDIANT WHERE ET_NUM=?')
	   ->execute(array(intval($_GET['del'])));

	echo '<div class="ok">L\'&eacute;tudiant  ont &eacute;t&eacute; supprim&eacute;s</div>';
}


if (isset($_GET['add']))
{
	if (!isset($_GET['nom'], $_GET['prenom'], $_GET['programme'], $_GET['semestre']))
	{
		echo '<h2>Ajout d\'un &eacute;tudiant</h2>' . "\n";
		echo '<form method="post" action="" onsubmit="return doEtudiant();"><p>';
		echo '<label for="nom">Nom de l\'&eacute;tudiant</label>';
		echo '<input type="text" required="required" name="nom" id="nom" value="" /><br /><br />';
		echo '<label for="prenom">Prénom de l\'&eacute;tudiant</label>';
		echo '<input type="text" required="required"  name="prenom" id="prenom" value="" /><br /><br />';
		echo '<label for="programme">Programme</label>';
		echo '<select id="programme" name="programme">';
		for ($i = 1 ; $i < 5 ; $i++)
			echo '<option value="' . $i . '">' . programme($i) . '</option>';
		echo '</select><br /><br />';
                echo '<label for="semestre">Semestre de l\'&eacute;tudiant</label>';
		echo '<input type="text" required="required" pattern="[0-9]{1,2}" name="semestre" id="semestre" value="" /><br /><br />';
		
		echo '<input type="submit" name="valider" value="Ajouter" /> ';
		echo '<input type="button" name="annuler" onclick="closeWin();" value="Annuler" />';
		echo '</p></form>' . "\n";
	}
	else
	{
		$db->prepare('INSERT INTO ETUDIANT VALUES(NULL,NULL, ?, ?, ?, ?)')
		   ->execute(array(intval($_GET['programme']),htmlspecialchars($_GET['nom']), htmlspecialchars($_GET['prenom']), intval($_GET['semestre'])));

		echo '<div class="ok">L\'&eacute;tudiant <em>' . htmlspecialchars($_GET['nom']) . '</em> a &eacute;t&eacute; ajout&eacute; ! </div>';

		displayAll($db);
	}
}
elseif (isset($_GET['edit'], $_GET['prenom'], $_GET['programme'], $_GET['semestre']))
{
	$db->prepare('UPDATE ETUDIANT SET ET_nom=?, ET_prenom=?, ET_Programme=?, ET_semestre=? WHERE ET_NUM=' . intval($_GET['edit']))
	   ->execute(array(htmlspecialchars($_GET['nom']), intval($_GET['prenom']), intval($_GET['programme']), intval($_GET['semestre'])));

	echo '<div class="ok">L\'&eacute;tudiant <em>' . htmlspecialchars($_GET['nom']) . '</em> a bien &eacute;t&eacute; modifi&eacute; ! </div>';

	displayAll($db);
}
elseif (isset($_GET['id']) && intval($_GET['id']) > 0)
{
	// Specific student
	$student = $db->query('SELECT * FROM ETUDIANT WHERE ET_NUM=' . intval($_GET['id']))->fetch();
	
	if (!$student)
		echo "Cet &eacute;tudiant n'existe pas. ";
	else
	{

		//possibilité de gérer l'ajout d'un tuteur à partir d'ici. 



		

		
	}
} 
elseif (isset($_GET['addTut'])) {
 
    ajouterTuteur($_GET['addTut'],$db);
    displayAll($db);
}
else
{
	// Global tables

	displayAll($db);
}
