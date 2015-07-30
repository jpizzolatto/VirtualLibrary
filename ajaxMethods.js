
//
// FUNÇÕES AUXILIZARES PARA AJAX
//

function SlideMarcas(action)
{
	// Verificando Browser
	if(window.XMLHttpRequest) {
		req_marcas = new XMLHttpRequest();
	} else if(window.ActiveXObject) {
		req_marcas = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	// Arquivo PHP juntamente com o valor digitado no campo (método GET)
	var url = "carregaMarcas.php?action=" + action;

	// Chamada do método open para processar a requisição
	req_marcas.open("Get", url, true);

	// Quando o objeto recebe o retorno, chamamos a seguinte função;
	req_marcas.onreadystatechange = function() {

		// Verifica se o Ajax realizou todas as operações corretamente
		if(req_marcas.readyState == 4 && req_marcas.status == 200) {

			// Resposta retornada pelo busca.php
			var resposta = req_marcas.responseText;
			
			// Abaixo colocamos a(s) resposta(s) na div resultado
			document.getElementById('marcas-lista').innerHTML = resposta;
		}
	};
	req_marcas.send(null);
}

function ChangePage(action, scope)
{
	// Verificando Browser
	if(window.XMLHttpRequest) {
		req_pages = new XMLHttpRequest();
	} else if(window.ActiveXObject) {
		req_pages = new ActiveXObject("Microsoft.XMLHTTP");
	}
		
	// Arquivo PHP juntamente com o valor digitado no campo (método GET)
	var url = "Paginas.php?action=" + action + "&scope=" + scope;

	// Chamada do método open para processar a requisição
	req_pages.open("Get", url, true);

	// Quando o objeto recebe o retorno, chamamos a seguinte função;
	req_pages.onreadystatechange = function() {

		// Verifica se o Ajax realizou todas as operações corretamente
		if(req_pages.readyState == 4 && req_pages.status == 200) {

			// Resposta retornada pelo busca.php
			var resposta = req_pages.responseText;
			
			ret = resposta.split("|");
			
			context = scope + "-lista"; 
			
			// Abaixo colocamos a(s) resposta(s) na div resultado
			document.getElementById(context).innerHTML = ret[0];
			document.getElementById('paginas-lista').innerHTML = ret[1];
		}
	};
	req_pages.send(null);
}
