<?php
/**
 * Created by PhpStorm.
 * User: zach
 * Date: 4/20/16
 * Time: 10:20 PM
 */
displayNavBar();
addWorker();

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

//Adds worker to schedule in the WorkSchedule table.
function addWorker() {
    $host = "mysql.truman.edu";
    $dbname = "zbg2666CS315";
    $username = "zbg2666";
    $password = "theefato";

    try {
        $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

        $stmt = $db->prepare("
          INSERT INTO WorkSchedule(WorkerName, Job, StartTime, EndTime)
          VALUES (:WorkerName, :Job, :StartTime, :EndTime)");

        $stmt->bindValue(":WorkerName", $_POST['worker']);
        $stmt->bindValue(":Job", $_POST['job']);
        $stmt->bindValue(":StartTime", $_POST['time-start']);
        $stmt->bindValue(":EndTime", $_POST['time-end']);

        $stmt->execute();
        echo "<a href='viewWorkSchedule.php'>View Work Schedule</a>";
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    $db = null;
}
?>