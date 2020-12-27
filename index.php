<!-- eindversie met html en php reserveringssysteem -->


<?php
//Check if Post isset, else do nothing

if (isset($_POST['submit'])) {
    //Require database in this file & image helpers
    require_once "database_connect.php";


    //Postback with the data showed to the user, first retrieve data from 'Super global'
    $nameTeacher   = mysqli_escape_string($db, $_POST['nameTeacher']);
    $nameChild = mysqli_escape_string($db, $_POST['nameChild']);
    $email  = mysqli_escape_string($db, $_POST['email']);
    $ageYear   = mysqli_escape_string($db, $_POST['ageYear']);
    $ageMonth   = mysqli_escape_string($db, $_POST['ageMonth']);
    $date = date("Y-m-d", strtotime($_POST['date']));
    $comment = mysqli_escape_string($db, $_POST['comment']);
    $date2 = strval($date);


    //Require the form validation handling
    require_once "form_validation.php";



    if (empty($errors)) {

        //Save the record to the database
        $query = "INSERT INTO formData (nameTeacher, nameChild, email, ageYear, ageMonth, date, comment)
                  VALUES ('$nameTeacher', '$nameChild', '$email', $ageYear,$ageMonth, $date2, '$comment')";
        $result = mysqli_query($db, $query)
        or die('Error: '.$query);

        if ($result) {
            header('Location: showData.php');
            exit;
        } else {
            $errors[] = 'Something went wrong in your database query: ' . mysqli_error($db);
        }

        //Close connection
        mysqli_close($db);
    }
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

<!-- content linkse column -->
<div class="row">
    <div class="leftcolumn">
        <div class="content">
            <h2>Plaats uw reservering</h2>

            <!-- formulier reserveren -->
            <form action="" method="post" enctype="multipart/form-data">
                <div class="fcf-form-group">
                    <label for="nameTeacher" class="fcf-label">Naam docent:</label>
                    <input id="nameTeacher" class="fcf-form-control" type="text" name="nameTeacher" value="<?= isset($nameTeacher) ? htmlentities($nameTeacher) : '' ?>"/>
                    <span class="errors"><?= isset($errors['nameTeacher']) ? $errors['nameTeacher'] : '' ?></span>
                </div>
                <div class="fcf-form-group">
                    <label for="nameChild" class="fcf-label">Naam leerling</label>
                    <input id="nameChild" class="fcf-form-control" type="text" name="nameChild" value="<?= isset($nameChild) ? htmlentities($nameChild) : '' ?>"/>
                    <span class="errors"><?= isset($errors['nameChild']) ? $errors['nameChild'] : '' ?></span>
                </div>
                <div class="fcf-form-group">
                    <label for="email" class="fcf-label">Email:</label>
                    <input id="email" class="fcf-form-control" type="text" name="email" value="<?= isset($email) ? htmlentities($email) : '' ?>"/>
                    <span class="errors"><?= isset($errors['email']) ? $errors['email'] : '' ?></span>
                </div>
                <div class="fcf-form-group">
                    <label for="ageYear" class="fcf-label">Leeftijd van de leerling in jaren:</label>
                    <input id="ageYear" class="fcf-form-control" type="number" name="ageYear" value="<?= isset($ageYear) ? htmlentities($ageYear) : '' ?>"/>
                    <span class="errors"><?= isset($errors['ageYear']) ? $errors['ageYear'] : '' ?></span>
                    <label for="ageMonth">en in maanden:</label>
                    <input id="ageMonth" class="fcf-form-control" type="number" name="ageMonth" value="<?= isset($ageMonth) ? htmlentities($ageMonth) : '' ?>"/>
                    <span class="errors"><?= isset($errors['ageMonth']) ? $errors['ageMonth'] : '' ?></span>
                </div>
                <div class="fcf-form-group">
                    <label for="date" class="fcf-label">Datum:</label>
                    <input id="date" class="fcf-form-control" type="date" name="date" value="<?= isset($date) ? htmlentities($date) : '' ?>"/>
                    <span class="errors"><?= isset($errors['date']) ? $errors['date'] : '' ?></span>
                </div>
                <div class="fcf-form-group">
                    <label for="comment"  class="fcf-label">Extra toevoeging (optioneel):</label>
                    <input id="comment" class="fcf-form-control" type="text" name="comment" value="<?= isset($comment) ? htmlentities($comment) : '' ?>"/>
                </div>
                <div class="data-submit">
                    <input type="submit" class="fcf-btn fcf-btn-primary fcf-btn-lg fcf-btn-block" name="submit" value="Reservering plaatsen"/>
                </div>
            </form>
        </div>

    </div>

    <!-- content rechtste column -->
    <div class="rightcolumn">
        <div class="content">
            <h2>Over mij</h2>
            <p>Mijn naam is Marianne Prooij. Ik ben een logopediste in opleiding, werkzaam op een basisschool.
                Via deze website kunt u contact opnemen met mij en reserveringen plaatsen voor uw leerlingen.</p>
        </div>
        <div class="content">
            <h3>Vragen? Stuur mij gerust een email</h3>

            <!-- email sturen form -->

            <form id="fcf-form-id" class="fcf-form-class" method="post" action="contact-form-process.php">

                <div class="fcf-form-group">
                    <label for="Name" class="fcf-label">Your name</label>
                    <div class="fcf-input-group">
                        <input type="text" id="Name" name="Name" class="fcf-form-control" required>
                    </div>
                </div>

                <div class="fcf-form-group">
                    <label for="Email" class="fcf-label">Your email address</label>
                    <div class="fcf-input-group">
                        <input type="email" id="Email" name="Email" class="fcf-form-control" required>
                    </div>
                </div>

                <div class="fcf-form-group">
                    <label for="Message" class="fcf-label">Your message</label>
                    <div class="fcf-input-group">
                        <textarea id="Message" name="Message" class="fcf-form-control" rows="6" maxlength="3000" required></textarea>
                    </div>
                </div>

                <div class="fcf-form-group">
                    <button type="submit" id="fcf-button" class="fcf-btn fcf-btn-primary fcf-btn-lg fcf-btn-block">Send Message</button>
                </div>

            </form>

        </div>
    </div>
</div>

<!-- footer -->
<div class="footer">
    <h2>Website gemaakt door Micha van der Willigen</h2>
</div>

</body>
</html>