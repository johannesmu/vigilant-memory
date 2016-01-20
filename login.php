<?php
include("header.php");
include("session.php");
//check if user is logged in
?>
<main class="main">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3 panel">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" 
                    class="active">
                        <a href="#login" aria-controls="home" role="tab" data-toggle="tab">
                            Login
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#register" aria-controls="home" role="tab" data-toggle="tab">
                            Register
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="login">
                        <h2>Login</h2>
                        <form id="login-form" class="login-form">
                            <label for="user-name">User Name</label>
                            <input name="user-name" 
                                id="user-name" 
                                type="text" 
                                class="form-control" 
                                placeholder="User Name">
                            <label for="user-password">Password</label>
                            <input name="user-password" 
                                id="user-password" 
                                type="password" 
                                class="form-control" 
                                placeholder="Password">
                            <br>
                            <button class="btn btn-default" role="submit">Sign In</button>
                            <p>
                                <br>
                                Don't have an account? You can <a  data-toggle="tab" href="#register">register</a>
                                <br>
                                
                            </p>
                        </form>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="register">
                        <h2 id="register">Register</h2>
                        <form id="register-form" class="register-form">
                            <h4>Your Name</h4>
                            <label for="reg-first-name">First Name</label>
                            <input name="reg-first-name" 
                                id="reg-first-name" 
                                type="text" 
                                class="form-control" 
                                placeholder="First Name">
                            <label for="reg-last-name">Last Name</label>
                            <input name="reg-last-name" 
                                id="reg-last-name" 
                                type="text" 
                                class="form-control" 
                                placeholder="Last Name">
                            <h4>Account Details</h4>
                            <label for="reg-user-name">User Name</label>
                            <input name="reg-user-name" 
                                id="reg-last-name" 
                                type="text" 
                                class="form-control" 
                                placeholder="User Name">
                            <label for="reg-user-password">Password</label>
                            <input name="reg-user-password" 
                                id="reg-user-password" 
                                type="password" 
                                class="form-control" 
                                placeholder="Password">
                            <label for="reg-user-password2">Repeat Password</label>
                            <input name="reg-user-password2" 
                                id="reg-user-password2" 
                                type="password" 
                                class="form-control" 
                                placeholder="Repeat Password">
                            <label for="reg-user-password2">Repeat Password</label>
                            <input name="reg-user-password2" 
                                id="reg-user-password2" 
                                type="password" 
                                class="form-control" 
                                placeholder="Repeat Password">
                            <label for="reg-user-email">Email</label>
                            <input name="reg-user-email" 
                                id="reg-user-email" 
                                type="email" 
                                class="form-control" 
                                placeholder="Your Email">
                            <h4>Address</h4>
                            <div class="row">
                                <div class="col-sm-4">
                                    <label for="reg-appt-email">Appartment</label>
                                    <input name="reg-appt-number" 
                                        id="reg-appt-number" 
                                        type="text" 
                                        class="form-control" 
                                        placeholder="Unit">
                                </div>
                                <div class="col-sm-8">
                                    <label for="reg-street-number">Street Number</label>
                                    <input name="reg-street-number" 
                                        id="reg-street-number" 
                                        type="text" 
                                        class="form-control" 
                                        placeholder="Street Number">
                                </div>
                            </div>
                                <label for="reg-street-name">Street Name</label>
                                <input name="reg-street-name" 
                                    id="reg-street-name" 
                                    type="text" 
                                    class="form-control" 
                                    placeholder="Street Name">
                                <label for="reg-suburb">Suburb/Locality</label>
                                <input name="reg-suburb" 
                                    id="reg-suburb" 
                                    type="text" 
                                    class="form-control" 
                                    placeholder="Suburb or Locality">
                                <div class="row">
                                    <div class="col-md-8">
                                        <label for="reg-state">State</label>
                                        <input name="reg-state" 
                                            id="reg-state" 
                                            type="text" 
                                            class="form-control" 
                                            placeholder="State">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="reg-postcode">Postcode</label>
                                        <input name="reg-postcode" 
                                            id="reg-postcode" 
                                            type="text" 
                                            class="form-control" 
                                            placeholder="Postcode or Zip Code">
                                    </div>
                                </div>
                                <label for="reg-country">Country</label>
                                <input name="reg-country" 
                                    id="reg-country" 
                                    type="text" 
                                    class="form-control" 
                                    placeholder="Country">
                                    <br>
                            <button class="btn btn-default" role="submit">Register</button>
                            <br><br>
                            <p>Already have an account? <a  data-toggle="tab" href="#login">Sign in here</a></p>
                        </form>
                    </div>
                </div>
               
                
            </div>
        </div>
    </div>
</main>
<?php
include("footer.php");
?>
