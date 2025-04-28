<?php 
require_once("config.php");

$username= $connection->real_escape_string($_POST["username"]);
$password= $connection->real_escape_string($_POST["password"]);

$query = "SELECT * FROM utenti WHERE username= '$username'";
if($_SERVER["REQUEST_METHOD"]==="POST"){
if($result = $connection->query($query)){
if ($result->num_rows ==1) {
    $row = $result->fetch_array(MYSQLI_ASSOC);
    if (password_verify($password, $row["password"])) {
    session_start();
    $_SESSION["loggedin"]=true;
    $_SESSION["id"]=$row["ID"];
    $_SESSION["username"]=$row["username"];
    if ($row["codStud"]!==null) {
        $_SESSION["isStud"] = true;
        $_SESSION["codStud"]=$row['codStud'];
    } else {
        $_SESSION["isStud"] = false;
        $_SESSION["codProf"]=$row['codProf'];
    }
    header("location: ./areaprivata.html");
    exit;
    } else {
        echo "Password errata";
    } 
    } 
    else {
        echo "Username non registrato";
        
    }
} else{

    echo "Errore: " . $query . "<br>" . $connection->error;

}
$connection->close();

}


?>