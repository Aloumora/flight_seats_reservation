<?php include("sessions.php");
handleSession();
include("db_functions.php");
handleCookies();
?>
<?php
$seat=$_POST['seat'];
$color_old=$_POST['color'];

$conn = dbConnect();
if(!$conn) {
    dbErrorInArticle("Couldn't connect to the database");
    exit;
}
$res = mysqli_query($conn, "SELECT * FROM map WHERE seat='$seat' FOR UPDATE");
if($res) {
    //$rows = mysqli_num_rows($res);
    $map = mysqli_fetch_array($res);
    $seat = $map["seat"];
    $color = "";
    $status=$map["status"];
    $user=$map["user"];
    $update=false;
    if ( $status== "A") {//acquired
        $color = "red";
        $message = "Posto non più prenotabile: il posto è stato nel frattempo acquistato.";
        $_SESSION["postiAcquistati_259158"]++;
        if($color_old=='green'){
            $_SESSION["postiLiberi_259158"]--;
        }
        elseif($color_old=='yellow'){
            $_SESSION["prenotatiDaTe_259158"]--;
        }
        elseif($color_old=='orange'){
            $_SESSION["prenotatiDaTe_259158"]--;
        }

    }
    elseif($status== "F"){
        $color = "yellow";
        $status="P";
        $user=$_SESSION['username_aloumora'];
        $message = "Il posto era libero e ora è stato prenotato da te.";
        $_SESSION["prenotatiDaTe_259158"]++;
        $_SESSION["postiLiberi_259158"]--;
        $update=true;//significa che è necessario un aggiornamento
    }
    elseif($status== "P"){
        if($user==$_SESSION['username_aloumora']){
            $color = "green";
            $status="F";
            $user="";
            $message = "Il posto era prenotato da te e ora è stato liberato.";
            if($_SESSION["prenotatiDaTe_259158"]>0){
                $_SESSION["prenotatiDaTe_259158"]--;
            }
            $_SESSION["postiLiberi_259158"]++;
            $update=true;//significa che è necessario un aggiornamento
        }
        else{
            $color = "yellow";
            $status="P";
            $message = "Il posto era prenotato da $user e ora è stato prenotato da te.";
            $user=$_SESSION['username_aloumora'];
            $_SESSION["prenotatiDaTe_259158"]++;
            $_SESSION["prenotatiDaAltri_259158"]--;
            $update=true;//significa che è necessario un aggiornamento
        }
    }
    if($update){
        $upd = "UPDATE map SET user='$user', status='$status' WHERE seat='$seat'";
        $resupd = mysqli_query($conn, $upd);
    }

}
else {
    dbErrorInArticle("Error reading from the database");
    exit;
}
$output= "il posto $seat è attualmente prenotato da $user. Il risultato della tua prenotazione é $message.";

$prenotatiDaTe = $_SESSION["prenotatiDaTe_259158"];
$prenotatiDaAltri = $_SESSION["prenotatiDaAltri_259158"];
$acquistati = $_SESSION["postiAcquistati_259158"];
$liberi = $_SESSION["postiLiberi_259158"];

$data = array();

$data['user'] = $user;
$data['message'] = $message;
$data['output'] = $output;
$data['color'] = $color;
$data['prenotatiDaTe'] = $prenotatiDaTe;
$data['prenotatiDaAltri'] = $prenotatiDaAltri;
$data['postiLiberi'] = $liberi;
$data['postiAcquistati'] = $acquistati;
$data['colorOld']= $color_old;



// Encoding array in JSON format
echo json_encode($data);

//$data = {seat:'$seat',status:'$status',user:'$user',color:'$color',message:'$message', output:'$output'};
//echo "{seat:'$seat',status:'$status',user:'$user',color:'$color',message:'$message', output:'$output'};";
//echo "{'seat':'$seat','status':'$status','user':'$user','color':'$color','message':'$message', 'output':'$output'}";

?>