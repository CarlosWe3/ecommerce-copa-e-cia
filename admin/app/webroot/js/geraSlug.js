/**
 * @author Guilherme Lessa - 20/06/12 10:10
 * descricao: função simples para gerar o slug de acordo com a palavra passada no evento onkeydown 
 * 			  slug não tem caracteres expecias ou espaços, somente letras e minúsculas
 * @param string value - palavra que será formatada gerando o slug
 * 
 */
function geraSlug(value){
	/*
	acentos = value.replace('ã', 'a');
	
	arr = new Array('ã', 'á');	//caracteres a asubstituir
	for (i=0; i<arr.length;i++) {
		if (value == arr[i]) {
			
	    }
	}
	*/
	string = value.replace(/\W/g, "-"); //substitui caracteres especias e espaços por line
	minusculo = string.toLowerCase(); //transforma tudo em letras minusculas
	$('.campoSlug').val(minusculo);
}