//to be used to update the wishlist
//this script needs wishlist.php and should be included in a page
//that has a wishlist button
$(document).ready(function(){
    //create badge element to add to the wishlist link
    var wbadge = "&nbsp;<span class='badge'>0</span>";
    //attach a click listener to all buttons with class wish-button
    //if userid does not exist, hide all the wish buttons
    //userid is created as a javascript variable in header.php when user is logged in
    if(typeof userid=="undefined"){
        $(".wish-button").hide();
    }
    else{
        //when the user is logged in, get the user's wishlist
        //add the badge to the wishlist link
        $(".wishlist a").append(wbadge);
        var id=userid;
        //set data request to server and set action to "get" (read wishlist.php)
        var datarequest = {"userid":id,"token":token,"action":"get"};
        //send data to the server
        
        $.ajax({
            type: "POST",
            url: "wishlist.php",
            data: datarequest,
            dataType: "json",
            encode: true,
            beforeSend:function(){
               //do something to indicate loading 
               //console.log(datarequest);
            }
        })
        .done(function(data){
            if(data.success){
                //if data is returned, update the count of items
                //of the wishlist in navigation
                try{
                    //try to read length of wishlist
                    updateWishlistNumber(data.result.length);
                }
                catch(error){
                    updateWishlistNumber(0);
                }
                //for updating user dashboard
                updateDashboard(data);
                
            }
            else{
                //console.log(data.message);
            }
        })
        .fail(function(error){
           //do something with the error
        })
        .always(function(data){
        });
        //when wishlist button is clicked
        $(".wish-button").click(function(event){
            //create a reference to the alert div
            var alertbox = $(event.target).parents(".product").find(".alert");
            //get id of the button clicked
            var productid = $(this).data("id");
            var uid = userid;
            var usertoken = token;
            var trigger = event;
            var wishdata = {"userid":uid,"productid":productid,"token":usertoken,"action":"set"};
            //spinner element to be added while sending data
            var spinner = "<img class='spinner' src='images/spinner.png'>";
            //send data to server
            $.ajax({
                type: "POST",
                url: "wishlist.php",
                data: wishdata,
                dataType: "json",
                encode: true,
                beforeSend:function(){
                    var boughtproduct = $(trigger.target).parents(".product-buttons");
                    boughtproduct.append(spinner);
                    boughtproduct
                    .find(".spinner")
                    .show()
                    .css("animation-play-state","running");
                }
            })
            .done(function(data){
                if(data.success){
                    //console.log(data);
                    //update the wishlist count
                    updateWishlistNumber(data.total);
                    //show the alertbox
                    alertbox.show();
                    alertbox.addClass("alert-success")
                    .html(data.message);
                    //remove the alert message after a certain time
                   setTimeout(function(){
                       alertbox.empty();
                       alertbox.hide();
                       alertbox.removeClass("alert-info");
                   },4000);
                }
                else{
                    alertbox.show();
                    alertbox.addClass("alert-info")
                    .html(data.error.message);
                    //remove the alert message after a certain time
                   setTimeout(function(){
                       alertbox.empty();
                       alertbox.hide();
                       alertbox.removeClass("alert-info");
                   },4000);
                }
            })
            .fail(function(data){
                //console.log(data);
            })
            .always(function(){
                var boughtproduct = $(trigger.target).parents(".product-buttons");
                boughtproduct
                .find(".spinner")
                .remove();
            });
        });
    }
});

//functions
function updateWishlistNumber(num){
    $(".wishlist .badge").html(num);
}

//function to update user dashboard
function updateDashboard(data){
    if(data.result.length>0 && data.result.length != "undefined"){
        var length = data.result.length;
        var i=0;
        for(i=0;i<length;i++){
            var obj = JSON.parse(data.result[i]);
            var element = "<div class='wishlist-item'>"
            +"<h3>"+obj.name+"</h3>"
            +"<div class='wishlist-item-info'>"
                +"<div class='wishlist-item-image'>"
                    +"<a href='productview.php?id="+obj.id+"'>"
                    +"<img class='responsive-image' src='products/"+obj.image+"'>"
                    +"</a>"
                +"</div>"
                +"<div class='wishlist-item-price'>"
                    +"<span class='price'>"+obj.sellprice+"</span>"
                +"</div>"
                +"<div class='wishlist-action product-buttons'>"
                    +"<button class='btn btn-default buy-button' data-id='"+obj.id+"'>Buy It</button>"
                    +"<button class='btn btn-default wishlist-remove-button' data-id='"+obj.id+"'>&times;</button>"
                +"</div>"
            +"</div>";
            $(".wishlist-list").append(element);
        }
    }
    else{
        var message = "<h1 class='empty-sign'>Stare into the emptiness</h1>"
        $(".wishlist-list").append(message);
    }
    //after adding the wishlist content to the user dashboard,
    //add listener for click on the delete button
    $(".buy-button").on("click",function(event){
        var id = $(event.target).data("id");
        var qty = 1;
        var buydata = {"id":id,"quantity":qty,"action":"add","token":token};
        //this function is in shopping-cart.js
        updateCart(event,buydata);
    });
    //when remove button is clicked, remove item from wishlist
    $(".wishlist-remove-button").on("click",function(event){
        var id = $(event.target).data("id");
        removeItemFromWishlist(event,id);
    });
}

function removeItemFromWishlist(event,productid){
    //create data to send to server
    var deletedata = {"userid":userid,"productid":productid,"action":"remove","token":token};
    $.ajax({
        type: "POST",
        url: "wishlist.php",
        data: deletedata,
        dataType: "json",
        encode: true,
        beforeSend:function(){
            var spinner = "<img class='spinner' src='images/spinner.png'>";
            $(event.target).parents(".product-buttons").append(spinner);
            $(event.target).parents(".product-buttons")
            .find(".spinner")
            .show()
            .css("animation-play-state","running");
        }
    })
    .done(function(data){
        if(data.success){
            $(event.target).parents(".wishlist-item").remove();
            updateWishlistNumber(data.result);
        }
    });
}