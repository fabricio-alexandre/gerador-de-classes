$(document).on('click', '.btnClass.btnAdd', function(e){
  var conteudo = $('.modeloBoxTabela').html();
  $('.boxTabelas').append(conteudo);
});

$(document).on('click', '.btnClass.btnRemove', function(e){
  var conteudo = $(this).closest('fieldset');
  conteudo.remove();
});