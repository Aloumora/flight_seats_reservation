<?php include("sessions.php");
handleSession();
include("db_functions.php");
handleCookies();
?>

<!DOCTYPE html>
<head>
    <link rel="stylesheet" href="style.css">
    <script src="functions.js"></script>
    <title>Flight Reservation System</title>
</head>
<body>

<?php
checkHTTPS();
?>

<?php if(isset($_REQUEST["username"]) && !empty($_REQUEST["username"])) {
    $pwd_pattern = '/.*[a-z].*[A-Z0-9].*|.*[A-Z0-9].*[a-z].*/';
    $usr_pattern = '/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,7}/';
    $correct = 0;

    if(isset($_REQUEST['username']) && !empty($_REQUEST['username'])) {
        $user = $_REQUEST['username'];
        if(!preg_match($usr_pattern, $user)) {
            completePage("Username dev'essere un indirizzo mail valido.", "login.php", "login");
            exit;
        }
    }

    if(isset($_REQUEST['password']) && !empty($_REQUEST['password'])) {
        $pwd = $_REQUEST['password'];
        if(!preg_match($pwd_pattern, $pwd)) {
            completePage("La password deve contenere almeno un carattere alfabetico minuscolo e un altro carattere che sia alfabetico maiuscolo oppure un carattere numerico.",
                "login.php", "login");
            exit;
        }
        else {
            $correct = 1;
        }
    }

    if(isset($_REQUEST['confirm']) && !empty($_REQUEST['confirm']) && $correct==1) {
        $conf = $_REQUEST['confirm']; //è il secondo inserimento della pwd

        if (strcmp($pwd, $conf)) {
            completePage("La stessa password deve essere inserita due volte.",
                "login.php", "login");
            exit;
        }
        else {
            $conn = dbConnect();
            if(!$conn) {
                completePage("Couldn't connect to the database!", "index.php","home");
                exit;
            }

            $user = sanitizeString($conn, $user);
            //$pwd = sanitizeString($conn, $pwd); non devo sanitizzare la pwd
            //$conf = sanitizeString($conn, $conf);
            $hashed_pwd = md5($pwd); //NB deve essere fatto cosi'
            $res = mysqli_query($conn,"INSERT INTO users(Username, Password) VALUES ('$user', '$hashed_pwd')");
            $err = mysqli_errno($conn);
            if($err==1062 || $err==1586 || $err==1859)
                completePage("User already has an account", "register.php", "registration");
            elseif($res == FALSE) {
                header('HTTPS/1.1 307 temporary redirect');
                header('Location: register.php');
            }
            else {
                echo "new user inserted";
                handleSession();
                $_SESSION["username_aloumora"] = $user;
                header('HTTPS/1.1 307 temporary redirect');
                header('Location: index.php');
                exit;
            }
        }
    }
}

?>

<div class="container">

    <header class="grad">
        <h1>Flight Reservation System</h1>
    </header>

    <aside>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <?php
            if(userLoggedIn())
                echo "<li><a href='logout.php'>Logout</a></li>";
            else
                echo "<li><a href='login.php'>Login</a></li>";
            ?>
            <!--<li><a href="reserve.php">Book</a></li>-->
        </ul>
    </nav>
    </aside>

    <article class="sectionCentered">
        <h2>Register</h2>
        <noscript> <div class='isa_warning'><i class='warning'></i>JavaScript is not enabled. Functionalities may be reduced.<br></div></noscript>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" target="_self">
            <p> Username: </p>
            <input type="text" name="username" id="username" onkeyup="setTimeout(checkUser, 600);" title="valid email address" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,7}" required> <br>
            <p> Password: </p>
            <input type="password" name="password" id="password" onkeyup="setTimeout(checkPwd, 600);" title="should contain at least a lowercase letter and an uppercase letter or a figure" pattern=".*[a-z].*[A-Z0-9].*|.*[A-Z0-9].*[a-z].*" required>
            <input type="checkbox" onclick="togglePassword()"> <p style="display: inline">Show Password</p>
            <br>
            <p> Confirm password:</p>
            <input type="password" name="confirm" id="confirm" onkeyup="setTimeout(checkConf, 1000);" title="repeat the previously typed in password" pattern=".*[a-z].*[A-Z0-9].*|.*[A-Z0-9].*[a-z].*" required> <br>
            <br><br>
            <input id="enter" type="submit" value="Enter">
            <br><br>
        </form>
    </article>

    <footer>Flight reservation system - Alice Morano aloumora@studenti.polito.it - 2019</footer>

</div>

</body>
</html>