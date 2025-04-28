<?php 

$host="localhost";
$user="root";
$password="";
$db="giochistudenteschi";
try{
$connection= new mysqli ($host,$user,$password,$db);
}
catch(Exception $e){
   echo $e;
}

    



?>