CALL RegisterAzienda('IOFCNUFIDK', '1234', 'Azienda s.p.a.','Aziendale','azienda1@email.com', '../img/standardUserImage.jpg');

CALL RegistrazioneUtenteSemplice('utente1@gmail.com','1234','Alessandro','Mazzini','2023-03-31','Bologna','0', '../img/standardUserImage.jpg');
CALL RegistrazioneUtenteSemplice('utente2@gmail.com','1234','Andrea','Iannoli','2023-03-31','Bologna','0', '../img/standardUserImage.jpg');
CALL RegistrazioneUtenteSemplice('utente3@gmail.com','1234','Gabriele','Centonze','2023-03-31','Bologna','0', '../img/standardUserImage.jpg');
CALL RegistrazioneUtenteSemplice('utente4@gmail.com','1234','Alessandro','Mazzini','2023-03-31','Bologna','0', '../img/standardUserImage.jpg');
CALL RegistrazioneUtenteSemplice('utente5@gmail.com','1234','Andrea','Iannoli','2023-03-31','Bologna','0', '../img/standardUserImage.jpg');
CALL RegistrazioneUtenteSemplice('utente6@gmail.com','1234','Gabriele','Centonze','2023-03-31','Bologna','0', '../img/standardUserImage.jpg');

CALL RegisterUtenteSemplice('utenteAdmin@gmail.com','1234','Amministratore','Admin','2023-03-31','pekin','0', '../img/standardUserImage.jpg');
CALL PromoteToAdmin('utenteAdmin@gmail.com');

CALL AddSondaggio("Prova", 3, "2023-05-31", "APERTO", "azienda1@email.com");
CALL aggiungiCreazioneAziendale('1', 'azienda1@email.com');

CALL AddDominio('Calcio', 'Si calcia');