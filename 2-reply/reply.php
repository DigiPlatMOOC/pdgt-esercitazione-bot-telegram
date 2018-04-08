<?php  

require_once(dirname(__FILE__) . '/../token.php');
require_once(dirname(__FILE__) . '/curl-lib.php');

if(!isset($token)) {
    die("Token non impostato, creare un file token.php nella cartella root come scritto nella prima esercitazione\n");
}

// Carica l'ID dell'ultimo aggiornamento da file
$last_update_filename = dirname(__FILE__) . '/last-update-id.txt';
if(file_exists($last_update_filename)) 
{
    $last_update = intval(@file_get_contents($last_update_filename));
}
else 
{
    $last_update = 0;
}

$data = http_request("https://api.telegram.org/bot{$token}/getUpdates?offset=" . ($last_update + 1));

if(isset($data->result[0])) 
{
    $update_id = $data->result[0]->update_id;
    $userName = $data->result[0]->message->from->first_name;
    $chatID = $data->result[0]->message->chat->id;

    $testo = "Ciao, " . $userName . "! Come va?";
	$dati = http_request("https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chatID}&text=".urlencode($testo));


    // Memorizziamo il nuovo ID nel file
    file_put_contents($last_update_filename, $update_id);
}
else
die("prima di procedere invia un messaggio al bot\n");



?>