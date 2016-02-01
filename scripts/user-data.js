$(document).ready(function(){
    readUserData();
    var newpassword;
    function readUserData(){
        //get user data from db and fill form fields.
        //create user id in header as a json data
        var userdata = {"id":userid,"token":token,"action":"get"};
        $.ajax({
               type: "POST",
               url: "user-data-update.php",
               data: userdata,
               dataType: "json",
               encode: true,
               //we use beforeSend to show loading spinner
               beforeSend:function(){
                   $(".user-info-spinner").show().css("animation-play-state","running");
               }
        })
        //when ajax request completed
        .done(function(data){
            console.log(data);
            //if request successful
            if(data.success){
                //put data from server into form fields
                //when success hide spinner and stop animation (see .spinner in css file)
                $(".user-info-spinner").hide().css("animation-play-state","paused");
                $("#user-id").val(data.id);
                $("#user-name").val(data.name);
                $("#user-password").val(data.password);
                $("#user-email").val(data.email);
                if(!data.first){
                    $("#user-first").addClass("error");
                }
                $("#user-first").val(data.first);
                if(!data.last){
                    $("#user-last").addClass("error");
                }
                $("#user-last").val(data.last);
                if(!data.apartment){
                    $("#apt-number").addClass("error");
                }
                $("#apt-number").val(data.apartment);
                if(!data.streetnumber){
                    $("#street-number").addClass("error");
                }
                $("#street-number").val(data.streetnumber);
                //if data is empty, we add error class to highlight
                //the input box in red
                if(!data.streetname){
                    $("#street-name").addClass("error");
                }
                $("#street-name").val(data.streetname);
                if(!data.suburb){
                    $("#suburb").addClass("error");
                }
                $("#suburb").val(data.suburb);
                if(!data.state){
                    $("#state").addClass("error");
                }
                $("#state").val(data.state);
                if(!data.postcode){
                    $("#postcode").addClass("error");
                }
                $("#postcode").val(data.postcode);
                if(!data.country){
                    $("#country").addClass("error");
                }
                $("#country").val(data.country);
                //when form field is filled, remove error class
                $("#user-info input").blur(function(event){
                    if($(event.target).val()){
                        $(event.target).removeClass("error");
                    }
                    else{
                        $(event.target).addClass("error");
                    }
                });
                //check if two new passwords are the same when
                //the second field (#user-new-password2)loses focus
                $("#user-new-password2").blur(function(event){
                    // store new passwords in variables
                    newpass1 = $("#user-new-password").val();
                    newpass2 = $("#user-new-password2").val();
                    //if two new passwords are not blank and are not the same
                    if( newpass1!="" && newpass2!="" && newpass1!=newpass2 ){
                        $(".password-alert").html("password not equal!").addClass("alert-warning");
                        $(".new-password").addClass("error");
                    }
                    //if they are the same
                    else{
                        $(".new-password").removeClass("error");
                        clearAllAlerts();
                        newpassword = $("#user-new-password2").val();
                    }
                });
            }
        })
        .fail(function(error){
            //get error message
            $(".update-alert").addClass("alert-warning").html(error);
        });
    }
    //when form submitted, update user data.
    $("#user-info").submit(function(event){
        event.preventDefault();
        clearAllAlerts();
        //get all data from form
        var userformdata = {
            "id" : $("#user-id").val(),
            "user" : $("#user-name").val(),
            "password" : newpassword,
            "email" : $("#user-email").val(),
            "first" : $("#user-first").val(),
            "last" : $("#user-last").val(),
            "apartment" : $("#apt-number").val(),
            "number" : $("#street-number").val(),
            "street" : $("#street-name").val(),
            "suburb" : $("#suburb").val(),
            "state" : $("#state").val(),
            "postcode" : $("#postcode").val(),
            "country" : $("#country").val(),
            "token" : token,
            "action" : "set"
        }
        if(!newpassword){
            //if there is no new password, remove the password
            //from the data being sent to server so that it does not
            //cause the user password to be set to empty
            delete userformdata["password"];
        }
        console.log(userformdata);
        $.ajax({
               type: "POST",
               url: "user-data-update.php",
               data: userformdata,
               dataType: "json",
               encode: true,
               //show spinner before sending request
               beforeSend:function(){
                   $(".user-update-spinner").show().css("animation-play-state","running");
               }
        })
        .done(function(data){
            //hide spinner after response arrives
            $(".user-update-spinner").hide().css("animation-play-state","paused");
            if(data.success){
                $(".update-alert").addClass("alert-success").html("Update Successful!");
            }
            else{
                $(".update-alert").addClass("alert-warning").html("Something is up bro!");
            }
        })
        .fail(function(data){
            $(".update-alert").addClass("alert-warning").html("The update did not happen as it should!");
        });
    });
});

function clearAllAlerts(){
    $(".alert").removeClass("alert-warning").removeClass("alert-success");
    $(".alert").empty();
}