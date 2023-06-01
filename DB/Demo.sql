USE PollDB;

 

CALL RegisterAzienda('IOFCNUFIDK', 'password1', 'Azienda1 s.p.a.','Sede1','azienda1@email.com', '../img/standardUserImage.jpg');
CALL RegisterAzienda('ABCDEFGHIL', 'password2', 'Azienda2 s.p.a.','Sede2','azienda2@email.com', '../img/standardUserImage.jpg');
CALL RegisterAzienda('MNOPQRSTUV', 'password3', 'Azienda3 s.p.a.','Sede3','azienda3@email.com', '../img/standardUserImage.jpg');

 

CALL RegisterUtenteSemplice('utente1@email.com','Password1','Alessandro','Mazzini','2023-03-31','Bologna','0', '../img/standardUserImage.jpg');
CALL RegisterUtenteSemplice('utente2@email.com','Password2','Andrea','Iannoli','2023-03-31','Bologna','0', '../img/standardUserImage.jpg');
CALL RegisterUtenteSemplice('utente3@email.com','Password3','Gabriele','Centonze','2023-03-31','Bologna','0', '../img/standardUserImage.jpg');
CALL RegisterUtenteSemplice('utente4@email.com','Password4','Mario','Rossi','2023-03-31','Bologna','0', '../img/standardUserImage.jpg');
CALL RegisterUtenteSemplice('utente5@email.com','Password5','Maria','Bianchi','2023-03-31','Bologna','0', '../img/standardUserImage.jpg');
CALL RegisterUtenteSemplice('utenteAdmin@email.com','Password6','Master','User','2023-12-11','Bologna','0', '../img/standardUserImage.jpg');

 

CALL PromoteToAdmin('utenteAdmin@email.com');

 

CALL AddSubscription("utente1@email.com", date_add(current_date(), INTERVAL 10 DAY), 0);
CALL AddSubscription("utente2@email.com", date_add(current_date(), INTERVAL 10 DAY), 0);

 


CALL AddSondaggio("Lancio del nuovo prodotto di make-up", 20, "2023-05-31", "APERTO", "azienda1@email.com");
CALL AddSondaggio("Test di esercitazione all'esame", 50, "2023-07-31", "APERTO", "utente1@email.com");
CALL AddSondaggio("Quale stagione armocromatica sei? Scoprilo adesso!", 100, "2023-02-11", "APERTO", "azienda2@email.com");

 

CALL AddDomain('Startup', 'Ricerche di mercato');
CALL AddDomain('Prodotti', 'Lancio di nuovi prodotti');
CALL AddDomain('Cura personale', 'Dal fitness alla moda');
CALL AddDomain('Studio', 'Migliora le tue conoscenze');

 

CALL AddInteressamento('Startup', 'utente1@email.com');
CALL AddInteressamento('Prodotti', 'utente1@email.com');
CALL AddInteressamento('Startup', 'utente2@email.com');
CALL AddInteressamento('Cura personale', 'utente3@email.com');
CALL AddInteressamento('Prodotti', 'utente4@email.com');
CALL AddInteressamento('Cura personale', 'utente4@email.com');
CALL AddInteressamento('Startup', 'utente5@email.com');
CALL AddInteressamento('Studio', 'utente5@email.com');

 

Call AddAppartenenza(1, 'Prodotti');
Call AddAppartenenza(2, 'Studio');
Call AddAppartenenza(3, 'Cura personale');

 


CALL AddDomandaAperta("Cosa ti piace del nostro nuovo prodotto?", 10, "https://media.istockphoto.com/id/1221677097/it/foto/make-up-prodotti-cosmetici-su-sfondo-colore-rosa.jpg?s=612x612&w=0&k=20&c=ynOIXCYjvkZK33keMlwGIP6DwH4SYy3elDlTESJOOU0=", 500, 1);
CALL AddDomandaAperta("Cosa avresti cambiato del nostro prodotto?", 10, "https://media.istockphoto.com/id/1221677097/it/foto/make-up-prodotti-cosmetici-su-sfondo-colore-rosa.jpg?s=612x612&w=0&k=20&c=ynOIXCYjvkZK33keMlwGIP6DwH4SYy3elDlTESJOOU0=", 500, 1);
CALL AddDomandaAperta("Utilizza 3 parole per definire il prodotto che hai appena visto", 10, "https://media.istockphoto.com/id/1221677097/it/foto/make-up-prodotti-cosmetici-su-sfondo-colore-rosa.jpg?s=612x612&w=0&k=20&c=ynOIXCYjvkZK33keMlwGIP6DwH4SYy3elDlTESJOOU0=", 500, 1);

 

CALL AddDomandaChiusa("Quanto fa 2+2", 1, "foro", "4","3","5","6", 2);
CALL AddDomandaChiusa("Quanti millimetri sono un metro?", 5, "foro", "Cento","Mille","Dieci","Dieci mila", 2);
CALL AddDomandaChiusa("Qual è la radice quadrata di 16?", 10, "foro", "13","2","4","16", 2);

 


CALL AddDomandaAperta("Qual è il colore della tua pelle?", 10, "https://www.gedistatic.it/content/gedi/img/huffingtonpost/2022/05/27/184449889-ff3968e6-8116-497e-980f-bc498467297e.jpg", 300, 3);
CALL AddDomandaAperta("Qual è il colore dei tuoi occhi?", 10, "https://www.gedistatic.it/content/gedi/img/huffingtonpost/2022/05/27/184449889-ff3968e6-8116-497e-980f-bc498467297e.jpg", 200, 3);
CALL AddDomandaAperta("Hai un sottotono caldo o freddo?", 10, "https://www.gedistatic.it/content/gedi/img/huffingtonpost/2022/05/27/184449889-ff3968e6-8116-497e-980f-bc498467297e.jpg", 500, 3);