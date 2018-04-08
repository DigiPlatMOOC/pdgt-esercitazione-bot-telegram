<?php
require_once(dirname(__FILE__) . '/../token.php');
if(!isset($token)) {
    die("Token non impostato, creare un file token.php nella cartella root come scritto nella prima esercitazione\n");
}

$last_update_filename = "Lista.txt";
// apro il file dove scrivo l'ultimo id_upload
$handle = fopen($last_update_filename, "r");
// se il file è vuoto o non esiste deve dare errore
// altrimenti aquisisco l'intero come stringa e poi lo coverto in intero per passarlo all'url
if($handle){
	$contentsSt = fread($handle, filesize($last_update_filename));
	$contents1 = (int)$contentsSt;
	$contents = $contents1 + 1;
}
else
    $contents1 = 0;
fclose($handle);

// Genero l'URL della richiesta al mio bot passandogli il "token"
$url = "https://api.telegram.org/bot{$token}/getUpdates?offset=". ($contents) ."&limit=1";

$handle = curl_init($url);
if($handle == false) {
    die("Ops, cURL non funziona\n");
}
//CURLOPT_RETURNTRANSFER fa sì che cURL ritorni i contenuti del documento come dato 
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

// L’API Telegram ritorna i dati in formato JSON, per cui è opportuno decodificare
// Decodifica della risposta JSON, stampa a video
$dati = json_decode($response);
print_r($dati);

if(isset($dati->result[0])) {
    $update_id = $dati->result[0]->update_id;
	
	if(isset($dati->result[0]->update_id)) {
		// Abbiamo un aggiornamento
		// uso count per la lunghzza dell'array result per arrivare all'ultimo che sarebbe l'ultimo aggiornamento
		echo "ID ultimo aggiornamento: {$dati->result[0]->update_id}\n";
	}
	// scrivo sul file il numero ID dell'ultimo aggiornamento 
	file_put_contents($last_update_filename , $update_id."\n");
}



