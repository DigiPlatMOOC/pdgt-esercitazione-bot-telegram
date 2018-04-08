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

$dati = http_request("https://api.telegram.org/bot{$token}/getUpdates?offset=" . ($last_update + 1) . "&limit=1");


if(isset($dati->result[0])) {
    $update_id = $dati->result[0]->update_id;
    $name = $dati->result[0]->message->from->first_name;
    $chat_id = $dati->result[0]->message->chat->id;
    if(isset($dati->result[0]->message->text)) 
    {
        $text = $dati->result[0]->message->text;
    }
    else 
    {
        $text = "";
    }

    // $chat_id contiene l'ID della conversazione
    // $text l'eventuale testo inviato

    // Memorizziamo il nuovo ID nel file
    file_put_contents($last_update_filename, $update_id);

    //estraggo il contenuto del file contenente l'ultimo messaggio
    //se la chat id salvata len file è uguale a quella dell'utente che ha inviato un mess al bot

    if(file_exists("mess-precedente-".$chat_id.".txt")) 
    {
        $mess_prec = json_decode(file_get_contents("mess-precedente-".$chat_id.".txt"));
        $text_prec = $mess_prec->testo;
        // Invia messaggio precedente
        sendMessage("L'ultimo messaggio che mi hai inviato è: ".$text_prec);
        
    }
    else 
    {
        // Benvenuto
        sendMessage("Benvenuto " . $name);

    }
    saveMess();
   
}


function sendMessage($testo)
{
    $dati = http_request("https://api.telegram.org/bot{$GLOBALS['token']}/sendMessage?chat_id={$GLOBALS['chat_id']}&text=".urlencode($testo));
}

function saveMess()
{
    $memoria = array('chat ID' => $GLOBALS['chat_id'],
                     'nome' => $GLOBALS['name'],                         
                     'testo' => $GLOBALS['text']
                     );
    $memoria_json = json_encode($memoria);
    file_put_contents("mess-precedente-".$GLOBALS['chat_id'].".txt", $memoria_json);
}

?>