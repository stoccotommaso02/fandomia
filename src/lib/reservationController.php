<?php 

/* Step logici:
   - Controllare che l'utente abbia i grants per effettuare la prenotazione;
   - Controllare la presenza degli input necessari;
   - Fare la pulizia dei suddetti input;
   - Fare i controlli logici sui suddetti input (ad es. non si può
     prenotare il ritiro di un prodotto in una data antecedente al suo arrivo!);
   - Salvare la prenotazione nel DB;
   - Reindirizzare l'utente alla pagina che stava visualizzando precedentemente,
     visualizzando un messaggio di conferma dell'avvenuta prenotazione;
  Scenario alternativo:
  - Visualizzare messaggio d'errore nel caso in cui la prenotazione non sia andata
    a buon fine; */



?>