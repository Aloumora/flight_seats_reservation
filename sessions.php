<?php
function handleSession() {
    session_start();
    $t=time();
    $diff=0;
    $new=false;
    if (isset($_SESSION['time_aloumora'])){
        $t0=$_SESSION['time_aloumora'];
        $diff=($t-$t0);
    }
    else {
        $new=true;
    }
    //echo "ecco diff $diff"; //non posso fare echo prima di setcookie
    if ($diff > 600) {//timeout 10 minuti: ho comunque gestito il blocco ogni due minuti con un timer in js
        if(isset($_SESSION["username_aloumora"]))
            $next = "login.php";
        else
            $next = "sessionExpired.php";
        $_SESSION=array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 3600*24,
                $params["path"], $params["domain"], $params["secure"], $params["httponly"]); //Evita che il cookie non scaduto sia inviato dal browser al server PHP e venga usato per creare una nuova sessione alla chiamata di session_start() ????
        }
        session_destroy();
        header('HTTPS/1.1 307 temporary redirect');
        header('Location: '.$next);//questo redirect non funziona->l'ho gestito in js
        exit;//importante
    }
    else {
        $_SESSION['time_aloumora']=time();
    }
    //echo"fine handle session";
}//ricordati di impostare anche un maxlifetime

function userLoggedIn() {
    //echo $_SESSION['username_aloumora'];
    if (isset($_SESSION['username_aloumora'])) {
        return ($_SESSION['username_aloumora']);
    }
    else {
        return false;
    }
}

function prenotatiDaTe() {
    //echo $_SESSION['username_aloumora'];
    if (isset($_SESSION["prenotatiDaTe_259158"])) {
        return ($_SESSION["prenotatiDaTe_259158"]);
    }
    else {
        return 0;
    }
}


function handleCookies() {
    if (isset($_SESSION['loadcount_aloumora']) && ($_SESSION['loadcount_aloumora'] > 0)) {
        $_SESSION['loadcount_aloumora']++;
        //echo $_SESSION["loadcount_aloumora"] . "<br>";
    } else {
        //echo "loadcount_aloumora is now: ".$_SESSION['loadcount_aloumora']."<br>";
        //echo "calling check cookies\n"; CONTROLLA QUESTE ECHO CON PAPA'
        $_SESSION['loadcount_aloumora'] = 0; //conta il load delle pagine, quindi i richiami di handlecookie
        checkCookies(); //inizializza i cookie
    }
}


function checkCookies() {
    setcookie("firstCookie", "init", time()+3600);
    header("Location: check.php");
    exit;
}

function checkHTTPS() {
    if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {

    } else {

        $redirect = 'https://' . $_SERVER['HTTP_HOST'] .
            $_SERVER['REQUEST_URI'];
        header('HTTP/1.1 301 Moved Permanently');
        header('Location: ' . $redirect);
        exit();
    }
}
?>