<?php
require_once "config.php";

$stmt = $connection->prepare("DELETE FROM manifestazioni WHERE codiceManif = ?");
$stmt->bind_param("i", $idToDelete);
if ($stmt->execute()) {
    echo "Manifestazione eliminata con successo";
} else{
    echo  "Impossibile eliminare la manifestazione";
}
$stmt->close();



?>