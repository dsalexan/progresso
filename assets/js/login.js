$(document).ready(function(){
    
$('.ui.form')
  .form({
    fields: {
      username: {
        identifier: 'username',
        rules: [
          {
            type   : 'empty',
            prompt : 'Por favor informe um usuário'
          }
        ]
      },
      password: {
        identifier: 'password',
        rules: [
          {
            type   : 'empty',
            prompt : 'Por favor informe uma senha'
          }
        ]
      }
    }
  });

});