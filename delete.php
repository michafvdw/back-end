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
//Require music data & image helpers to use variable in this file
/** @var mysqli $db */
require_once "database_connect.php";

if (isset($_POST['submit'])) {
    // DELETE IMAGE
    // To remove the image we need to query the file name from the db.
    // Get the record from the database result
    $query = "SELECT * FROM formData WHERE id = " . mysqli_escape_string($db, $_POST['id']);
    $result = mysqli_query($db, $query) or die ('Error: ' . $query );

    $album = mysqli_fetch_assoc($result);


    // DELETE DATA
    // Remove the album data from the database
    $query = "DELETE FROM formData WHERE id = " . mysqli_escape_string($db, $_POST['id']);

    mysqli_query($db, $query) or die ('Error: '.mysqli_error($db));

    //Close connection
    mysqli_close($db);

    //Redirect to homepage after deletion & exit script
    header("Location: showData.php");
    exit;

} else if(isset($_GET['id'])) {
    //Retrieve the GET parameter from the 'Super global'
    $albumId = $_GET['id'];

    //Get the record from the database result
    $query = "SELECT * FROM formData WHERE id = " . mysqli_escape_string($db, $albumId);
    $result = mysqli_query($db, $query) or die ('Error: ' . $query );

    if(mysqli_num_rows($result) == 1)
    {
        $dataForm = mysqli_fetch_assoc($result);
    }
    else {
        // redirect when db returns no result
        header('Location: showData.php');
        exit;
    }
} else {
    // Id was not present in the url OR the form was not submitted

    // redirect to index.php
    header('Location: showData.php');
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="layout.css">
    <title>Delete - <?= $dataForm['nameChild'] ?></title>
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
<h2>Delete - <?= $dataForm['nameChild'] ?></h2>
<form action="" method="post">
    <p>
        Weet u zeker dat u het album "<?= $dataForm['nameChild']?>" wilt verwijderen?
    </p>
    <input type="hidden" name="id" value="<?= $dataForm['id'] ?>"/>
    <input type="submit" name="submit" value="Verwijderen"/>
</form>
    </article>
    <footer><h3>Website gemaakt door Micha van der Willigen voor Marianne Prooij</h3></footer>

    <!-- Slide Show -->
    <script type="text/javascript" src="http://localhost/prg02/CLE2/html_css_layout/slideshow.js"></script>

    <!-- Submit reserveringen on event -->
    <script type="text/javascript" src="localhost/prg02/CLE2/html_css_layout/submitOnEvent.js"></script>
</div>
</body>
</html>
