<?php
include("header.php");
if($_SESSION["token"]==$_POST["token"]){
    //check if the hidden form field is filled (spam)
    //if it is not filled, then get the rest of the form values
   if(!$_POST["number"]){
       $to = "johannes.muljana@ait.nsw.edu.au";
       $name = $_POST["name"];
       $email = $_POST["email"];
       $subject = $_POST["subject"];
       $message = $_POST["message"];
       //set headers
       $headers = "MIME-Version: 1.0" . "\r\n";
       $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
       // More header
       $headers .= 'From: <store@c9.io>' . "\r\n";
       $message_body = 
       "<p>$name has sent you an email with a subject of $subject</p>
       <p>the message is:<br>
       $message
       </p>
       <p>You can reply by writing to $email</p>";
       $message_subject = "Contact Form at c9 store";
       mail($to,$message_subject,$message_body,$headers);
   }
}
else{
    die();
}
?>