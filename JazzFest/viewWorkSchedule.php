<?php
/**
 * Created by PhpStorm.
 * User: zach
 * Date: 4/20/16
 * Time: 10:41 PM
 */
displayNavBar();
viewSchedule();

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

//displays WorkSchedule table in an html table. Sorts by start time and uses htmlspecialchars()
function viewSchedule() {
        $host = "mysql.truman.edu";
        $dbname = "zbg2666CS315";
        $username = "zbg2666";
        $password = "theefato";

        try {
            $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

            $stmt = $db->query("
                SELECT WorkerName, Job, StartTime, EndTime
                FROM WorkSchedule
                ORDER BY StartTime");
            $stmt->setFetchMode(PDO::FETCH_ASSOC);

            echo<<<END
            <table>
                <tr>
                    <th>Worker Name</th>
                    <th>Job</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                </tr>
END;
            while ($row = $stmt->fetch()) {
                $workerName = htmlspecialchars($row['WorkerName']);
                $job = htmlspecialchars($row['Job']);
                $start = htmlspecialchars($row['StartTime']);
                $end = htmlspecialchars($row['EndTime']);

                echo<<<END
                <tr>
                    <td>$workerName</td>
                    <td>$job</td>
                    <td>$start</td>
                    <td>$end</td>
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