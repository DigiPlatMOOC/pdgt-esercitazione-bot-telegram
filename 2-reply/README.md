# Rispondere al bot

## Introduzione

Notare che il codice è stato separato in due file distinti.
In particolare, il file `curl-lib.php` contiene una rudimentale libreria che permette di eseguire richieste&nbsp;HTTP tramite cURL (viene sfruttata nel file `get-updates.php` invocando il metodo `http_request()`).

Il codice di partenza tiene traccia dell’ID dell’ultimo update ricevuto dall’API di Telegram, memorizzandolo in un file di testo `last-update-id.txt`.
Dare un’occhiata al funzionamento dei due file ed effettuare delle prove per osservarne il funzionamento.

## Consegna

Sfruttando il metodo di libreria `http_request()` è possibile effettuare con facilità delle richieste&nbsp;HTTP verso l’API di Telegram.
In particolare, dare un’occhiata al [metodo `sendMessage`](https://core.telegram.org/bots/api#sendmessage) offerto dall’API ed ai suoi parametri (principalmente `chat_id` e `text`, che sono gli unici due parametri necessari).

Rispondere all’utente che ha inviato un messaggio, inviando un messaggio di risposta qualsiasi.
