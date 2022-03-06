<?php include 'sessions.php';
handleSession()?>
<?php

if (isset($_COOKIE['firstCookie']) && $_COOKIE['firstCookie']=='init') {
    //enabled
    $_SESSION['loadcount_aloumora']++;
    //echo "<p>".$_SESSION["loadcount_aloumora"]."</p>";
    header("Location: index.php");
}
else {
    //disabled
    $_SESSION["loadcount_aloumora"] = 0;
    //echo $_SESSION["loadcount_aloumora"]."<br>";
    //se hai sbloccato i cookies, torna sull'index (prova ogni 10 secondi)
    header('Refresh: 10; index.php');



}

?>

<!DOCTYPE html>


<head>
    <link rel="stylesheet" href="style.css">
    <title>Flight seat reservation system</title>
</head>
<body>

<div class="container">

    <header class="grad">
        <h1>Flight seat reservation system</h1>
    </header>

    <!--<aside>
        <nav>
            <ul>
                <li><a>Home</a></li>
                <li><a>Login</a></li>

            </ul>
        </nav>
    </aside>-->

    <article>
        <h4><div class="isa_warning">Cookies are not enabled: you can't navigate this site.<br></div></h4>

    </article>

    <footer>Flight reservation system - Alice Morano aloumora@studenti.polito.it - 2019</footer>

</div>

</body>
</html>