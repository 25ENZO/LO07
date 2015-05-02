var ecTimer;



function ec(id = 0)
{
	exec("ec.php?id=" + id, id == 0 ? "main" : "win");
	window.clearInterval(ec);
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

function delAll(id="")
{
	if (confirm("Voulez-vous vraiment supprimer cet etudiant ? "))
	{
		exec("etudiant.php?delAll=" +id, "main");
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
	
	if (id <= 0)
		addEtudiant(nom, prenom, programme, semestre);
	else
		editEtudiant(id, nom, prenom, programme, semestre);
	return false;
}

function editEtudiant(id = 0, nom = "", prenom = "", programme ="",semestre ="")
{
	exec("etudiant.php?edit=" + id + "&nom=" + nom + "&prenom=" + prenom + "&programme=" + programme + "&semestre=" + semestre, "main");
	closeWin();
}
