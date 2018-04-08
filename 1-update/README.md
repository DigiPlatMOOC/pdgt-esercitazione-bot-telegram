# Ricevere aggiornamenti dal bot

## Introduzione

### Creazione di un bot

I bot Telegram sono dei “risponditori automatici”: un’identità virtuale su Telegram, che funziona come qualsiasi altro contatto umano, con il quale ogni utente del servizio di messaggistica può conversare.
I messaggi inviati al bot vengono gestiti da un programma, il quale potrà gestirli o reagire ai vari messaggi, eventualmente inviando messaggi all’utente.

Il primo passo per la realizzazione di un bot è la **registrazione**:
dopo aver creato un account utente sul servizio Telegram è necessario comunicare con il bot `@botfather` (è sufficiente cercare il suo nome) ed utilizzare il comando `/newbot`.
Dopo aver seguito la procedura ed aver assegnato un nome univoco al proprio bot, si otterrà un **token**, ossia un codice alfanumerico che permette di interagire con il proprio bot.

È importante **assicurarsi che il token sia al sicuro**, che non venga condiviso e *soprattutto* che non venga inavvertitamente pubblicato online (come ad esempio può capitare utilizzando una repository pubblica su Github).

Prima di iniziare quindi, creare un *nuovo* file nella cartella radice della repository, chiamato `token.php`.
Scriverci il seguente codice:

```php
<?php
$token = "COPIARE IL TOKEN QUI";
```

La repository è già configurata in modo da ignorare questo file ed impedirvi quindi di pubblicare il file ed il token in esso contenuto per errore (vedere il file `.gitignore`).

### Ricevere aggiornamenti

Per ricevere aggiornamenti dal proprio bot è necessario utilizzare la [funzione `getUpdates` delle API per bot di Telegram](https://core.telegram.org/bots/api#getupdates).
Ossia, effettuare una richiesta HTTP al seguente URL:

```
https://api.telegram.org/bot123456:ABC-DEF1234ghIkl-zyx57W2v1u123ew11/getUpdates
```

(Dove chiaramente il token è sostituito con quello del proprio bot.)

Dare un’occhiata al file `get-updates.php` per vederne un’implementazione semplice in PHP sfruttando cURL.
In particolare notare che:

1. L’URL della richiesta HTTP viene generato a riga 7, utilizzando la variabile `$token` che è dichiarata nel file `token.php` che è stato creato come spiegato al passo precedente,
2. L’opzione `CURLOPT_RETURNTRANSFER` fa sì che cURL ritorni i contenuti del documento come dato (quindi i dati verranno copiati nella variabile `$response` a riga 20) invece di stamparli in output,
3. Da riga&nbsp;22 a&nbsp;25 si verifica che la richiesta&nbsp;HTTP abbia avuto successo, verificando che lo stato&nbsp;HTTP sia effettivamente `200` (ossia “OK”),
4. L’API Telegram ritorna i dati in formato&nbsp;JSON, per cui è opportuno decodificare i dati utilizzando `json_decode` a riga&nbsp;28 e poi stamparli a video come oggetto PHP a riga&nbsp;29 utilizzando il metodo `print_r`.

### Andare avanti

L’API bot di Telegram mantiene una lista di messaggi nella coda che vanno gestiti dal bot.
Questa lista viene progressivamente svuotata quando i messaggi superano una certa “età”.
Infatti, lanciando più volte il comando `php get-updates.php` si noterà che i messaggi già ricevuti e scaricati verranno scaricati nuovamente.

In particolare, visto che a riga&nbsp;7 si è utilizzato il parametro `limit` (impostato ad&nbsp;1) nell’URL, verrà scaricato sempre e solo il primo messaggio dalla coda.
Effettuare delle verifiche modificando il valore di `limit` per osservarne il comportamento.

Per procedere nella lista degli aggiornamenti è necessario utilizzare il parametro `offset`, che contiene l’**ID** del *prossimo* update che si intende scaricare (ossia, l’ID successivo all’ultimo update ricevuto).
Visto che ad ogni esecuzione lo script PHP viene eseguito da capo (ossia, ogni esecuzione dello script d’esempio non mantiene memoria delle precedenti esecuzioni dello stesso script) sarà necessario tenere traccia dell’ID degli update in maniera manuale.

## Consegna

Implementare manualmente un sistema per cui l’ID dell’ultimo aggiornamento viene memorizzato su disco (su un file arbitrario) e viene utilizzato per popolare il valore del parametro `offset` alla prossima esecuzione.

Notare in particolare come è possibile accedere all’ID dell’update grazie alla decodifica dei dati&nbsp;JSON a riga&nbsp;33.

Suggerimenti:

* È possibile utilizzare le classiche funzioni&nbsp;C per l’apertura e la scrittura dei file (`fopen`, `fprintf`, etc.),
* Altrimenti è possibile utilizzare le funzioni `file_get_contents` e `file_put_contents`.
