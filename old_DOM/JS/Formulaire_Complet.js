function CheckForm()
{
	document.getElementById("MyForm01").submit();
}

function ReloadForm()
{
	var currentURL = window.location.href.split('#');
	var URLToReload = currentURL[0];
	window.location.assign(URLToReload);
}