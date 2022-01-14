function mailVerif(idutente){
    let usermail = document.getElementById("email").value;
    alert(idutente);

    fetch("https://saw21.dibris.unige.it/~S4540263/php/fetchAPImailverifUpdate.php", {
        method: "post",
        headers: { "Content-type": "application/x-www-form-urlencoded" },
        body: "email=" + usermail,
        }).then(
            function(response){
                if(response.status != 200){
                    console.log("errore");
                    return;
                }
                return response.text();
            }
        ).then(
            function(result){
                if(result == 'KO'){
                    document.getElementById("email").style.color="red";
                    document.getElementById("submit").value = "Email non valida";
                    document.getElementById("submit").disabled = true;
                }else{
                    document.getElementById("email").style.color="green";
                    document.getElementById("submit").value = "Registrati!";
                    document.getElementById("submit").disabled = false;
                    
                }

            }
        );
}