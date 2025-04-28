<?php 
require_once("config.php");

session_start();
if($_SESSION['isStud'] == true){
$sql = "SELECT id, username, nome, cognome, codIstituto, denominazione, codStud FROM utenti U 
JOIN studenti S ON (U.codStud=S.codiceStud) 
JOIN istituti I ON (S.codIstituto = I.codiceIstituto)
WHERE id = ?";
}
else{
$sql = "SELECT id, username, nome, cognome, codIstituto, denominazione, codProf FROM utenti U 
JOIN professori P ON (U.codProf=P.codiceProf) 
JOIN istituti I ON (P.codIstituto = I.codiceIstituto) WHERE id = ?";
}
try{
$stmt=$connection->prepare($sql);
$stmt->bind_param("i",$_SESSION['id']);
$stmt->execute();
$result=$stmt->get_result();
if($result->num_rows == 1){
    $row=$result->fetch_array(MYSQLI_ASSOC);
    if(isset($row['codProf'])){
        $_SESSION["codProf"]=$row['codProf'];
    }
    else{
        $_SESSION["codStud"]=$row['codStud'];
    }
    echo json_encode($row); 
}
} catch(Exception $e){

echo $e;
}


?>