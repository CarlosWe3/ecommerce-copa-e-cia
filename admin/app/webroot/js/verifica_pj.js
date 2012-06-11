/**
 * @author Guilherme Lessa - 11/06/12 16:00
 * @param valor(inteiro) - numero passado no select
 * descricao: funcão que verifica qual tipo de pessoa foi selecionado
 * 			  se nao foi selecionado jurídica o input de cnpj some
 */
function verifica_pj(valor) {
	if(valor != 2) {
		$('#cnpj').fadeOut(300);
	} else {
		$('#cnpj').fadeIn(300);
	}
}