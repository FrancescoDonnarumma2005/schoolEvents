<?php 
require_once "config.php";
if($_SERVER["REQUEST_METHOD"]=== "GET"){
$sql="SELECT * FROM istituti";

if($result = $connection-> query($sql)) {
    $data= [];
    if($result -> num_rows>0){
        while($row=$result-> fetch_array(MYSQLI_ASSOC)){  
            $tmp=[];
            $tmp["id"]=$row["codiceIstituto"];
            $tmp["denom"]=$row["denominazione"];
            $tmp["indirizzo"]=$row["indirizzo"];

            array_push($data, $tmp);
        }
    }
    echo json_encode($data);
}
else{
    echo json_encode(["error"=>"query error"]);
}
}
else{
    echo json_encode(["error"=>"not connected"]);
}
