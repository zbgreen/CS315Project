<?php
/**
 * Created by PhpStorm.
 * User: zach
 * Date: 4/20/16
 * Time: 1:44 PM
 */
displayNavBar();
fetchBands();

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

//fetches bands from DB and displays in an html table
function fetchBands() {
    $host = "mysql.truman.edu";
    $dbname = "zbg2666CS315";
    $username = "zbg2666";
    $password = "theefato";

    try {
        $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

        $stmt = $db->query("
            SELECT SchoolName, SchoolEnrollment, Distance, Director, Address, Phone, Email, Band
            FROM BandList");
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        echo<<<END
        <table>
            <tr>
                <th>School Name</th>
                <th>School Enrollment</th>
                <th>Distance</th>
                <th>Director</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Band</th>
            </tr>
END;

        while ($row = $stmt->fetch()) {
            $school = $row['SchoolName'];
            $enrollment = $row['SchoolEnrollment'];
            $distance = $row['Distance'];
            $director = $row['Director'];
            $address = $row['Address'];
            $phone = $row['Phone'];
            $email = $row['Email'];
            $band = $row['Band'];

            echo<<<END
            <tr>
                <td>$school</td>
                <td>$enrollment</td>
                <td>$distance</td>
                <td>$director</td>
                <td>$address</td>
                <td>$phone</td>
                <td>$email</td>
                <td>$band</td>
            </tr>
END;
        }
        echo "</table>";
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    $db = null;
}
?>