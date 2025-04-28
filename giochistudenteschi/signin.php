<?php 
require_once("config.php");
session_start();
$username= $connection->real_escape_string($_POST["username"]);
$password= $connection->real_escape_string($_POST["password"]);
$nome=$connection->real_escape_string($_POST["nome"]);
$cognome=$connection->real_escape_string($_POST["cognome"]);
$codIstituto=$connection->real_escape_string($_POST["codIstituto"]);
$isStud = isset($_POST["isStud"]) ? $_POST["isStud"] : false;;
if($isStud){
$classe=$connection->real_escape_string($_POST["classe"]);
$data_html=$_POST["data_nascita"];
$data_nascita=new DateTime($data_html);

}

$hashed_password=password_hash($password, PASSWORD_DEFAULT);
$connection-> begin_transaction();
try{
$checksql="SELECT * FROM utenti WHERE username='$username'";
if($connection->query($checksql)->num_rows==0){

if($isStud){
$stmt=$connection->prepare("INSERT INTO studenti (nome, cognome, codIstituto, classe, data_nascita) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $nome, $cognome, $codIstituto, $classe, date_format($data_nascita, 'Y-m-d'));
$stmt->execute();
$AI_ID=$stmt->insert_id;
$stmt2=$connection->prepare("INSERT INTO utenti (username, password, codStud) VALUES (?, ?, ?)");
$stmt2->bind_param("sss", $username, $hashed_password, $AI_ID);
$stmt2->execute();
} 
else if(!$isStud){
$stmt=$connection->prepare("INSERT INTO professori (nome, cognome, codIstituto) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $nome, $cognome, $codIstituto);
$stmt->execute();
$AI_ID=$stmt->insert_id;
$stmt2=$connection->prepare("INSERT INTO utenti (username, password, codProf) VALUES (?, ?, ?)");
$stmt2->bind_param("sss", $username, $hashed_password, $AI_ID);
$stmt2->execute();
}
$connection->commit();
    $_SESSION["loggedin"]=true;
    $_SESSION["id"]=$stmt2->insert_id;
    $_SESSION["username"]=$username;
    $_SESSION["isStud"]=$isStud;
    if(!$isStud){
    $_SESSION["codProf"]=$stmt->insert_id;
    }
    else{
    $_SESSION["codStud"]=$stmt->insert_id;
    }
    header("location: ./areaPrivata.html");
    exit;
} else{

    echo "username già esistente";
}
}
catch(Exception $e){

    $connection->rollback();
    echo "Errore: " . $e->getMessage();
   
}
?>