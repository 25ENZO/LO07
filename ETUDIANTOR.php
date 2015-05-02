

<?php

session_start();
require('connec.php');
require('fonctionetudiant.php');



if (isset($_SESSION['user_name'])) {
    if ($_SESSION['user_name'] == "scolarite") {
        if (isset($_GET['delAll'])) {
            supprimetous($db);
        }
        if (isset($_GET['tutueurA'])) {
            tutueurAll($db);
        }
        if (isset($_GET['del'])) {

            $db->prepare('DELETE FROM ETUDIANT WHERE ET_NUM=?')
                    ->execute(array(intval($_GET['del'])));

            echo '<div class="ok">L\'&eacute;tudiant  ont &eacute;t&eacute; supprim&eacute;s</div>';
        }

        if (isset($_GET['etudiantcsv'])) {
            // if(!isset($_FILE[]))
            //{
            //  echo 'forumlaire';
            //}
            //else {
            //traitement
            //}
        }
        
        
        if (isset($_GET['TC'])) {
                header('Location: ETUDIANTSRT.php');
            } 
             if (isset($_GET['SRT'])) {
                header('Location: ETUDIANTSRT.php');
            } 
             if (isset($_GET['ISI'])) {
                header('Location: ETUDIANTISI.php');
            } 
             if (isset($_GET['SM'])) {
                header('Location: ETUDIANTSM.php');
            } 
             if (isset($_GET['OR'])) {
                header('Location: ETUDIANTOR.php');
            } 
        




        if (isset($_GET['add'])) {
            if (!isset($_GET['nom'], $_GET['prenom'], $_GET['programme'], $_GET['semestre'])) {
                echo '<h2>Ajout d\'un &eacute;tudiant</h2>' . "\n";
                echo '<form method="post" action="" onsubmit="return doEtudiant();"><p>';
                echo '<label for="nom">Nom de l\'&eacute;tudiant</label>';
                echo '<input type="text" required="required" name="nom" id="nom" value="" /><br /><br />';
                echo '<label for="prenom">Prénom de l\'&eacute;tudiant</label>';
                echo '<input type="text" required="required"  name="prenom" id="prenom" value="" /><br /><br />';
                echo '<label for="programme">Programme</label>';
                echo '<select id="programme" name="programme">';
                for ($i = 1; $i < 5; $i++)
                    echo '<option value="' . $i . '">' . programme($i) . '</option>';
                echo '</select><br /><br />';
                echo '<label for="semestre">Semestre de l\'&eacute;tudiant</label>';
                echo '<input type="text" required="required" pattern="[0-9]{1,2}" name="semestre" id="semestre" value="" /><br /><br />';

                echo '<input type="submit" name="valider" value="Ajouter" /> ';
                echo '<input type="button" name="annuler" onclick="closeWin();" value="Annuler" />';
                echo '</p></form>' . "\n";
            } else {

                EtudiantAjout(htmlspecialchars($_GET['nom']), htmlspecialchars($_GET['prenom']), intval($_GET['semestre']), intval($_GET['programme']), $db);
            }
        } elseif (isset($_GET['edit'], $_GET['nom'], $_GET['prenom'], $_GET['programme'], $_GET['semestre'])) {
            $db->prepare('UPDATE ETUDIANT SET ET_nom=?, ET_prenom=?,PR_ID=?, ET_semestre=? WHERE ET_NUM=' . intval($_GET['edit']))
                    ->execute(array(htmlspecialchars($_GET['nom']), htmlspecialchars($_GET['prenom']), intval($_GET['programme']), intval($_GET['semestre'])));

            echo '<div class="ok">L\'&eacute;tudiant <em>' . htmlspecialchars($_GET['nom']) . '</em> a bien &eacute;t&eacute; modifi&eacute; ! </div>';
            $cor = verif($db, $_GET['programme'], $_GET['programme']);
            if ($cor < 1) {
                ajouterTuteur($_GET['edit'], $db);
            }
            displayAll($db);
        } elseif (isset($_GET['id']) && intval($_GET['id']) > 0) {
            // Specific student
            $student = $db->query('SELECT ET_NUM,ET_NOM, ET_Prenom,PR_LIBELLE, PR_ID, ET_SEMESTRE, EC_PRENOM, EC_ID, EC_NOM FROM ETUDIANT LEFT JOIN ec USING ( EC_ID ) LEFT JOIN programme USING (PR_ID) WHERE ET_NUM=' . intval($_GET['id']))->fetch();

            if (!$student)
                echo "Cet &eacute;tudiant n'existe pas. ";
            else {

                echo '<h2>&Eacute;dition de <em>' . $student['ET_NOM'] . " " . $student['ET_Prenom'] . '</em></h2>' . "\n";
                echo '<form method="post" action="" onsubmit="return doEtudiant(' . $student['ET_NUM'] . ');"><p>';
                echo '<label for="nom">Nom de l\'&eacute;tudiant</label>';
                echo '<input type="text" required="required" name="nom" id="nom" value="' . $student['ET_NOM'] . '" /><br /><br />';
                echo '<label for="prenom">Prenom de l\'&eacute;tudiant</label>';
                echo '<input type="text" required="required" name="prenom" id="prenom" value="' . $student['ET_Prenom'] . '" /><br /><br />';
                echo '<label for="semestre">Semestrede l\'&eacute;tudiant</label>';
                echo '<input type="text" required="required" name="semestre" id="semestre" value="' . $student['ET_SEMESTRE'] . '" /><br /><br />';
                echo '<input type="hidden" required="required" name="ec" id="ec" value="' . $student['EC_ID'] . '" /><br /><br />';
                echo '<label for="programme">Programme</label>';
                echo '<select id="programme" name="programme">';
                for ($i = 0; $i < 5; $i++)
                    echo '<option value="' . $i . '"' . (($student['PR_ID'] == $i) ? ' selected="selected"' : '') . '>' . programme($i) . '</option>';
                echo '</select><br /><br />';
                echo '<input type="submit" name="valider" value="Modifier" /> ';
                echo '<input type="button" name="annuler" onclick="closeWin();" value="Annuler" />';
                echo '</p></form>' . "\n";
            }
        } elseif (isset($_GET['addTut'])) {

            ajouterTuteur($_GET['addTut'], $db);
            displayAll($db);
        } else {
            // Global tables
            echo $_SESSION['user_name'];
            displayetudiant_sanstuteur($db);
        }
    } else {
        echo "Vous ne devriez pas être là";
    }
} else {
    header('Location: index.php');
}


