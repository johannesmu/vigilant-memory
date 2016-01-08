<?php
include("header.php");
?>
<main class="main">
    <div class="container">
        <div class="row">
            <div class="col-xs-6">
                <h2>Get In Touch</h2>
                <form id="contact-form" action="mail/mail.php" method="post">
                    <!--Name field-->
                    <div class="form-group">
                        <label for="name">Your Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Your Name">
                    </div>
                    <!--Email field-->
                    <div class="form-group">
                        <label for="email">Your Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Your Email">
                    </div>
                    <!--hidden fields-->
                    <!--Containing a spambot trap and a hidden field with the token-->
                    <div class="form-group">
                        <input type="text" class="no-show" name="number" id="number">
                        <input type="hidden" name="token" value="<?php echo $_SESSION["token"]?>">
                    </div>
                    <!--email field-->
                     <div class="form-group">
                        <label for="email">Subject</label>
                        <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject">
                    </div>
                    <!--the message-->
                     <div class="form-group">
                        <label for="message">Your Message</label>
                        <textarea id="message" class="form-control" name="message" rows="12" placeholder="Do Tell Us"></textarea>
                    </div>
                    <!--the buttons-->
                    <div class="form-group text-right">
                        <button type="reset" id="reset" class="btn btn-default">
                            <i class="glyphicon glyphicon-remove"></i> Clear Form
                        </button>
                        <button type="submit" id="submit" class="btn btn-default">
                            <i class="glyphicon glyphicon-envelope"></i> Send
                        </button>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</main>
        <?php include("footer.php"); ?>
    </body>
</html>