# Esercitazione Bot Telegram

Questa repository contiene alcune semplici esercitazioni, sulla base di quanto visto in laboratorio (client&nbsp;HTTP, HTTP da PHP, uso dell’[API di Telegram](https://core.telegram.org/bots/api)).

Le esercitazioni, che vanno svolte sequenzialmente, si trovano nelle varie sottocartelle di questa repository.
Ogni esercitazione contiene una guida e del codice di partenza.

In generale, ogni esercitazione ha come scopo lo sviluppo di una piccola parte di codice, che viene inclusa nel codice di partenza nell’esercitazione successiva.
Si consiglia di svolgere tutte le esercitazioni senza consultare prima il codice di quella successiva per aiutarsi.

## Procedura

1. Creare un **fork** di questa repository sul proprio **profilo personale**,
2. Scaricare il proprio fork in locale, utilizzando il comando `git clone`,
3. Svolgere le esercitazioni come indicato,
4. Effettuare il **commit** delle esercitazioni svolte (in particolare dell’ultima), con `git add` e poi `git commit`,
5. Sincronizzare i commit con la repository su Github, con `git push`,
6. Creare una nuova **pull request** tramite l’interfaccia Web, che costituirà la “consegna” dell’esercitazione.

La pull request non verrà accettata, ma può essere utilizzata per commentare quanto consegnato. L’esercitazione si considera completata quando la pull request sarà stata chiusa.

## Requisiti

Si utilizzerà PHP da riga di comando: è possibile installare l’interprete PHP sia su Windows che su Linux.
Nel primo caso va scaricato dal sito ufficiale e va configurato il *PATH* per l’esecuzione.
Nel secondo caso è sufficiente installare i pacchetti ufficiali, in particolare `php7.2-cli` e `php7.2-curl` (se la versione 7.2 non è disponibile, utilizzare quella presente per la propria distribuzione).
È possibile sfruttare i suddetti pacchetti ufficiali anche utilizzando [WSL](https://docs.microsoft.com/en-us/windows/wsl/install-win10)&nbsp;(Windows Subsystem for Linux) su Windows&nbsp;10.
