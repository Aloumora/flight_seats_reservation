<?php include("sessions.php");
handleSession();
include("db_functions.php");
handleCookies();
?>
<?php
$sessionUser = $_SESSION['username_aloumora'];
$prenotatiDaTe = $_SESSION["prenotatiDaTe_259158"];

$conn = dbConnect();
if(!$conn) {
    dbErrorInArticle("Couldn't connect to the database");
    exit;
}
$res = mysqli_query($conn, "SELECT * FROM map WHERE user='$sessionUser' AND status='P' FOR UPDATE");//faccio un lock per evitare problemi di concorrenza
$rows = mysqli_num_rows($res);
if($res) {
    //$rows = mysqli_num_rows($res);
    if($prenotatiDaTe == $rows){
        $upd = "UPDATE map SET status='A' WHERE user='$sessionUser' AND status='P'";
        $message = "Acquisto effettuato con successo!";
        $pp=$rows;
    }
    else{
		$upd = "UPDATE map SET status='F' WHERE user='$sessionUser' AND status='P'";
        $message = "Acquisto fallito: alcuni posti da te prenotati potrebbero essere stati prenotati o acquistati da altri utenti.";
        $pp=0;
    }

	$resupd = mysqli_query($conn, $upd);
}
else {
    $message = "Acquisto fallito: alcuni posti da te prenotati potrebbero essere stati prenotati o acquistati da altri utenti.";
    dbErrorInArticle("Error reading from the database");
    exit;
}

$data = array();

$data['message'] = $message;
$data['postiPrenotati'] = $pp;

// Encoding array in JSON format
echo json_encode($data);




//$data = {seat:'$seat',status:'$status',user:'$user',color:'$color',message:'$message', output:'$output'};
//echo "{seat:'$seat',status:'$status',user:'$user',color:'$color',message:'$message', output:'$output'};";
//echo "{'seat':'$seat','status':'$status','user':'$user','color':'$color','message':'$message', 'output':'$output'}";

?>