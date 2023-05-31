CALL RegisterAzienda('IOFCNUFIDK', '1234', 'Azienda s.p.a.','Aziendale','azienda1@email.com', '../img/standardUserImage.jpg');

CALL RegisterUtenteSemplice('utente1@gmail.com','1234','Alessandro','Mazzini','2023-03-31','Bologna','0', '../img/standardUserImage.jpg');
CALL RegisterUtenteSemplice('utente2@gmail.com','1234','Andrea','Iannoli','2023-03-31','Bologna','0', '../img/standardUserImage.jpg');
CALL RegisterUtenteSemplice('utente3@gmail.com','1234','Gabriele','Centonze','2023-03-31','Bologna','0', '../img/standardUserImage.jpg');
CALL RegisterUtenteSemplice('utente4@gmail.com','1234','Alessandro','Mazzini','2023-03-31','Bologna','0', '../img/standardUserImage.jpg');
CALL RegisterUtenteSemplice('utente5@gmail.com','1234','Andrea','Iannoli','2023-03-31','Bologna','0', '../img/standardUserImage.jpg');
CALL RegisterUtenteSemplice('utente6@gmail.com','1234','Gabriele','Centonze','2023-03-31','Bologna','0', '../img/standardUserImage.jpg');

CALL RegisterUtenteSemplice('utenteAdmin@gmail.com','1234','Amministratore','Admin','2023-03-31','pekin','0', '../img/standardUserImage.jpg');
CALL PromoteToAdmin('utenteAdmin@gmail.com');

CALL AddSondaggio("Prova", 3, "2023-05-31", "APERTO", "azienda1@email.com");


CALL AddDomain('Calcio', 'Si calcia');
CALL AddDomain('Pallavolo', 'Si palleggia');

CALL AddInteressamento('Calcio', 'utente1@gmail.com');
CALL AddInteressamento('Calcio', 'utente2@gmail.com');
CALL AddInteressamento('Pallavolo', 'utente2@gmail.com');
CALL AddInteressamento('Pallavolo', 'utente3@gmail.com');
CALL AddInteressamento('Calcio', 'utente4@gmail.com');

Call AddAppartenenza(1, 'Calcio');

CALL AddSubscription("utente1@gmail.com", date_add(current_date(), INTERVAL 10 DAY), 0);
CALL AddSondaggio("Prova", 3, "2023-05-31", "APERTO", "utente1@gmail.com");
CALL AddSondaggio("Prova", 3, "2023-05-31", "APERTO", "utente1@gmail.com");