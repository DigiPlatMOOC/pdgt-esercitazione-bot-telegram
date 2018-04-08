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
    // Recupero "memoria"
    $memory = json_decode(file_get_contents("memory.json"));

    $update_id = $dati->result[0]->update_id;

    $chat_id = $dati->result[0]->message->chat->id;
    if(isset($dati->result[0]->message->text)) {
        $text = $dati->result[0]->message->text;
    }
    else {
        $text = "";
    }

    $user_id = $dati->result[0]->message->from->id;
    $chat_id = $dati->result[0]->message->chat->id;
    $text = $dati->result[0]->message->text;

    if(isset($memory->$chat_id->$user_id)) {
        // Mando il messaggio memorizzato
        $msg = $memory->$chat_id->$user_id;
        http_request("https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat_id}&text={$msg}");
    }
    else {
        // Mando messaggio di benvenuto
        $name = $dati->result[0]->message->from->first_name;
        $msg = "Welcome ".$name."!";
        http_request("https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat_id}&text={$msg}");
        $memory->$chat_id->$user_id = $text;

        // Archivio "memoria"
        file_put_contents("memory.json", json_encode($memory));
    }

    // Memorizziamo il nuovo ID nel file
    file_put_contents($last_update_filename, $update_id);
}
