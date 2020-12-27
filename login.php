<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to page with shown reservations
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: showData.php");
    exit;
}

// Include config file
require_once "database_connect_users.php";

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;

                            // Redirect user to welcome page
                            header("location: showData.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
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
<!-- content website -->
<div class="content">
    <h2>Login</h2>
    <p>Please fill in your credentials to login, this feature is for admins only.</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
            <label>Username</label>
            <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
            <span class="help-block"><?php echo $username_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
            <label>Password</label>
            <input type="password" name="password" class="form-control">
            <span class="help-block"><?php echo $password_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Login">
        </div>
    </form>
</div>
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