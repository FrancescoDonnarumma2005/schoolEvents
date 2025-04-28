<?php
require_once('config.php');
if($_SERVER["REQUEST_METHOD"]=== "POST"){
   
        session_start();
        $idManif= $connection->real_escape_string($_POST["idManif"]);
        $dataIscrizione=new DateTime();
        $dataIscrizione=$dataIscrizione->format('Y-m-d');
        $stmt= $connection->prepare("INSERT INTO iscrizioni (codiceStud, codiceManif, dataIscrizione) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $_SESSION["codStud"],$idManif,$dataIscrizione);
        if ($stmt->execute()) {
           echo "iscrizione effettuata con successo";
        } else {
            echo "Errore nell'iscrizione";
        }
    }
if($_SERVER["REQUEST_METHOD"]=== "GET"){
    session_start();
    $stmt= $connection->prepare("SELECT * FROM iscrizioni I JOIN studenti S ON (I.codiceStud=S.codiceStud) WHERE I.codiceStud=?");
    $stmt->bind_param("i",$_SESSION["codStud"]);
    if($stmt->execute()){
        $result=$stmt->get_result();
        if($result->num_rows>0){
            $data=[];
            while($row=$result->fetch_assoc()){
                $tmp=[];
                $tmp["codiceManif"]=$row["codiceManif"];
                $tmp["codiceStud"]=$row["codiceStud"];
                array_push($data,$tmp);
            }
            echo json_encode($data);
        }
        else{
            echo json_encode(["message"=>"non ci sono iscrizioni"]);
        }
}
}