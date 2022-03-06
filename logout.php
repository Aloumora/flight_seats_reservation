<?php include("sessions.php");
handleSession();
include("db_functions.php");
handleCookies();
?>
<?php
$_SESSION=array();
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time()-3600*24,
        $params["path"],$params["domain"], $params["secure"], $params["httponly"]);
}
session_destroy();
?>
<!DOCTYPE html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Flight Reservation System</title>
</head>
<body>
<section class="container">

    <header class="grad">
        <h1>Flight Reservation System</h1>
    </header>
    <aside>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <?php
                if(userLoggedIn())
                    echo "<li><a class='selected' href='logout.php'>Logout</a></li>";
                else
                    echo "<li><a href='login.php'>Login</a></li>";
                ?>
                <!--<li><a href="reserve.php">Book</a></li>-->
            </ul>
        </nav>
    </aside>

    <article class="sectionCentered">
        <h1>Logout</h1>
        <noscript> <div class='isa_warning'><i class='warning'></i>JavaScript is not enabled. Functionalities may be reduced.<br></div></noscript>
        <h4><div class="isa_success">Logout completed successfully!</div></h4>
        <p>Go back to the <a href="index.php">home page</a></p>
    </article>

</section>

    <footer>Flight reservation system - Alice Morano aloumora@studenti.polito.it - 2019</footer>



</body>
</html>