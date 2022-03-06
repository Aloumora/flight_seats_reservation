<?php include("sessions.php");
handleSession();
include("db_functions.php");
handleCookies();
?>

<!DOCTYPE html>
    <head>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="style_map.css">
        <script src="functions.js"></script>
    <script src="jquerymin.1.6.1.js"></script>


    <title>Flight seat reservation system</title>
    </head>
<body>



    <div class="container">

        <header class="grad">
            <h1>Flight seat reservation system</h1>
        </header>
        <aside>
            <div class="containerMenu">
            <nav>
                <ul>
                <?php
                if(userLoggedIn()) {
                    echo "<li><a href='logout.php'>Logout</a></li>";
                }
                else {
                    echo "<li><a class=\"selected\" href=\"index.php\">Home</a></li>
                            <li><a href='login.php'>Login</a></li>";


                }
                ?></ul>

            </nav>
            </div>
            <div class="containerMenu">

            <article>
                <?php
                    if(userLoggedIn()) {
                        echo "<h1>Benvenuto, " . $_SESSION["username_aloumora"] . "!</h1>
                                <script>
                                     var _redirectTimeout = 1200 * 1000; // timeout di 120 secondi
                                    var _redirectUrl = 'sessionExpired.php'; // login URL
                                    var _redirectHandle = null;
                                    resetRedirect(_redirectHandle, _redirectUrl, _redirectTimeout);
                                </script>";

                    }
                    else {
                        echo "<h1>Benvenuto! Per prenotare un posto puoi loggarti o registrarti!</h1>";


                    }
                    echo "<noscript> <div class='isa_warning'><i class='warning'></i>JavaScript is not enabled. Functionalities may be reduced.<br></div></noscript>";

                    $conn = dbConnect();
                    if(!$conn) {
                        dbErrorInArticle("Couldn't connect to the database");
                        exit;
                    }

                    $res = mysqli_query($conn, "SELECT * FROM map");
                    if($res) {
                        $rows = mysqli_num_rows($res);
                        echo "<p>Numero posti totale: $rows</p>";
                    }
                    else {
                        dbErrorInArticle("Error reading from the database");
                        exit;
                    }
                    $acquistati = mysqli_query($conn, "SELECT * FROM map WHERE status='A'");
                    $Nacq = mysqli_num_rows($acquistati);
                    $prenotati = mysqli_query($conn, "SELECT * FROM map WHERE status='P'");
                    $Npren = mysqli_num_rows($prenotati);
                    $liberi = mysqli_query($conn, "SELECT * FROM map WHERE status='F'");
                    $Nlib = mysqli_num_rows($liberi);
                    /*echo "<p>Numero posti acquistati: $Nacq</p>";
                    echo "<p>Numero posti prenotati: $Npren</p>";
                    echo "<p>Numero posti liberi: $Nlib</p>";

                    $Npren = $_SESSION["prenotatiDaTe_259158"] + $_SESSION["prenotatiDaAltri_259158"];
                    $Nacq = $_SESSION["postiAcquistati_259158"];
                    $Nlib = $_SESSION["postiLiberi_259158"];*/

                    echo "<p id='output'>Numero posti prenotati: $Npren<br> <br>
                            Numero posti acquistati: $Nacq<br> <br>
                            Numero posti liberi: $Nlib</p>";

                if(userLoggedIn()) {
                    echo "<button id='btnAggiorna' onclick='window.location.reload();'>Aggiorna</button>";
                    echo "<button id='btnAcquista' onclick='handleAcquista()'>Acquista</button>";
                }

                    ?>




            </article>
            </div>
            <!--<footer>Flight reservation system - Alice Morano aloumora@studenti.polito.it - 2019</footer>-->

        </aside>

        <section class="sectionCentered">
            <?php
            /*if(userLoggedIn())
                echo "<h1>Benvenuto, ".$_SESSION["username_aloumora"]."!</h1>";
            else {
                echo "<h1>Benvenuto! Per prenotare un posto puoi loggarti o registrarti!</h1>";


            }*/

            echo "<noscript> <div class='isa_warning'><i class='warning'></i>JavaScript is not enabled. Functionalities may be reduced.<br></div></noscript>";

            /*$conn = dbConnect();
            if(!$conn) {
                dbErrorInArticle("Couldn't connect to the database");
                exit;
            }

            $res = mysqli_query($conn, "SELECT * FROM map");
            if($res)
                $rows = mysqli_num_rows($res);
            else {
                dbErrorInArticle("Error reading from the database");
                exit;
            }*/

            /*foreach($res as $seat){
                $s ='O';
                $s = mysqli_query($conn, "SELECT status FROM map WHERE seat=$seat");
                if (!$s) {
                    echo 'Could not run query: ' . mysql_error();
                    exit;
                }
                if($s=='F'){
                    echo "<li class=\"seat\">
                            <input type=\"checkbox\" id=\"$seat\" style=\"background: blue;\"/>
                            <label for=\"$seat\">$seat</label>
                          </li>";
                }
            }*/

            /*if ($rows == 0){
                echo "<div class='isa_info'>It looks like no one has booked a trip yet!</div><br>To be the first one, click <a href='reserve.php'>here</a></section>";
                echo "<footer>Flight reservation system - Alice Morano aloumora@studenti.polito.it - 2019</footer>";
                echo "</div></body></html>";
                exit;
            }
            else {*/
                //echo "<h3>Mappa posti aereo</h3>";
                    $_SESSION["prenotatiDaTe_259158"]=0;
                    $_SESSION["prenotatiDaAltri_259158"]=0;
                    $_SESSION["postiLiberi_259158"]=0;
                    $_SESSION["postiAcquistati_259158"]=0;


                        echo"<div class=\"plane\">
                        <div class=\"cockpit\">
                            <h1>Mappa posti</h1>
                        </div>
                        <div class=\"exit exit--front fuselage\">
                    
                        </div>
                        <ol class=\"cabin fuselage\">";

                    for ($i = 0; $i < $rows; $i++) {
                        $resto=$i%6;
                        if($resto==0){
                            if($i>0){
                                //se c'e' una riga precedente, chiudo la riga precedente
                                echo"</ol>";
                                echo"</li>";
                            }
                            //per aprire una nuova riga
                            echo"<li class=\"row row--1\">";//da cambiare numero riga
                            echo"<ol class=\"seats\" type=\"A\">";
                        }
                        $map = mysqli_fetch_array($res);
                        $seat = $map["seat"];
                        $color = "";
                        if($map["status"]=="A"){//acquired
                            $color = "red";
                            $_SESSION["postiAcquistati_259158"]++;
                        }
                        if($map["status"]=="F"){//free
                            $color = "green";
                            $_SESSION["postiLiberi_259158"]++;
                        }
                        if($map["status"]=="P"){//booked
                            if(userLoggedIn() && $map["user"]==$_SESSION['username_aloumora']){
                                $color = "yellow";
                                $_SESSION["prenotatiDaTe_259158"]++;
                            }
                            else{
                                $color = "orange";
                                $_SESSION["prenotatiDaAltri_259158"]++;
                            }

                        }
                        $seatL=$seat;//imposto la variabile per la label, che mi serve poi per eliminare lo 0 in testa
                        if($seat<"10A"){
                            $seatL= substr($seat,1,2);//mi serve per eliminare lo 0 iniziale dalla label
                        }
                        echo"<li class=\"seat\">
                            <input type=\"checkbox\" id=\"$seat\" onclick='handleClick(this);'";
                        if(!userLoggedIn() || $map["status"]=="A")
                            echo" disabled ";//rende non cliccabili se l'utente non e' loggato o se il posto è acquistato
                        echo"/>
                            <label class=\"$color\" id=\"L$seat\" for=\"$seat\" >$seatL</label>
                            </li>";//questa è una label per il checkbox (dicitura for) con id $seat


                    }
                echo"</ol>";
                echo"</li>";
                echo"</ol>";
                echo"<div class=\"exit exit--back fuselage\">";
                echo"</div>";
                echo"</div>";
                //}

                /*echo"<section class=\"info\">
                <h3>qui vado poi a scrivere tot posti</h3>
            </section>";*/






                echo "</section>";
                //echo prenotatiDaTe();
                //$p = prenotatiDaTe();//NON VA BENE devi prendere questo valore da ajax (già l'hai preso in output)

                /*$Npren = $_SESSION["prenotatiDaTe_259158"] + $_SESSION["prenotatiDaAltri_259158"];
                $Nacq = $_SESSION["postiAcquistati_259158"];
                $Nlib = $_SESSION["postiLiberi_259158"];

                echo "<p id='output'>Numero posti prenotati: $Npren<br>
                        Numero posti acquistati: $Nacq<br>
                        Numero posti liberi: $Nlib</p>";*/

                $p=$_SESSION["prenotatiDaTe_259158"];
                echo "<script>
                        $(document).ready(function(){//viene chiamata solo una volta che la pagina è statat caricata
                            abilitaButtonAcquista($p);   
                        });//devo tenere anche questa chiamata di abilitaButton, perché, se non ho posti prenotati appena mi loggo, il tasto deve essere disabilitato
                        //invece, la chiamata abilitaButton che viene effettuata in handleclick() in js viene appunto fatta solo quando e se schiacchio su un posto
                    </script>";

            //}
            ?>







    </div>

    <footer>Flight reservation system - Alice Morano aloumora@studenti.polito.it - 2019</footer>

    </body>