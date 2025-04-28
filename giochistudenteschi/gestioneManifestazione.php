<?php 
require_once "config.php";
if($_SERVER["REQUEST_METHOD"]=== "POST"){
if(isset($_POST["action"])){
    session_start();
    $idManif= $connection->real_escape_string($_POST["idManif"]);
    $titolo = $connection->real_escape_string($_POST["titolo"]);
    $descrizione = $connection->real_escape_string($_POST["descrizione"]);
    $luogo = $connection->real_escape_string($_POST["luogo"]);
    $data_html = $_POST["data_evento"];
    $data_evento=new DateTime($data_html);
    $stmt= $connection->prepare("UPDATE manifestazioni SET titoloManif=?,descrizione=?,luogo=?,dataInizio=?
    WHERE codiceManif=?");
    $stmt->bind_param("ssssi",$titolo,$descrizione,$luogo,$data_evento->format('Y-m-d'),$idManif);
    if ($stmt->execute()) {
       header("location: ./areaPrivata.html");
    } else {
        echo json_encode(['error' => $stmt->error]);
    }
   
    
}
else{
session_start();
    $titolo = $connection->real_escape_string($_POST["titolo"]);
    $descrizione = $connection->real_escape_string($_POST["descrizione"]);
    $luogo = $connection->real_escape_string($_POST["luogo"]);
    $data_html = $_POST["data_evento"];
    $data_evento=new DateTime($data_html);

    $stmt=$connection->prepare("INSERT INTO manifestazioni (titolomanif, descrizione, luogo, dataInizio, codProf) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $titolo, $descrizione, $luogo, date_format($data_evento, 'Y-m-d'), $_SESSION["codProf"]);
    $stmt->execute();
    $stmt->close();
    header("Location: ./areaPrivata.html");
}
}   

    if($_SERVER["REQUEST_METHOD"]=== "GET")  {
    session_start();
    if(!isset($_GET['id'])){
        if(isset($_SESSION["codProf"])){
            $codProf=$_SESSION["codProf"];
            $stmt=$connection->prepare("SELECT * FROM manifestazioni  M
            JOIN professori P on (M.codProf=P.codiceProf)
            JOIN istituti I ON (P.codIstituto = I.codiceIstituto) where codProf=".$codProf);
        }
    else{
    $stmt=$connection->prepare("SELECT * FROM manifestazioni M
        JOIN professori P on (M.codProf=P.codiceProf)
        JOIN istituti I ON (P.codIstituto = I.codiceIstituto)");
        }
    $stmt->execute();

    $result=$stmt->get_result();
    if($result->num_rows>0){
        $data=[];
        while($row=$result->fetch_assoc()){
        $tmp=[];
        $tmp["codiceManif"]=$row["codiceManif"];
        $tmp["titoloManif"]=$row["titoloManif"];
        $tmp["descrizione"]=$row["descrizione"];
        $tmp["luogo"]=$row["luogo"];
        $tmp["dataInizio"]=$row["dataInizio"];
        $tmp["codProf"]=$row["codProf"];
        $tmp["nomeProf"]=$row["nome"];
        $tmp["cognomeProf"]=$row["cognome"];
        $tmp["nomeIstituto"]=$row["denominazione"];
        array_push($data, $tmp);
        }
        echo json_encode($data);
    } 
    else{
    echo json_encode(["message"=>"Non ci sono manifestazioni per ora"]);
    }
} else if(isset($_GET['id'])){
    $id=$_GET['id'];
    $stmt=$connection->prepare("SELECT * FROM manifestazioni where codiceManif=".$id);
    if($stmt->execute()){
    $data=[]; 
    $result=$stmt->get_result();
    if($result->num_rows==1){

        $row=$result->fetch_array(MYSQLI_ASSOC);
        $tmp=[];
        $tmp["codiceManif"]=$row["codiceManif"];
        $tmp["titoloManif"]=$row["titoloManif"];
        $tmp["descrizione"]=$row["descrizione"];
        $tmp["luogo"]=$row["luogo"];
        $tmp["dataInizio"]=$row["dataInizio"];
        array_push($data, $tmp);
        echo json_encode($data);
        
    }
}

}

}




?>