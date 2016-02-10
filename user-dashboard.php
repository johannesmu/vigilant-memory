<?php
include("session.php");
include("header.php");
include("searchbar.php");

//check if user is logged in, otherwise redirect to home

$redirectto = "index.php";
if($_SESSION["user"]==false){
    header('Location: '.$redirectto);
    //die means stop processing
    die();
}
//get user account details sent from user-data.js
$userid = $_SESSION["user"]["id"];
$accountquery = "SELECT * FROM users WHERE id='$userid'";
?>
<main class="main" role="main">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h2>Account Details
                    <!--Show this spinner during update (see user-data.js)-->
                    <img class="spinner user-info-spinner" src="images/spinner.png">
                </h2>
                <div class="alert"></div>
                <form id="user-info">
               
                    <input name="user-id" id="user-id" type="hidden">
                    <!--make user name read only-->
                <div class="form-group">
                    <label for="user-name" >User Name</label>
                    <input name="user-name" id="user-name" class="form-control" type="text" readonly>
                </div>
                <div class="form-group">
                    <label for="user-password">Password</label>
                    <input name="user-password" id="user-password" class="form-control" type="password" readonly>
                </div>
                    <h4>Change your password</h4>
                <div class="form-group">
                    <label for="user-new-password">New Password</label>
                    <input name="user-new-password" 
                    id="user-new-password" 
                    class="form-control new-password" 
                    type="password"
                    placeholder="change your password">
                </div>
                <div class="form-group">
                    <label for="user-new-password2">Repeat New Password</label>
                    <input name="user-new-password2" 
                    id="user-new-password2" 
                    class="form-control new-password" 
                    type="password"
                    placeholder="retype your new password">
                </div>
                    <div class="alert password-alert"></div>
                <div class="form-group">
                    <label for="user-email">User Email</label>
                    <input name="user-email" id="user-email" class="form-control" type="text">
                </div>
                    <h4>Please add your shipping information</h4>
                <div class="form-group">
                    <label for="user-first">First Name</label>
                    <input name="user-first" id="user-first" class="form-control" type="text">
                </div>
                <div class="form-group">
                    <label for="user-last">Last Name</label>
                    <input name="user-last" id="user-last" class="form-control" type="text">
                </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="apt-number">Unit</label>
                                <input name="apt-number" id="apt-number" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="street-number">Number</label>
                                <input name="street-number" id="street-number" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="street-name">Street Name</label>
                                <input name="street-name" id="street-name" class="form-control" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="suburb">Suburb</label>
                                <input name="suburb" id="suburb" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="state">State</label>
                                <input name="state" id="state" class="form-control" type="text">
                            </div>
                        </div>
                         <div class="col-md-3">
                            <div class="form-group">
                                <label for="postcode">Postcode</label>
                                <input name="postcode" id="postcode" class="form-control" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="country">Country</label>
                                <input name="country" id="country" class="form-control" type="text">
                            </div>
                        </div>
                    </div>
                <div class="row">
                    <div class="col-md-3 col-xs-4">
                        <button class="btn btn-default" role=submit type="submit">
                            Update My Info
                        </button>
                    </div>
                    <div class="col-md-1">
                        <!--this spinner is to show during update sequence-->
                        <img class="spinner user-update-spinner" src="images/spinner.png">
                    </div>
                </div>
                </form>
                <br>
                <div class="alert update-alert"></div>
            </div>
            <div class="col-md-6">
                <h2>Wishlist</h2>
                <div class="wishlist-list"></div>
            </div>
        </div>
    </div>
</main>
<?php include("footer.php"); ?>
<script src="scripts/user-data.js"></script>
</body>
</html>