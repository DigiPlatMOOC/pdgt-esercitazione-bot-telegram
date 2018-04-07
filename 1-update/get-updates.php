<?php
require_once(dirname(__FILE__) . '/../token.php');
if(!isset($token)) {
    die("Token non impostato, creare un file token.php nella cartella root come scritto nella prima esercitazione\n");
}

$url = "https://api.telegram.org/bot{$token}/getUpdates?limit=1";

$handle = curl_init($url);
if($handle == false) {
    die("Ops, cURL non funziona\n");
}

curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handle, CURLOPT_HTTPHEADER, array(
    "User-Agent: il mio primo script PHP"
));

// Esecuzione della richiesta, $response = contenuto della risposta testuale
$response = curl_exec($handle);

$status = curl_getinfo($handle, CURLINFO_HTTP_CODE);
if($status != 200) {
    die("Richiesta HTTP fallita, status {$status}\n");
}

// Decodifica della risposta JSON, stampa a video
$dati = json_decode($response);
print_r($dati);

if(isset($dati->result[0])) {
    // Abbiamo un aggiornamento
    echo "ID aggiornamento: {$dati->result[0]->update_id}\n";
}
