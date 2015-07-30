
// Funções auxiliares

function OpenImage()
{
	$('#myModal').modal('show');	
}

function RemoveClick(id, name)
{
	$('#myModal').modal('show');
	$('#selData').attr('value', id);

	document.getElementById('selName').innerHTML = name;
}

function AcceptSol(id, name)
{
	$('#acceptModal').modal('show');
	$('#selData2').attr('value', id);

	document.getElementById('selName2').innerHTML = name;
}

function RemoveArquivoClick(id, name, albumID)
{
	$('#myModal').modal('show');
	$('#selArquivo').attr('value', id);
	$('#AlbumID').attr('value', albumID);

	document.getElementById('selName').innerHTML = name;
}

function RemoveAlbumClick(id, name)
{
	$('#removeAlbum').modal('show');
	$('#selData').attr('value', id);

	document.getElementById('selAlbumName').innerHTML = name;
}

function AddAlbumClick(catID)
{
	$('#addAlbum').modal('show');
	$('#selCategoria').attr('value', catID);
}

function EditAlbumClick(catID, albumID, nome)
{
	$('#editAlbum').modal('show');
	$('#selAlbum').attr('value', albumID);
	$('#selCategoriaAlt').attr('value', catID);

	var elem = document.getElementById("ALB_NOME_ALT");
	elem.value = nome;
}

$('#categoriasTab a').click(function (e) {
  e.preventDefault();
  $(this).tab('show');
});


window.onload = function()
{
	value = (document.getElementById('selectedCategoria')).value;

	if (value < 0)
	{
		$('#categoriasTab a:first').tab('show'); // Select first tab
	}
	else
	{
		$('#categoriasTab #'+ value).tab('show'); // Select correct tab
	}
};
