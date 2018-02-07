$(document).ready(function(){
    
$('.ui.form')
  .form({
    fields: {
      username: {
        identifier: 'username_login',
        rules: [
          {
            type   : 'empty',
            prompt : 'Por favor informe um usuário'
          }
        ]
      },
      password: {
        identifier: 'password_login',
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