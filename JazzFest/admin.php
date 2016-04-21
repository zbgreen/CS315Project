<?php
/**
 * Created by PhpStorm.
 * User: Brendan Andres
 * Date: 3/23/2016
 */

process();

//function to call correct feature.
function process() {
    if (!empty($_POST['subject'])) {
        sendEmails();
    }
}

//sends emails to all directors' emails from BandList table
function sendEmails() {
    $host = "mysql.truman.edu";
    $dbname = "zbg2666CS315";
    $username = "zbg2666";
    $password = "theefato";

    try {
        $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

        $stmt = $db->query("
            SELECT Email
            FROM BandList");
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $stmt->fetch()) {
            $address = $row['Email'];
            $success = mail($address, $_POST['subject'], $_POST['message']);

            if ($success) {
                echo "<p>Message to $address was successful</p>";
            } else {
                echo "<p>Message to $address was unsuccessful</p>";
            }
        }
    } catch (PDOException $e) {
        $e->getMessage();
    }
    $db = null;
}