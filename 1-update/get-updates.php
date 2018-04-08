<?php
require_once(dirname(__FILE__) . '/../token.php');
if(!isset($token)) 
{
    die("Token non impostato, creare un file token.php nella cartella root come scritto nella prima esercitazione\n");
}

$updateID = file_get_contents("updateID.txt");
$url = "https://api.telegram.org/bot{$token}/getUpdates?offset={$updateID}";

$handle = curl_init($url);
if($handle == false) 
{
    die("Ops, cURL non funziona\n");
}

curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handle, CURLOPT_HTTPHEADER, array(
    "User-Agent: il mio primo script PHP"
));

// Esecuzione della richiesta, $response = contenuto della risposta testuale
$response = curl_exec($handle);

$status = curl_getinfo($handle, CURLINFO_HTTP_CODE);
if($status != 200) 
{
    die("Richiesta HTTP fallita, status {$status}\n");
}

// Decodifica della risposta JSON, stampa a video
$dati = json_decode($response);

//incremento l'update id solo se l'utente ha effettivamente inviato un nuovo messaggio
if(isset($dati->result[0]))
{
	$updateID += 1;
	file_put_contents("updateID.txt", $updateID);
}
else
	die("Nessun nuovo messaggio.\n");

//print_r($dati);
echo $dati->result[0]->message->text."\n";

if(isset($dati->result[0])) 
{
    // Abbiamo un aggiornamento
    echo "ID aggiornamento: {$dati->result[0]->update_id}\n";
}

?>