<?php 
require_once "config.php";
session_start();
$codiceManif = $_POST["idManif"];
$stmt = $connection->prepare("DELETE FROM iscrizioni WHERE codiceManif=? AND codiceStud=?");
$stmt->bind_param("ii", $codiceManif, $_SESSION["codStud"]);
if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo "Iscrizione eliminata con successo";
    } else {
        echo "Nessuna riga eliminata. Potrebbe non esistere una corrispondenza con i valori forniti.";
    }
} else {
    echo "Impossibile eliminare l'iscrizione. Errore: " . $stmt->error;
}

$stmt->close();
?>