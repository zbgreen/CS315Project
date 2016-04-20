<?php
/**
 * Created by PhpStorm.
 * User: zach
 * Date: 3/22/16
 * Time: 11:31 PM
 */
displayNavBar();
process();

function displayNavBar() {
    echo<<<END
    <link rel="stylesheet" type="text/css" href="style.css">

    <div class="navigation">
    <ul>
        <li id="home"><a href="../home.html">Home</a></li>
        <li id="signUpLink"><a href="signUp.html">Sign Up</a></li>
        <li id="currentGuest"><a href="currentGuest.html">Guest Artist</a> </li>
        <li id="bandSched"><a href="schedule.html">Band Schedule</a></li>
        <li id="workSched"><a href="workSchedule.html">Work Schedule</a></li>
        <li id="previousFest"><a href="previousFestivals.html">Previous Festivals</a></li>
    </ul>
</div>
END;
}

function process() {
    echo "<h1>Jazz Fest Online Application</h1></br>";

    //assign checkbox variable.
    $email_me = false;
    if ( (isset($_POST['email_me'])) && ($_POST['email_me'] === "email_me") ) {
        $email_me = true;
    }
    //Form variables
    $form = ["school_name",
        "school_enrollment",
        "distance",
        "director",
        "address",
        "phone",
        "email",
        "ensemble_1",
        "ensemble_2",
        "ensemble_3",
        "ensemble_4",
        "ensemble_5",
        "combo_1",
        "combo_2",
        "combo_3",
        "combo_4",
        "combo_5"];

    $complete = reqFields($form);
    $bands = hasBands($form);

    //true if complete application.
    if ($complete && $bands) {
        printApp($form);
        insertIntoDB($form);
        //optional email confirmation
        if ($email_me) {
            sendEmail($form);
        }
    }
}

//Check if the field is empty.
function reqFields($form)
{
    $status = true;
    //loop through first 7 required fields
    for ($i = 0; $i <= 6; $i++) {
        //true if not set or empty
        if (!isset($_POST[$form[$i]]) || empty($_POST[$form[$i]])) {
            //if first missing field print out error header.
            if ($status) {
                echo <<<END
                    <h3>Missing field Notification</h3>
                    <p>You did not complete the following required field(s):</p>
END;
                $status = false;
            }
            echo "<p>$form[$i]</p>";
        }
    }
    return $status;
}

//Make sure schools have at least 1 band.
function hasBands($form) {
    $status = false;

    for ($i = 7; $i < count($form); $i++) {
        if (!empty($_POST[$form[$i]])) {
            $status = true;
        }
    }
    if (!$status) {
        echo <<<END
            <h3>Missing Band Notification</h3>
            <p>You have not signed up any bands.</p>
END;
    }
    return $status;
}

//Prints entered information to the user. Uses htmlspecialchars to prevent injections.
function printApp($form) {
    echo "<h3>Application Confirmation</h3>";
    echo "<a href='bandList.php'>View band list</a>";

    for ($i = 0; $i < count($form); $i++) {
        $fieldName = $form[$i];
        $field = htmlspecialchars($_POST[$form[$i]]);
        if (!empty($field)) {
            echo "<p>$fieldName: $field</p>";
        }
    }
}

//Inserts row for each band from a school.
function insertIntoDB($form) {
    $bandList = getBands($form);

    $host = "mysql.truman.edu";
    $dbname = "zbg2666CS315";
    $username = "zbg2666";
    $password = "theefato";

    try {
        $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

        foreach ($bandList as $band) {
            $stmt = $db->prepare("
            INSERT INTO BandList(SchoolName, SchoolEnrollment, Distance, Director, Address, Phone, Email, Band)
            VALUES (:SchoolName, :SchoolEnrollment, :Distance, :Director, :Address, :Phone, :Email, :Band)");

            $stmt->bindValue(":SchoolName", $_POST[$form[0]]);
            $stmt->bindValue(":SchoolEnrollment", $_POST[$form[1]]);
            $stmt->bindValue(":Distance", $_POST[$form[2]]);
            $stmt->bindValue(":Director", $_POST[$form[3]]);
            $stmt->bindValue(":Address", $_POST[$form[4]]);
            $stmt->bindValue(":Phone", $_POST[$form[5]]);
            $stmt->bindValue(":Email", $_POST[$form[6]]);
            $stmt->bindValue(":Band", $band);

            $stmt->execute();
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    $db = null;
}

//Finds number of bands to determine number of rows to insert
function getBands($form) {
    $bandList = array();

    for ($i = 7; $i < count($form); $i++) {
        if (!empty($_POST[$form[$i]])) {
            array_push($bandList, $_POST[$form[$i]]);
        }
    }

    return $bandList;
}

//Sends email to entered address. Uses htmlspecialchars to prevent injections.
function sendEmail($form) {
    $address = $_POST[$form[7]];
    $subject = "JazzFest Application Confirmation";
    echo "<p>Email Status: </p>";
    //construct message
    $message = "";
    for ($i = 0; $i < count($form); $i++) {
        $field = htmlspecialchars($_POST[$form[$i]]);
        if (!empty($field)) {
            $message .= $form[$i] . ": " . $field . "\r\n";
        }
    }
    $success = mail($address, $subject, $message);
    if ($success) {
        echo "<h3>Email sent.</h3>";
    }
    else {
        echo "<h3>Email failed to send. Contact administrator.</h3>";
    }
}
?>