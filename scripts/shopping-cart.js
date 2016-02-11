//include this script wherever there is a need to update and show the shopping cart
//eg in index.php, store.php and productview.php

//create variable to track clicking to stop multiple clicks
var submitting = false;
$(document).ready(function(){
    //add "badge" (number showing item total in cart)to shopping cart on navbar when page loads
    var badge = "&nbsp;<span class='badge'>0</span>";
    $(".shopping-cart a").append(badge);
    //get the existing cart and display the total items
    var cartdata = {"action":"get","token":token};
    getCartItems(cartdata);
    
    //when in viewshoppingcart.php, check if there is an element
    //with class of "cart-list"
    
        showCartItems();
    
    //listen for when the buy button is pressed
    //we give each buy button a class of "buy-button"
    $(".buy-button").on("click",function(event){
        //stop the click from performing default action
        event.preventDefault();
        //get the id of the product being bought from the data-id attribute
        //<button ... data-id="5">, etc
        var productid = $(this).data("id");
        //get the quantity being bought
        var quantity = $(this).siblings("select").val();
        //construct the data into a JSON string
        var buydata = {"id":productid,"quantity":quantity,"action":"set","token":token};
        //now send data to the server
        updateCart(event,buydata);
    });
});

function updateCart(trigger,item){
    //create a string used to add the spinner image
    var spinner = "<img class='spinner' src='images/spinner.png'>";
    if(!submitting){
        submitting = true;
        $.ajax({
               type: "POST",
               url: "shoppingcart.php",
               data: item,
               dataType: "json",
               encode: true,
               //we use beforeSend to show loading spinner
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
            console.log(data);
            var cart = JSON.parse(data.cart);
            var cartlength = cart.length;
            updateCartNumber(cartlength);
        })
        .fail(function(error){
            console.log(error);
        })
        .always(function(){
            submitting = false;
            var boughtproduct = $(trigger.target).parents(".product-buttons");
            boughtproduct
            .find(".spinner")
            .remove();
        });
    }
}

//function to update cart number
function updateCartNumber(num){
    $(".shopping-cart .badge").html(num);
}
//function to get items in the cart
function getCartItems(getdata){
    $.ajax({
           type: "POST",
           url: "shoppingcart.php",
           data: getdata,
           dataType: "json",
           encode: true,
           //we use beforeSend to show loading spinner
          beforeSend:function(){
              
          }
    })
    .done(function(data){
        //update cart when data has arrived
        var cart = JSON.parse(data.cart);
        var cartlength = cart.length;
        if(data.success){
            updateCartNumber(cartlength);
        }
    })
    .fail(function(error){
        
    })
    .always(function(){
        
    });
}

function showCartItems(){
    var listdata = {"action":"list","token":token};
    $.ajax({
        type: "POST",
        url: "shoppingcart.php",
        data: listdata,
        dataType: "json",
        encode: true,
        //we use beforeSend to show loading spinner
        beforeSend:function(){
          
      }
    })
    .done(function(data){
        if(data.success){
            console.log(data);
            //create an element to render the shopping cart
            
            var i=0;
            for(i=0;i<data.result.length;i++){
                var cartobj = JSON.parse(data.result[i]);
                var price;
                var priceclass;
                if(cartobj.specialprice!=0){
                    price = cartobj.specialprice;
                    priceclass = "special";
                }
                else{
                    price = cartobj.sellprice;
                    priceclass="";
                }
                var cartrow ="<div class='cart-row'>"
                            +"<a href='productview.php?id="+cartobj.id+"'>"
                            +"<div class='cart-item-image'>"
                                +"<img src='products/"+cartobj.image+"'>"
                            +"</div>"
                            +"</a>"
                            +"<div class='cart-item-name'>"
                                +"<h4>"+cartobj.name+"</h4>"
                            +"</div>"
                            +"<div class='cart-item-price price'>"
                                +price
                            +"</div>"
                            +"<div class='cart-item-qty'>"
                            +"<input type='number' class='form-control' name='quantity' value='"+cartobj.quantity+"'>"
                            +"</div>"
                            +"<button class='btn btn-default btn-warning cart-item-remove'>&times;</button>"
                            +"</div>";
                
                $(".cart-list").append(cartrow);
                if(priceclass=="special"){
                    $(".cart-item-price").addClass("special");
                }
            }
            var totalrow = "<div class='cart-total'>Total Price: "
                            +"<span class='price'>"+data.totalprice
                            +"</div>";
            $(".cart-list").append(totalrow);
        }
    });
}