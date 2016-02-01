<?php
include("session.php");
include("header.php");
//to make password recovery possible, the users table needs an extra column called "token",
//to hold temporary password until user confirms by clicking a password reset link
?>
<main class="main">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <h4>Please type your email address</h4>
                <p>We will send a link to reset your password</p>
                <form id="forgot-password-form">
                    <label for="forgot-password-email"></label>
                    <input id="forgot-password-email" name="forgot-password-email"
                    class="form-control">
                    <button class="btn btn-default">Send password reset email</button>
                </form>
                <div class="alert"></div>
            </div>
        </div>
    </div>
</main>
<?php
include("footer.php");
?>
<script src="scripts/forgot-password.js"></script>
</body>
</html>