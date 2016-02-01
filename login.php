<?php
include("session.php");
include("header.php");

?>
<main class="main">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3 panel">
                <!--presenting registration and login forms in tabs-->
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
                        </form>
                        <div class="alert login-message"></div>
                        <div class="form-meta">
                            Don't have an account? You can <a  data-toggle="tab" href="#register">register</a>
                        </div>
                        <div class="form-meta">
                            <a href="user-forgot-password.php">I forgot my password, cuz</a>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="register">
                        <h2>Join Bag Love</h2>
                        <form id="register-form" class="register-form">
                            <label for="reg-user-name">User Name</label>
                            <input name="reg-user-name" 
                                id="reg-user-name" 
                                type="text" 
                                class="form-control" 
                                placeholder="User Name">
                            <!--to alert user in case of error-->
                            <div class="alert user-name-alert alert-dismissable"></div>
                            <label for="reg-user-password">Password</label>
                            <input name="reg-user-password" 
                                id="reg-user-password" 
                                type="password" 
                                class="form-control" 
                                placeholder="Password">
                            <!--to alert user in case of error-->
                            <div class="alert password-alert"></div>
                            <label for="reg-user-email">Email</label>
                            <input name="reg-user-email" 
                                id="reg-user-email" 
                                type="email" 
                                class="form-control" 
                                placeholder="Your Email">
                            <!--to alert user in case of error-->
                            <div class="alert email-alert"></div>
                            <br>
                            <button class="btn btn-default" role="submit">Register</button>
                            <br><br>
                            <p>Already have an account? <a  data-toggle="tab" href="#login">Sign in here</a></p>
                        </form>
                        <div class="alert success-message"></div>
                        </div>
                    </div>
                </div>
               
                
            </div>
        </div>
   
</main>
<?php
include("footer.php");
?>
