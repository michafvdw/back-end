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
//Require database in this file & image helpers
/** @var mysqli $db */
require_once "database_connect.php";


//Check if Post isset, else do nothing
if (isset($_POST['submit'])) {
    //Postback with the data showed to the user, first retrieve data from 'Super global'
    $id = mysqli_escape_string($db, $_POST['id']);
    $nameTeacher   = mysqli_escape_string($db, $_POST['nameTeacher']);
    $nameChild = mysqli_escape_string($db, $_POST['nameChild']);
    $email  = mysqli_escape_string($db, $_POST['email']);
    $ageYear   = mysqli_escape_string($db, $_POST['ageYear']);
    $ageMonth   = mysqli_escape_string($db, $_POST['ageMonth']);
    $date = date("Y-m-d", strtotime($_POST['date']));
    $comment = mysqli_escape_string($db, $_POST['comment']);

    //Require the form validation handling
    require_once "form_validation.php";

    //Save variables to array so the form won't break
    //This array is build the same way as the db result
    $dataForm = [
        'nameTeacher' => $nameTeacher,
        'nameChild' => $nameChild,
        'ageYear' => $ageYear,
        'ageMonth' => $ageMonth,
        'date' => $date,
        'email' => $email,
        'comment' => $comment,
    ];

    if (empty($errors)) {

        //Update the record in the database
        $query = "UPDATE formData
                  SET name = '$nameChild', nameTeacher = '$nameTeacher', nameChild = '$nameChild', ageYear = '$ageYear', ageMonth = '$ageMonth', date = '$date', email = '$email', comment = '$comment'
                  WHERE id = '$id'";
        $result = mysqli_query($db, $query);


        if ($result) {
            header('Location: index.php');
            exit;
        } else {
            $errors[] = 'Something went wrong in your database query: ' . mysqli_error($db);
            echo "<h2>something went very ve wrong</h2>";
        }

    }
} else if (isset($_GET['id'])) {
    //Retrieve the GET parameter from the 'Super global'
    $id = $_GET['id'];

    //Get the record from the database result
    $query = "SELECT * FROM formData WHERE id = " . mysqli_escape_string($db, $id);
    $result = mysqli_query($db, $query);
    if (mysqli_num_rows($result) == 1) {
        $dataForm = mysqli_fetch_assoc($result);
    } else {
        // redirect when db returns no result
        header('Location: showData2.php');
        exit;
    }
} else {
    header('Location: showData2.php');
    exit;
}

//Close connection
mysqli_close($db);
?>
<!doctype html>
<html lang="en">
<head>
    <title>Music Collection Edit</title>
    <meta charset="utf-8"/>
    <!-- CSS -->
    <link rel="stylesheet" href="layout.css">
</head>
<body>
<div class="wrapper">
<header>
    <h1>Reserveren Logopedie afspraken</h1>
    <!-- images below header -->
    <section>
        <img class="mySlides" src="https://www.logopedietoon.nl/content/Pagina%20headers/wat%20is%20logopedie.jpg" style="width:100%;height:200px;">
        <img class="mySlides" src="https://www.malouavenhuis.nl/wp-content/uploads/Header21.jpg" style="width:100%;height:200px;">
    </section>
</header>

<nav>
    <a href="index.php">Reserveren</a>
    <a href="login.php">Login (admin only)</a>
    <a href="logout.php">uitloggen</a>
    <a href="showData.php">Overzicht database</a>
</nav>
<article class="main">
<h1>Edit "<?= htmlentities($dataForm['nameChild']) . ' - ' . htmlentities($dataForm['nameTeacher']) ?>"</h1>

<form action="" method="post" enctype="multipart/form-data">
    <div class="data-field">
        <label for="nameTeacher">Naam docent</label>
        <input id="nameTeacher" type="text" name="nameTeacher" value="<?= htmlentities($dataForm['nameTeacher']) ?>"/>
        <span class="errors"><?= isset($errors['nameTeacher']) ? $errors['nameTeacher'] : '' ?></span>
    </div>
    <div class="data-field">
        <label for="nameChild">Naam kind</label>
        <input id="nameChild" type="text" name="nameChild" value="<?= htmlentities($dataForm['nameChild']) ?>"/>
        <span class="errors"><?= isset($errors['nameChild']) ? $errors['nameChild'] : '' ?></span>
    </div>
    <div class="data-field">
        <label for="ageYear">Leeftijd in jaren</label>
        <input id="ageYear" type="number" name="ageYear" value="<?= htmlentities($dataForm['ageYear']) ?>"/>
        <span class="errors"><?= isset($errors['ageYear']) ? $errors['ageYear'] : '' ?></span>
    </div>
    <div class="data-field">
        <label for="ageMonth">en maanden</label>
        <input id="ageMonth" type="number" name="ageMonth" value="<?= htmlentities($dataForm['ageMonth']) ?>"/>
        <span class="errors"><?= isset($errors['ageMonth']) ? $errors['ageMonth'] : '' ?></span>
    </div>
    <div class="data-field">
        <label for="date">Datum</label>
        <input id="date" type="date" name="date" value="<?= htmlentities($dataForm['date']) ?>"/>
        <span class="errors"><?= isset($errors['date']) ? $errors['date'] : '' ?></span>
    </div>
    <div class="data-field">
        <label for="email">Email</label>
        <input id="email" type="text" name="email" value="<?= htmlentities($dataForm['email']) ?>"/>
        <span class="errors"><?= isset($errors['email']) ? $errors['email'] : '' ?></span>
    </div>
    <div class="data-field">
        <label for="comment">Comment</label>
        <input id="comment" type="text" name="comment" value="<?= htmlentities($dataForm['comment']) ?>"/>
        <span class="errors"><?= isset($errors['comment']) ? $errors['comment'] : '' ?></span>
    </div>
    <div class="data-submit">
        <input type="hidden" name="id" value="<?= $id ?>"/>
        <input type="submit" name="submit" value="Save"/>
    </div>
</form>
    <a href="formData2.php">Go back to the list</a>

</article>

<footer><h3>Website gemaakt door Micha van der Willigen voor Marianne Prooij</h3></footer>

<!-- Slide Show -->
<script type="text/javascript" src="http://localhost/prg02/CLE2/html_css_layout/slideshow.js"></script>

<!-- Submit reserveringen on event -->
<script type="text/javascript" src="localhost/prg02/CLE2/html_css_layout/submitOnEvent.js"></script>
</div>
</body>
</html>
