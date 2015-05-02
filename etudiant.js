var etuTimer;





function etudiant(id)
{
	exec("etudiant.php?id=" + id, id == 0 ? "main" : "win");
	window.clearInterval(etudiant);
	return false;
}


function doTC(id)
{
        var id = 1;
	if (confirm("Voulez-vous vraiment visualiser les etudiants de TC  ? "))
	{
		exec("etudiant.php?TC=" +id, "main");
	}
	return false;
}

function doSRT(id)
{
        var id = 2;
	if (confirm("Voulez-vous vraiment visualiser les etudiants de SRT  ? "))
	{
		exec("etudiant.php?SRT=" +id, "main");
	}
	return false;
}

function doISI(id)
{
        var id = 3;
	if (confirm("Voulez-vous vraiment visualiser les etudiants de ISI  ? "))
	{
		exec("etudiant.php?ISI=" +id, "main");
	}
	return false;
}

function doSM(id)
{
        var id = 3;
	if (confirm("Voulez-vous vraiment visualiser les etudiants de SM  ? "))
	{
		exec("etudiant.php?SM=" +id, "main");
	}
	return false;
}
function doOR(id)
{
        var id = 3;
	if (confirm("Voulez-vous vraiment visualiser les etudiants orphelin ? "))
	{
		exec("etudiant.php?OR=" +id, "main");
	}
	return false;
}

function deletu(id)
{
	if (confirm("Voulez-vous vraiment supprimer cet etudiant ? "))
	{
		exec("etudiant.php?del=" + id, "main");
	}
	return false;
}

function delAll()
{
	if (confirm("Voulez-vous vraiment supprimer cet etudiant ? "))
	{
		exec("etudiant.php?delAll=" +id, "main");
	}
	return false;
}

function addTut(id)
{
	if (confirm("Voulez-vous vraiment ajouter un tuteur àcet etudiant ? "))
	{
		exec("etudiant.php?addTut=" + id, "main");
	}
	return false;
}

function tutueurA(db)
{
	if (confirm("Voulez-vous vraiment ajouter un tuteur à tout les  etudiant ? "))
	{
		exec("etudiant.php?tutueurA=" + db, "main");
	}
	return false;
}



function addEtudiant(nom = "", prenom = "", programme ="",semestre ="")
{
	if (nom != "" && prenom != "", programme != "", semestre !="")
	{
		exec("etudiant.php?add&nom=" + nom + "&prenom=" + prenom + "&programme=" + programme + "&semestre=" + semestre, "main");
		closeWin();
	}
	else
		exec("etudiant.php?add", "win");
	return false;
}

function doEtudiant(id = 0)
{
	var nom = document.getElementById('nom').value;
        var prenom = document.getElementById('prenom').value;
	var programme = document.getElementById('programme').value;
	var semestre = document.getElementById('semestre').value;
	var ec = document.getElementById('ec').value;
	if (id <= 0)
		addEtudiant(nom, prenom, programme, semestre);
	else
		editEtudiant(id, nom, prenom, programme, semestre,ec);
	return false;
}

function editEtudiant(id = 0, nom = "", prenom = "", programme ="",semestre ="", ec="")
{
	exec("etudiant.php?edit=" + id + "&nom=" + nom + "&prenom=" + prenom + "&programme=" + programme + "&semestre=" + semestre +"$ec=" +ec, "main");
	closeWin();
}
