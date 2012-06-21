/*
Funções da API
alphanumeric – permite letras ou números
alpha – permite apenas letras
numeric – permite apenas números

Propriedades da API
allow – adiciona um grupo de caracteres que serão permitidos
ichars – define os caracteres que serão omitidos
allcaps – permite apenas caracteres em caixa alta
nocaps – permite apenas caracteres em caixa baixa
*/

//------------------------------------------------------
//$('.alphanumeric').alphanumeric();
$('.alpha').alpha({
	allow:", ",
	nocaps:true
});
//$('.numeric').numeric();
