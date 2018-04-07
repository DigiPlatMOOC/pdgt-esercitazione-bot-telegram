<?php
require_once(dirname(__FILE__) . '/../token.php');
require_once(dirname(__FILE__) . '/curl-lib.php');

if(!isset($token)) {
    die("Token non impostato, creare un file token.php nella cartella root come scritto nella prima esercitazione\n");
}

// Carica l'ID dell'ultimo aggiornamento da file
$last_update_filename = dirname(__FILE__) . '/last-update-id.txt';
if(file_exists($last_update_filename)) {
    $last_update = intval(@file_get_contents($last_update_filename));
}
else {
    $last_update = 0;
}

$dati = http_request("https://api.telegram.org/bot{$token}/getUpdates?offset=" . ($last_update + 1) . "&limit=1");
print_r($dati);

if(isset($dati->result[0])) {
    $update_id = $dati->result[0]->update_id;

    $chat_id = $dati->result[0]->message->chat->id;
    if(isset($dati->result[0]->message->text)) {
        $text = $dati->result[0]->message->text;
    }
    else {
        $text = "";
    }

    // $chat_id contiene l'ID della conversazione
    // $text l'eventuale testo inviato

    if(/* utente ha inviato un messaggio precedente */) {
        // Invia messaggio precedente
    }
    else {
        // Benvenuto
        // Memorizza $text
    }

    // Memorizziamo il nuovo ID nel file
    file_put_contents($last_update_filename, $update_id);
}
