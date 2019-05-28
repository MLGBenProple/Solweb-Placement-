$(function() {
        $('.error').hide();
        $(".register-btn").click(function() {
          
          $('.error').hide();
            var RegisterUsername = $("input#RegisterUsername").val(); 
            var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
              if (RegisterUsername == "") {
            $("label#RegisterUsername_error").show();
            $("input#RegisterUsername").focus();
            return false;
              }
            else{
                if (testEmail.test(RegisterUsername)){
                }
                else{
                    $("label#RegisterUsername_error2").show();
                    return false;
            }
          }
              var RegisterPassword = $("input#RegisterPassword").val();
              if (RegisterPassword == "") {
            $("label#RegisterPassword_error").show();
            $("input#RegisterPassword").focus();
            return false;
          }
              var ConfirmRegisterPassword = $("input#ConfirmRegisterPassword").val();
              if (ConfirmRegisterPassword == "") {
                    $("label#ConfirmRegisterPassword_error").show();
                    $("input#ConfirmRegisterPassword").focus();
                    return false;
                  }
          else{
            if (ConfirmRegisterPassword == RegisterPassword) {
            }
            else {
                $("label#ConfirmRegisterPassword_error2").show();
                $("input#ConfirmRegisterPassword").focus();
                return false;
            }
          }
         
          
          var dataString = 'registerusername='+ RegisterUsername + '&registerpassword=' + RegisterPassword + '&registerconfirmpassword=' + ConfirmRegisterPassword;
        //   alert (dataString);return false;
          $.ajax({
            type: "POST",
            url: "Scripts/process.php",
            data: dataString,
            success: function() {
              $('#register').html("<div id='message'></div>");
              $('#message').html("<h2>Account Created!</h2>")
              .append('<p class="message"><a href="login.php">Log in now</a></p>');
            }
          });
          return false;


        });
      });

      $(function() {
        $('.error').hide();
        $(".request-btn").click(function() { 
            var Username = $("input#Username").val();
            var dataString = 'username='+ Username;
        
              $.ajax({
                type: "POST",
                url: "Scripts/process.php",
                data: dataString,
                success: function() {
                  $('#forgottenPassword').html("<div id='message'></div>");
                  $('#message').html('<h2>A password reset Email has been sent to '+Username+' </h2>')
                  .append('<p class="backtologinmessage"><a href="login.php">Back to Log in</a></p>');
                }
              });
              return false;


        });
    });