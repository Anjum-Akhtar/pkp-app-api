<?php
    
    if(isset($_POST['fname']) && $_POST['fname'] != '' && isset($_POST['lname']) && $_POST['lname'] && isset($_POST['phone']) && $_POST['phone'] && isset($_POST['email']) && $_POST['email'] && isset($_POST['msg']) && $_POST['msg']){
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $msg = $_POST['msg'];
        
        // Email settings
        $to = 'sweetangelanjum115@gmail.com'; // Change this to your email address
        $subject = 'Get In Touch Submission';
        $body = "Name: $fname $lname\n\nPhone: $phone\n\nEmail: $email\n\nMessage: $msg";
    
        // Send email
        if (mail($to, $subject, $body)) {
            echo '<p class="green-text accent-4">Thank you for contacting us. We will get back to you soon!</p>';
        } else {
            echo '<p class="red-text">Sorry, there was an error sending your message. Please try again later.</p>';
        }
    } else {
        // If the form is not submitted, redirect to the contact form page
        header("Location: index.php");
        exit;
    }
?>