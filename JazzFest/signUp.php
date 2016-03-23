<?php
/**
 * Created by PhpStorm.
 * User: zach
 * Date: 3/22/16
 * Time: 11:31 PM
 */

//Form variables
$form = array("School name" => $_POST["school_name"],
    "School enrollment" => $_POST["school_enrollment"],
    "Distance from Kirksville" => $_POST["distance"],
    "Name of director(s)" => $_POST["director_name"],
    "Contact address" => $_POST["address"],
    "Phone" => $_POST["phone"],
    "Fax" => $_POST["fax"],
    "E-mail" => $_POST["email"],
    "E-mail me" => $_POST["email_me"],
    "Ensemble 1" => $_POST["ensemble_1"],
    "Ensemble 2" => $_POST["ensemble_2"],
    "Ensemble 3" => $_POST["ensemble_3"],
    "Ensemble 4" => $_POST["ensemble_4"],
    "Ensemble 5" => $_POST["ensemble_5"],
    "Combo 1" => $_POST["combo_1"],
    "Combo 2" => $_POST["combo_2"],
    "Combo 3" => $_POST["combo_3"],
    "Combo 4" => $_POST["combo_4"],
    "Combo 5" => $_POST["combo_5"]);

process($form);

function process($form) {
    $field = checkBlanks($form);
    if ($field !== false) {
        printError($field);
    } else {
        printApp($form);
    }
}

//Check if any of the fields were left blank.
function checkBlanks($form) {
    $field = null;

    for ($i = 0; $i <= 7; $i++) {
        if ($form[$i] === "") {
            $field = $i;
        }
    }
    //If a field is blank return the field name
    if ($field !== null) {
        return key($form);
    } else {
        return false;
    }
}

//Prints out the field name that wasn't filled out.
function printError($field) {
    echo <<<END
    <h1>Jazz Fest Online Application</h1>
    <h3>Application Error Notification</h3>
    <p>You did not complete the $field field.</p>
END;
}

function printApp($form) {
    echo <<<END
    <h1>Jazz Fest Online Application</h1>
    <h3>School and Director Information</h3>
    <table>
END;

    for ($i = 0; $i <= 8; $i++) {
        $key = key($form);
        $field = $form[$i];
        echo "<tr><td>$key</td><td>$field</td></tr>";
    }
}
?>