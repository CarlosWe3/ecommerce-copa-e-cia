/*
 * declare o formato de dados de cada classe para o plugin masked input formatar os valores inseridos nos inputs
 */
jQuery(function($){
   $(".rg").mask("99.999.999-9");
   $(".cpf").mask("999.999.999-99");
   $(".cnpj").mask("99.999.999/9999-99");
   $(".tel").mask("(99) 9999-9999");
   $(".dat").mask("99/99/9999");
   $(".cep").mask("99999-999");
   $(".dimensoes").mask("9,99 mt");
   $(".peso").mask("9,999 kg");
});