/**
 * @author Guilherme Lessa - 11/06/12 16:10
 * descricao: função simples para selecionar todos os selects laterais de uma tabela 
 * 			  com o clique de apenas um select pai
 */
function check(){
	$("input[name='check[]']").each(function() {
		if(!this.checked){
			$(this).attr("checked", "checked");
		}else{
			$(this).removeAttr("checked");
		}
	})
}