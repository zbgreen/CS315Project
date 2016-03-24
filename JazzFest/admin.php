<?php
/**
 * Created by PhpStorm.
 * User: Brendan Andres
 * Date: 3/23/2016
 */

sendEmails();

function sendEmails($directors) {
    $directors = [
        'zbg2666@truman.edu',
        'zbgreen7@gmail.com',
        'bsa6811@truman.edu',
        'bandres012@gmail.com',
        'csweb08@truman.edu'
    ];

    $subject = "Jazz Festival Update";
    echo "<p>Email Status: </p>";

    $message = "You're getting this email to update you on the date and schedule of Jazz Festival.";
    foreach ($directors as $value) {
        if(mail($value, $subject, $message)) {
            echo "<p>Email to $value was sent</p>";
        } else {
            echo "<p>Email to $value was not sent</p>";
        }
    }

}