$(document).ready(function(){
   $("#register-form").submit(function(event){
       //clear all error messages
       $(".error").removeClass("error");
       $(".alert").empty().removeClass("alert-danger");
       //stop the page from loading another page
       event.preventDefault();
       //collect data from the form
       //also add the token generated for this session
       //which is added via header.php in the <script> tag
       var formdata = {
           "user-name" : $("#reg-user-name").val(),
           "user-password" : $("#reg-user-password").val(),
           "user-email" : $("#reg-user-email").val(),
           "user-token" : token
       }
       //we send data to the server
       $.ajax({
           type: "POST",
           url: "user-register.php",
           data: formdata,
           dataType: "json",
           encode: true
       })
       .done(function(data){
           console.log(data);
           //$(".register-msg").html("tested");
           //if the submit was not successfull, eg data.success is not equal true
          if(!data.success){
              //if there is an error with user name
              //check .form-control.error in the css
              if(data.errors.name){
                  $("#reg-user-name").addClass("error");
                  $(".user-name-alert").addClass("alert-danger");
                  $(".user-name-alert").html(data.errors.name);
              }
              if(data.errors.password){
                  $("#reg-user-password").addClass("error");
                  $(".password-alert").addClass("alert-danger");
                  $(".password-alert").html(data.errors.password);
              }
              if(data.errors.email){
                  $("#reg-user-email").addClass("error");
                  $(".email-alert").addClass("alert-danger");
                  $(".email-alert").html(data.errors.email);
              }
          }
          //if submit was successful, we show message  of success
          else if(data.success){
             $(".success-message").addClass("alert-success");
             $(".success-message").html(data.message);
          }
       })
       .fail(function(data){
           console.log(data);
       });
   }); 
});