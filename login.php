<?php include("sessions.php");
handleSession();
include("db_functions.php");
handleCookies();
?>
<?php
checkHTTPS();

$pwd_pattern = '/.*[a-z].*[A-Z0-9].*|.*[A-Z0-9].*[a-z].*/';
$usr_pattern = '/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,7}/';
$correct = 0;

if(isset($_REQUEST['username']) && !empty($_REQUEST['username'])) {
    $user = $_REQUEST['username'];
    if(!preg_match($usr_pattern, $user)) {//controllo del formato lato server
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
    else {//se il formato è corretto anche lato server, mi connetto al db
        $correct = 1;
        $conn = dbConnect();
        if(!$conn) {
            completePage("Couldn't connect to the database!", "index.php","home");
            exit;
        }

        $user = sanitizeString($conn, $user);
        //$pwd = sanitizeString($conn, $pwd); non devo fare la sanitize sulla pwd, perché potrebbe eliminare dei caratteri
        $res = mysqli_query($conn, "SELECT * FROM users WHERE username='$user'");
    
        if($res) {
            $nrows=mysqli_num_rows($res);
            if($nrows == 0) {
                header('HTTPS/1.1 307 temporary redirect');
                header('Location: login.php?new=true');//setto new uguale a true, tramite get e questo mi lancia il messaggio di utente non trovato
            }
            else {
                $row = mysqli_fetch_array($res);
                if(md5($pwd) == $row["password"]) {
                    handleSession();

                    $_SESSION["username_aloumora"] = $user;
              
                    header('HTTPS/1.1 307 temporary redirect');
                    if (isset($_SESSION["reserve_aloumora"]))
                        header('Location: reserve.php?');
                    else
                        header('Location: index.php');
                    exit;
                }
                else {
                    header('HTTPS/1.1 307 temporary redirect');
                    header('Location: login.php?wrong=true');//setto wrong uguale a true, tramite get e questo mi lancia il messaggio di pwd sbagliata
                }
            }
        }
        else {
            completePage("Error in reading the database", "login.php", "login");
            exit;
        }

    }
}?>
<!DOCTYPE html>
<head>
    <link rel="stylesheet" href="style.css">
    <script src="functions.js"></script>
    <title>Flight seat reservation system</title>
</head>
<body>
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
                    echo "<li><a class='selected' href='login.php'>Login</a></li>";
                ?>
                <!--<li><a href="reserve.php">Book</a></li>-->
            </ul>
        </nav>
    </aside>

    <article class="sectionCentered">
        <h1>Login</h1>
        <noscript> <div class='isa_warning'><i class='warning'></i>JavaScript is not enabled. Functionalities may be reduced.<br></div></noscript>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" target="_self">
            <?php
            if(isset($_REQUEST["new"]) && $_REQUEST["new"] == true) {
                echo "<div class='isa_error'><i class='error'></i>Sorry! We couldn't find an account associated with this email address.<br></div>";
            }
            if(isset($_REQUEST["wrong"]) && $_REQUEST["wrong"] == true) {
                echo "<div class='isa_error'><i class='error'></i>Entered password is not correct.<br></div>";
            }
            ?>

            <p> Username: </p>
            <input type="text" name="username" id="username" onkeyup="setTimeout(checkUser, 600);" title="valid email address" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,7}" required>
            <p> Password: </p>
            <input type="password" name="password" id="password" onkeyup="setTimeout(checkPwd, 600);" title="should contain at least a lowercase letter and an uppercase letter or a figure" pattern=".*[a-z].*[A-Z0-9].*|.*[A-Z0-9].*[a-z].*" required>
            <input type="checkbox" onclick="togglePassword()"> <p style="display: inline">Show Password</p>
            <br>
            <input id="enter" type="submit" value="Enter">

        </form>
        <p style="display: inline">Se non hai ancora un account, puoi registrarti qui! </p>
        <a href="register.php"><button>Register</button></a>
    </article>

    <footer>Flight seat reservation system - Alice Morano aloumora@studenti.polito.it - 2019</footer>

</div>

</body>