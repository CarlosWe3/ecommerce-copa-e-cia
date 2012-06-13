//fção que só deixa o usuário digitar numeros
function input_int(valor){
	valor.value = valor.value.replace(/\D/g,'');
}