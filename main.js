
function page(p)
{
	document.getElementById("main").innerHTML = p;
	switch(p)
	{
		case "main":
			main();
			break;

		case "etudiant":
			etudiant();
			break;

		case "ec":
			ec();
			break;

		case "drh":
			drh();
			break;

		case "scolarite":
			scolarite();
			break;

		default:
			error();
			break;
	}
	return false;
}

function exec(p, id)
{
	var xhr;
    if (window.XMLHttpRequest)
        xhr = new XMLHttpRequest();
    else
    {
    	alert("Il faut utiliser un navigateur moderne pour donner une note d'ergonomie");
    	return "Il faut utiliser un navigateur moderne pour donner une note d'ergonomie";
    }

    xhr.onreadystatechange = function()
    {
    	if (xhr.readyState == 4)
    	{
    		document.getElementById(id).innerHTML = xhr.responseText;
    		if (id == "win")
    			pop();
    	}
    }

    xhr.open("GET", p, true);
    xhr.send("");
}

function pop()
{
	// Pop the window
	document.getElementById("window").style.display = "block";
}

function closeWin()
{
	// Pop out the window
	document.getElementById("window").style.display = "none";
}




function error()
{
	document.getElementById("main").innerHTML = "Une erreur a eu lieu. ";
	return false;
}

function main()
{
	exec("main.php", "main");
	return false;
}


window.onload = function() { page('main'); };
