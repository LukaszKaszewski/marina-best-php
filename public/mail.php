<?php
//get data from form
$name = $_POST['name'];
$email= $_POST['email'];
$message= $_POST['message'];
$to = "service@marina-best.pl";
$subject = "contact marina-best";
$txt ="Imię: ". $name . "\nEmail: " . $email . "\nWiadomość:\n" . $message;
$headers = "From: noreply@marina-best.pl";
if($email!=NULL){
    mail($to,$subject,$txt,$headers);
    header("Location: https://marina-best.pl/emailtnx");
} else {
    //redirect no mail
    header("Location: https://marina-best.pl/emailfail");
}
?>