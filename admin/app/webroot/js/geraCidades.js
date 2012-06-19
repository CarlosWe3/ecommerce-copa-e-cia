/**
 * @author Guilherme Lessa - 15/06/12 10:00
 * descricao: funç ajax que gera as cidades de acordo com o estado selecionado 
 */
function geraCidades(url,estado) {
	
	$.post(url, {
		cod_estado: estado
	}, function(retorno) {
		$('#cidades').html(retorno);
	});		
}
