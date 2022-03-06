function togglePassword() {
    var x = document.getElementById("password");
    if (x.type === "password") {
        x.type = "text";//il formato text è visibile, mentre il formato pwd è nascosto
    } else {
        x.type = "password";
    }
}
//controllo lato client che l'utente inserisca il formato corretto
function checkUser() {
    var usr = document.getElementById("username").value;//questo equivale a $(#username).value in jquery

    if(!(/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,7}/.test(usr)) && usr.length>0) {
        document.getElementById("username").style.backgroundColor = "#FFD2D2";
    }
    else {
        if (usr.length != 0)
            document.getElementById("username").style.backgroundColor = "#DFF2BF";
        else
            document.getElementById("username").style.backgroundColor = "white";
    }
}

function checkPwd() {
    var pass = document.getElementById("password").value;

    if (!(/.*[a-z].*[A-Z0-9].*|.*[A-Z0-9].*[a-z].*/.test(pass)) && pass.length>0) {
        document.getElementById("password").style.backgroundColor = "#FFD2D2";
    }
    else {
        if (pass.length != 0)
            document.getElementById("password").style.backgroundColor = "#DFF2BF";
        else
            document.getElementById("password").style.backgroundColor = "white";
    }
}

function checkConf() {//controlla che la seconda pwd di registrer sia uguale all prima
    var pass = document.getElementById("password").value;
    var conf = document.getElementById("confirm").value;

    if((pass != conf) && conf.length>0) {
        document.getElementById("confirm").style.backgroundColor = "#FFD2D2";
    }
    else {
        if (conf.length != 0)
            document.getElementById("confirm").style.backgroundColor = "#DFF2BF";
        else
            document.getElementById("confirm").style.backgroundColor = "white";
    }
}

/*function handleClick(cb) {
    var element = document.getElementById("L"+cb.id);
    element.classList.remove('orange');
    element.classList.remove('red');
    element.classList.remove('yellow');
    element.classList.remove('green');
    element.classList.add('yellow');
}*/

function abilitaButtonAcquista(prenotatiDaTe){
    //alert("sono in abilita!!!!!!!!!!!!!!!!!");
    if (prenotatiDaTe>0){
        //$('#btnAcquista').attr("disabled","");
        $('#btnAcquista').prop('disabled', false);
    }else{
        //$('#btnAcquista').attr("disabled","disabled");
        $('#btnAcquista').prop('disabled', true);
    }
}

function resetRedirect(_redirectHandle,_redirectUrl, _redirectTimeout) {
    //alert('sono in redirect');
    if (_redirectHandle)
        clearTimeout(_redirectHandle);
    _redirectHandle = setTimeout(function () {
        window.location.href = _redirectUrl;
    }, _redirectTimeout);

}

function handleClick(cb) {//cb é il bottone su cui ho cliccato (è proprio l'oggetto, cioè quello che di là chiamo this)
    //alert("Clicked, new value = " + cb.checked);
    var bgColor = "";
    if($("#L" + cb.id).hasClass('green')){
        bgColor='green';
    }
    if($("#L" + cb.id).hasClass('orange')){
        bgColor='orange';
    }
    if($("#L" + cb.id).hasClass('red')){
        bgColor='red';
    }
    if($("#L" + cb.id).hasClass('yellow')){
        bgColor='yellow';
    }
    $("#L" + cb.id).removeClass();

    //questo mi serve per fare il logout dopo 120 secondi di inattività

	var _redirectTimeout = 120 * 1000; // ten hours timeout - test with 10 * 1000 for ten seconds :)
    var _redirectUrl = 'sessionExpired.php'; // login URL

    resetRedirect(_redirectHandle, _redirectUrl, _redirectTimeout);
    //alert('sono in handleclick');

    //$.ajaxSetup({ complete: function () { resetRedirect(); } }); // reset idle redirect when an AJAX request completes

    $.ajax({
        type:'POST',
        url:'ajax.php',
        data:'seat='+cb.id+'&color='+bgColor,
        dataType: 'json',
        success: function(response){
            //var myJSON = JSON.stringify(response);
            //$("#output").html(myJSON);//#output prende l'elemento con l'id 'output'; dentro l'html corrispondente, fa uscire il mio risultato
            //alert(myJSON);
            $('#output').html("");
            /*for(var key in response) {
                $('#output').append(key);
                $('#output').append('=' + response[key] + '<br />');
            }*/
			

            var Npren = response.prenotatiDaTe + response.prenotatiDaAltri;
            var Nacq = response.postiAcquistati;
            var Nlib = response.postiLiberi;

            $('#output').append('Numero posti prenotati: '+ Npren + '<br /> <br />');
            $('#output').append('Numero posti acquistati: '+ Nacq + '<br /> <br />');
            $('#output').append('Numero posti liberi: '+ Nlib + '<br /> <br />');
            $('#output').append(response.message + '<br />');

            //$('#output').append(response.colorOld + '<br />');



            //alert(response.user);
            //alert(response["user"]);
            //alert(response["message"]);
            //alert(response['message']);

            abilitaButtonAcquista(response.prenotatiDaTe);

            $("#L" + cb.id).addClass(response.color);
        }
    });
}



/*function onload(prenotatiDaTe){
    alert("onload");
    $(document).ready(function(){
        alert("onload");
        abilitaButtonAcquista(prenotatiDaTe);
        a=$('#btnAcquista').attr();
        alert(a);
    });

}*/

function handleAcquista() {

    $.ajax({
        type:'POST',
        url:'ajaxAcquista.php',
        dataType: 'json',
        success: function(response){
            $('#message').html("");

            for(var key in response) {
                $('#message').append(key);
                $('#message').append('=' + response[key] + '<br />');
            }//questa parte del #message non la uso più: si potrebbe commentare
            //alert(response.postiPrenotati);
            alert(response.message);
            window.location.reload();
        }

    });




}