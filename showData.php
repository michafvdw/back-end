<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>

<?php
require_once "database_connect.php";
//Postback with the data showed to the user, first retrieve data from 'Super global'

if(isset($_POST['submit'])) {
    $nameTeacher   = mysqli_escape_string($db, $_POST['nameTeacher']);
    $nameChild = mysqli_escape_string($db, $_POST['nameChild']);
    $email  = mysqli_escape_string($db, $_POST['email']);
    $ageYear   = mysqli_escape_string($db, $_POST['ageYear']);
    $ageMonth   = mysqli_escape_string($db, $_POST['ageMonth']);
    $date = date("Y-m-d", strtotime($_POST['date']));
    $comment = mysqli_escape_string($db, $_POST['comment']);
    $date2 = strval($date);
}
?>

<!DOCTYPE html>
<html>
<head>

    <!-- CSS -->
    <link rel="stylesheet" href="endCss.css">

</head>
<body>

<div class="header">
    <h1>Reserveren Logopedie afspraken</h1>
    <!-- images below header -->
    <section>
        <img class="mySlides" src="https://www.logopedietoon.nl/content/Pagina%20headers/wat%20is%20logopedie.jpg" style="width:100%;height:200px;">
        <img class="mySlides" src="https://www.malouavenhuis.nl/wp-content/uploads/Header21.jpg" style="width:100%;height:200px;">
    </section>
</div>
<!-- Slide Show -->
<script type="text/javascript" src="http://localhost/prg02/CLE2/html_css_layout/slideshow.js"></script>

<!-- Submit reserveringen on event -->
<script type="text/javascript" src="localhost/prg02/CLE2/html_css_layout/submitOnEvent.js"></script>

<!-- top navigation bar -->
<div class="topnav">
    <a href="index.php">Reserveren</a>
    <a href="login.php">Login (admin only)</a>
    <a href="logout.php">uitloggen</a>
    <a href="showData.php">Overzicht database</a>
</div>
<div class="content">
    <br>
    <?php
    // Attempt select query execution
    $sql = "SELECT nameTeacher, nameChild, email, ageYear, ageMonth, date, comment FROM formData";
    if($result = mysqli_query($db, $sql)){
        if(mysqli_num_rows($result) > 0){
            echo "<table>";
            echo "<tr>";
            echo "<th>Naam docent</th>";
            echo "<th>Naam kind</th>";
            echo "<th>Email</th>";
            echo "<th>Leeftijd in jaren</th>";
            echo "<th>Leeftijd in maanden</th>";
            echo "<th>datum</th>";
            echo "<th>Comment</th>";
            echo "</tr>";
            while($row = mysqli_fetch_array($result)){
                echo "<tr>";
                echo "<td>" . $row['nameTeacher'] . "</td>";
                echo "<td>" . $row['nameChild'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['ageYear'] . "</td>";
                echo "<td>" . $row['ageMonth'] . "</td>";
                echo "<td>" . $row['date'] . "</td>";
                echo "<td>" . $row['comment'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
            // Free result set
            mysqli_free_result($result);
        } else{
            echo "No records matching your query were found.";
        }
    } else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($db);
    }

    // Close connection
    mysqli_close($db);
    ?> </div>
<div>
    <a href="index.php">Go back to the list</a>
</div>
<!-- footer -->
<div class="footer">
    <h2>Website gemaakt door Micha van der Willigen</h2>
</div>
</body>

</html>
