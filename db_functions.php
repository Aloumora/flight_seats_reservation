<?php



// sanitize input string
function sanitizeString($conn, $var) {
    $var = strip_tags($var);
    $var = stripcslashes($var);
    return mysqli_real_escape_string($conn, $var);
}

//connect to the db
function dbConnect() {
    $conn = @mysqli_connect("localhost","root","","aloumora");
    /*if (mysqli_connect_errno()) { echo "Connessione fallita: ". mysqli_connect_error();exit();} ……*/ //CONTROLLO CONNESSIONE FALLITA ??? è da fare?
    return $conn;
}

function dbErrorInArticle($cause) {
    echo "<div class='isa_error'>".$cause."</div><br>Go back to the <a href='index.php'>home page</a></article>";
    echo "<footer>Flight seat reservation system - Alice Morano aloumora@studenti.polito.it - 2019</footer>";
    echo "</div></body></html>";
}

function completePage($cause, $ref, $page) {
    echo "<div class='container'>";
    echo "<header><h1>Flight seat reservation system</h1></header>";
	echo "<aside>";
    echo "<nav><ul>";
    echo "<li><a href='index.php'>Home</a></li>";
    echo "<li><a href='login.php''>Login</a></li>";
    //echo "<li><a href='reserve.php'>Book</a></li>";
    echo "</ul></nav>";
    echo "</aside>";
	echo "<article class=\"sectionCentered\"><h2>Error</h2><div class='isa_error'>".$cause."</div>"; //mostra la causa di errore
    echo " Go back to the <a href=".$ref.">".$page." page</a></article>";
    echo "<footer>Flight seat reservation system - Alice Morano aloumora@studenti.polito.it - 2019</footer>";
    echo "</div></body></html>";
}

?>