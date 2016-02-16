//include this script wherever there is a need to update and show the shopping cart
//eg in index.php, store.php and productview.php
//add "badge" (number showing item total in cart)to shopping cart on navbar when page loads
var badge = "&nbsp;<span class='badge'>0</span>";
var spinner = "<img class='spinner' src='images/spinner.png'>";
//create variable to track clicking to stop multiple clicks
//when adding to cart
var submitting = false;
$(document).ready(function(){
    
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
            //set submitting to false
            submitting = false;
            //create a reference to the product buttons element
            var boughtproduct = $(trigger.target).parents(".product-buttons");
            //find the spinner in it and remove it
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

//function to list items in the shopping cart (in viewshoppingcart.php)
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
            //create an element to render the shopping cart
            var i=0;
            for(i=0;i<data.result.length;i++){
                var cartobj = JSON.parse(data.result[i]);
                var price;
                var special;
                if(cartobj.specialprice!=0){
                    price = cartobj.specialprice;
                    special = true;
                }
                else{
                    price = cartobj.sellprice;
                    special = false;
                }
                var cartrow ="<div class='cart-row' id='"+cartobj.id+"'>"
                            +"<a href='productview.php?id="+cartobj.id+"'>"
                            +"<div class='cart-item-image' data-id='"+cartobj.id+"'>"
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
                            +"<input type='number' class='item-quantity form-control' name='quantity' value='"+cartobj.quantity+"' data-id='"+cartobj.id+"'>"
                            +"</div>"
                            +"<button class='btn btn-default cart-item-remove'>&times;</button>"
                            +"</div>";
                
                $(".cart-list").append(cartrow);
                if(special){
                    var select = "#"+cartobj.id+" .cart-item-price";
                    $(select).addClass("special");
                }
            //end of for loop
            }
            var totalrow = "<div class='cart-total'>Total Price: "
                            +"<span class='price'>"+data.totalprice
                            +"</div>";
            var buttonrow = "<div class='cart-buttons'></div>";
            var emptycart = "<button class='btn btn-warning cart-empty'>Empty Cart</button>";
            var checkout = "<button class='btn btn-success cart-checkout'>Check Out</button>";
            if(data.result.length>0){
                $(".cart-list").append(totalrow);
                $(".cart-list").append(buttonrow);
                $(".cart-buttons").append(emptycart);
                 $(".cart-buttons").append(checkout);
                 addEmptyCartListener();
            }
            else{
                showEmpty(".cart-list");
            }
            //add listener for changes to quantity
            $(".item-quantity").change(function(event){
                //get which row changed
                var itemid = $(this).data("id");
                var quantity = $(this).val();
                //construct data to send
                var updatedata = {"id":itemid,"quantity":quantity,"token":token,"action":"update"};
                //send data to server to update quantity
            });
            //add listener to the delete button(s)
            addDeleteListener(".cart-item-remove");
        }
    });
   
}
function addDeleteListener(selector){
    $(selector).on("click",function(event){
        var id = $(this).parents(".cart-row").attr("id");
        //construct data to send to server
        var deletedata = {"id":id,"action":"delete","token":token};
        $.ajax({
        type: "POST",
        url: "shoppingcart.php",
        data: deletedata,
        dataType: "json",
        encode: true,
        //we use beforeSend to show loading spinner
        beforeSend:function(){
            $(event.target).html(spinner);
            $(event.target).find(".spinner").show().css("animation-play-state","running");
          }
        })
        .done(function(data){
            console.log(data);
            $(event.target).parents(".cart-row").remove();
            //$(event.target).parents(".cart-row").remove();
            updateCartNumber(data.length);
            updateCartTotal(data.totalprice);
            if(data.length==0){
                $(".cart-total").hide();
                showEmpty(".cart-list");
            }
        });
    });
}
function emptyCart(){
    var emptydata = {"token":token,"action":"empty"};
    $.ajax({
        type: "POST",
        url: "shoppingcart.php",
        data: emptydata,
        dataType: "json",
        encode: true,
        //we use beforeSend to show loading spinner
        beforeSend:function(){
            $(event.target).append(spinner);
            $(event.target).find(".spinner").show().css("animation-play-state","running");
          }
        })
        .done(function(data){
            if(data.success){
                $(".cart-row").remove();
                $(".cart-buttons").remove();
                $(".cart-total").hide();
                showCartItems();
                updateCartNumber(0);
                //showEmpty(".cart-list");
            }
        });
}
function addEmptyCartListener(){
    $(".cart-empty").on("click",function(){emptyCart();});
}
function updateCartTotal(amount){
    $(".cart-total").find(".price").html(amount);
}

function showEmpty(element){
    var empty = "<h3 class='empty-sign'>Stare into the emptiness</h3>";
    $(element).append(empty);
}