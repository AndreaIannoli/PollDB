DROP DATABASE IF EXISTS PollDB;
CREATE DATABASE PollDB;

USE PollDB;

CREATE TABLE Dominio(
    Argomento VARCHAR(30) PRIMARY KEY,
    Descrizione VARCHAR(30)
) ENGINE = "INNODB";

CREATE TABLE Azienda(
    CodiceFiscale VARCHAR(30) NOT NULL,
    Pass CHAR(64) NOT NULL,
    Nome VARCHAR(30),
    Sede VARCHAR(30),
    IndirizzoEmail VARCHAR(30) NOT NULL,
    
    PRIMARY KEY(IndirizzoEmail, CodiceFiscale)
) ENGINE = "INNODB";

CREATE TABLE FotoAzienda(
	IndirizzoEmailAzienda VARCHAR(30) PRIMARY KEY,
    UrlFoto TEXT,
    FOREIGN KEY (IndirizzoEmailAzienda) REFERENCES Azienda(IndirizzoEmail)
) ENGINE = "INNODB";

CREATE TABLE Utente(
    Email VARCHAR(30) NOT NULL PRIMARY KEY,
    Pass CHAR(64) NOT NULL,
    Nome VARCHAR(30),
    Cognome VARCHAR(30),
    DataDiNascita DATE,
    LuogoNascita VARCHAR(30),
    TotaleBonus INT
) ENGINE = "INNODB";

CREATE TABLE FotoUtente(
	EmailUtente VARCHAR(30) NOT NULL PRIMARY KEY,
    UrlFoto TEXT,
    FOREIGN KEY (EmailUtente) REFERENCES Utente(Email)
) ENGINE = "INNODB";

CREATE TABLE UtentePremium(
    Emailutente VARCHAR(30) PRIMARY KEY,
    InizioAbbonamento Date,
    FineAbbonamento Date,
    Costo DOUBLE(10,6),
    NumSondaggi INT,
    FOREIGN KEY (EmailUtente) REFERENCES Utente(Email)
) ENGINE = "INNODB";

CREATE TABLE Sondaggio(
    Codice INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    MaxUtenti INT NOT NULL,
    Stato ENUM ('APERTO', 'CHIUSO'),
	Titolo VARCHAR(30) NOT NULL,
    DataChiusura Date,
    DataCreazione Date
) ENGINE = "INNODB";

CREATE TABLE Appartenenza(
	CodiceSondaggio INT NOT NULL AUTO_INCREMENT,
	ArgomentoDominio VARCHAR(30),
   
	PRIMARY KEY (CodiceSondaggio, ArgomentoDominio),
	FOREIGN KEY (CodiceSondaggio) references Sondaggio(Codice),
	FOREIGN KEY (ArgomentoDominio) references Dominio(Argomento)
   
) ENGINE = "INNODB";

CREATE TABLE Domanda(
	Id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Testo VARCHAR(200) NOT NULL,
    Punteggio INT,
    Foto VARCHAR(400)
) ENGINE = "INNODB";

/*
CREATE TABLE Punteggio(
	IdDomanda INT NOT NULL PRIMARY KEY,
    Punteggio INT NOT NULL,
    
    FOREIGN KEY(IdDomanda) REFERENCES Domanda(Id)
) ENGINE = "INNODB";

CREATE TABLE Foto(
	IdDomanda INT NOT NULL PRIMARY KEY,
    UrlFoto VARCHAR(100) NOT NULL,
    
    FOREIGN KEY(IdDomanda) REFERENCES Domanda(Id)
) ENGINE = "INNODB";
*/

CREATE TABLE DomandaAperta(
    Id INT NOT NULL PRIMARY KEY,
    MaxCaratteri INT,   
    FOREIGN KEY(Id) REFERENCES Domanda(Id)
) ENGINE = "INNODB";

CREATE TABLE DomandaChiusa(
    Id INT NOT NULL PRIMARY KEY,    
    FOREIGN KEY(Id) REFERENCES Domanda(Id)
) ENGINE = "INNODB";

CREATE TABLE Opzione(
    Numero INT NOT NULL AUTO_INCREMENT,
    Testo VARCHAR(30),
    IdDomanda INT,
	PRIMARY KEY (Numero, IdDomanda),
	FOREIGN KEY (IdDomanda) REFERENCES DomandaChiusa(Id)
) ENGINE = "INNODB";

CREATE TABLE RispostaChiusa(
    Id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Testo VARCHAR(30),
    IdDomanda INT,
    EmailUtente VARCHAR(30)
) ENGINE = "INNODB";

CREATE TABLE RispostaAperta(
    Id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Testo VARCHAR(30),
    IdDomanda INT,
    EmailUtente VARCHAR(30),
    
    FOREIGN KEY (IdDomanda) REFERENCES DomandaAperta(Id),
    FOREIGN KEY (EmailUtente) REFERENCES Utente(Email)
) ENGINE = "INNODB";

CREATE TABLE InserimentoAziendale(
    IdDomanda INT,
    IndirizzoEmailAzienda VARCHAR(30),
    PRIMARY KEY (IdDomanda, IndirizzoEmailAzienda),
    FOREIGN KEY (IdDomanda) REFERENCES DomandaChiusa(Id),
    FOREIGN KEY (IdDomanda) REFERENCES DomandaAperta(Id),
    FOREIGN KEY (IndirizzoEmailAzienda) REFERENCES Azienda(IndirizzoEmail)
) ENGINE = "INNODB";

CREATE TABLE CreazioneAziendale(
    CodiceSondaggio INT,
    IndirizzoEmailAzienda VARCHAR(30),
    PRIMARY KEY (CodiceSondaggio, IndirizzoEmailAzienda),
    FOREIGN KEY (CodiceSondaggio) REFERENCES Sondaggio(Codice),
    FOREIGN KEY (IndirizzoEmailAzienda) REFERENCES Azienda(IndirizzoEmail)
) ENGINE = "INNODB";

CREATE TABLE InserimentoPremium(
    IdDomanda INT,
    EmailUtentePremium VARCHAR(30),
    PRIMARY KEY (IdDomanda, EmailUtentePremium),
    FOREIGN KEY (IdDomanda) REFERENCES DomandaAperta(Id),
    FOREIGN KEY (IdDomanda) REFERENCES DomandaChiusa(Id),
	FOREIGN KEY (EmailUtentePremium) REFERENCES UtentePremium(EmailUtente)
) ENGINE = "INNODB";

CREATE TABLE CreazionePremium(
    EmailUtentePremium VARCHAR(30),
    CodiceSondaggio INT,
    PRIMARY KEY (CodiceSondaggio, EmailUtentePremium),
    FOREIGN KEY (CodiceSondaggio) REFERENCES Sondaggio(Codice),
    FOREIGN KEY (EmailUtentePremium) REFERENCES UtentePremium(EmailUtente)
) ENGINE = "INNODB";

CREATE TABLE UtenteAmministratore(
    EmailUtente VARCHAR(30) PRIMARY KEY,
    FOREIGN KEY (EmailUtente) REFERENCES Utente(Email)
) ENGINE = "INNODB";

CREATE TABLE Premio(
    Nome VARCHAR(30) PRIMARY KEY,
    Descrizione TEXT,
    Foto VARCHAR(30),
    PuntiMin INT,
    EmailAdmin VARCHAR(30)
) ENGINE = "INNODB";

CREATE TABLE Vincita(
    EmailUtente VARCHAR(30),
    NomePremio VARCHAR(30),
    DataVincita Date,
    PRIMARY KEY(EmailUtente, NomePremio),
    FOREIGN KEY (EmailUtente) REFERENCES Utente(Email),
    FOREIGN KEY (NomePremio) REFERENCES Premio(Nome)
) ENGINE = "INNODB";


CREATE TABLE Notifica(
    Codice VARCHAR(36) PRIMARY KEY,
    EmailUtente VARCHAR(30),
    Data DATE,
    Archiviata BOOLEAN,
    FOREIGN KEY (EmailUtente) REFERENCES Utente(Email),
    FOREIGN KEY (EmailUtente) REFERENCES Azienda(IndirizzoEmail)
) ENGINE = "INNODB";


CREATE TABLE NotificaPartecipazione(
	CodiceNotifica VARCHAR(36) PRIMARY KEY,
    EmailUtentePartecipante VARCHAR(30),
    CodiceSondaggio INT,
    FOREIGN KEY (CodiceNotifica) REFERENCES Notifica(Codice),
    FOREIGN KEY (EmailUtentePartecipante) REFERENCES Utente(Email),
    FOREIGN KEY (CodiceSondaggio) REFERENCES Sondaggio(Codice)
) ENGINE = "INNODB";

Create TABLE NotificaPremio(
	CodiceNotifica VARCHAR(36) PRIMARY KEY,
    NomePremio VARCHAR(30),
    FOREIGN KEY (CodiceNotifica) REFERENCES Notifica(Codice),
    FOREIGN KEY (NomePremio) REFERENCES Premio(Nome)
) ENGINE = "INNODB";


CREATE TABLE Invito(
    CodiceNotifica varchar(36) PRIMARY KEY,
    CodiceSondaggio INT,
    FOREIGN KEY (CodiceNotifica) REFERENCES Notifica(Codice),
    FOREIGN KEY (CodiceSondaggio) REFERENCES Sondaggio(Codice)
) ENGINE = "INNODB";

CREATE TABLE RispostaInvito(
    CodiceInvito VARCHAR(36) PRIMARY KEY,
    EmailUtente VARCHAR(30),
    Esito ENUM ('ACCETTATO', 'RIFIUTATO'),
    FOREIGN KEY (CodiceInvito) REFERENCES Invito(CodiceNotifica)
) ENGINE = "INNODB";

CREATE TABLE Associazione(
    CodiceSondaggio INT,
    EmailUtente VARCHAR(30),
    PRIMARY KEY(EmailUtente, CodiceSondaggio),
    FOREIGN KEY (CodiceSondaggio) REFERENCES Sondaggio(Codice),
    FOREIGN KEY (EmailUtente) REFERENCES Utente(Email)
) ENGINE = "INNODB";

CREATE TABLE Composizione(
    CodiceSondaggio INT,
    IdDomanda INT,
    PRIMARY KEY(IdDomanda, CodiceSondaggio),
    FOREIGN KEY (CodiceSondaggio) REFERENCES Sondaggio(Codice),
    FOREIGN KEY (IdDomanda) REFERENCES Domanda(Id)
) ENGINE = "INNODB";

CREATE TABLE Selezione(
    IdRisposta INT,
    NumeroOpzione INT,
    PRIMARY KEY(IdRisposta, NumeroOpzione),
    FOREIGN KEY (IdRisposta) REFERENCES RispostaChiusa(Id),
    FOREIGN KEY (NumeroOpzione) REFERENCES Opzione(Numero)
) ENGINE = "INNODB";

CREATE TABLE Interessamento(
    Argomento VARCHAR(30),
    EmailUtente VARCHAR(30),
    PRIMARY KEY(Argomento, EmailUtente),
    FOREIGN KEY (Argomento) REFERENCES Dominio(Argomento),
    FOREIGN KEY (EmailUtente) REFERENCES Utente(Email)
) ENGINE = "INNODB";

DELIMITER $
CREATE PROCEDURE randomUtenti ()
BEGIN
	SELECT Email FROM Utente ORDER BY RAND();
END
$ DELIMITER ;

#Insercisci domanda aperta sondaggio
DELIMITER $
CREATE PROCEDURE InserisciDomandaAperta (IN Testo VARCHAR(200), Punteggio INT, Foto VARCHAR(50), MaxCaratteri INT, CodiceSondaggio INT)
BEGIN
	INSERT INTO Domanda (Testo, Punteggio, Foto)  VALUES (Testo, Punteggio, Foto);
	SET @last_id = LAST_INSERT_ID(); 
	INSERT INTO DomandaAperta (Id, MaxCaratteri) VALUES (@last_id, MaxCaratteri); 
    INSERT INTO Composizione (CodiceSondaggio, IdDomanda) VALUES (CodiceSondaggio, @last_id); 
END
$ DELIMITER ;

#Insercisci domanda chiusa sondaggio
DELIMITER $
CREATE PROCEDURE InserisciDomandaChiusa (IN Testo VARCHAR(200), Punteggio INT, Foto VARCHAR(50), Opzione1 VARCHAR(50), Opzione2 VARCHAR(50), Opzione3 VARCHAR(50), Opzione4 VARCHAR(50), CodiceSondaggio INT)
BEGIN
	INSERT INTO Domanda (Testo, Punteggio, Foto)  VALUES (Testo, Punteggio, Foto);
	SET @last_id = LAST_INSERT_ID(); 
	INSERT INTO DomandaChiusa (Id) VALUES (@last_id); 
    INSERT INTO Opzione (Testo, IdDomanda) VALUES (Opzione1, @last_id); 
	INSERT INTO Opzione (Testo, IdDomanda) VALUES (Opzione2, @last_id); 
    INSERT INTO Opzione (Testo, IdDomanda) VALUES (Opzione3, @last_id); 
    INSERT INTO Opzione (Testo, IdDomanda) VALUES (Opzione4, @last_id);
    INSERT INTO Composizione (CodiceSondaggio, IdDomanda) VALUES (CodiceSondaggio, @last_id); 
END
$ DELIMITER ;

#i caratteri massimi di risposta dovrebbero essere a discrezione di chi fa la domanda
DELIMITER $
CREATE PROCEDURE InserisciRispostaAperta (IN Testo VARCHAR(200), IdDomanda INT, EmailUtente VARCHAR(50))
BEGIN
	INSERT INTO RispostaAperta (Testo, IdDomanda, EmailUtente)  VALUES (Testo, IdDomanda, EmailUtente);
END
$ DELIMITER ;

#Insercisci risposta chiusa domanda 
DELIMITER $
CREATE PROCEDURE InserisciRispostaChiusa (IN Testo VARCHAR(200), IdDomanda INT, EmailUtente VARCHAR(50))
BEGIN
	INSERT INTO RispostaChiusa (Testo, IdDomanda, EmailUtente)  VALUES (Testo, IdDomanda, EmailUtente);
END
$ DELIMITER ;

#Inserimento nuovo utente
DELIMITER $
CREATE PROCEDURE RegistrazioneUtenteSemplice (IN Email VARCHAR(30), Pass CHAR(64), Nome VARCHAR(30), Cognome VARCHAR(30), DataDiNascita DATE, LuogoDiNascita VARCHAR(30), TotaleBonus INT, UrlFoto TEXT)
BEGIN
	INSERT INTO Utente VALUES (Email , sha2(Pass, 256), Nome, Cognome, DataDiNascita, LuogoDiNascita, TotaleBonus);
    INSERT INTO FotoUtente VALUES (Email, UrlFoto);
END
$
DELIMITER ;

DELIMITER $
CREATE PROCEDURE CheckEmail (IN Email_Inserita VARCHAR(30))
BEGIN
	IF((SELECT count(*) FROM Utente WHERE(Email = Email_Inserita)) > 0) THEN
		SELECT count(*) FROM Utente WHERE(Email = Email_Inserita);
    END IF;
    
    IF((SELECT count(*) FROM Azienda WHERE(IndirizzoEmail = Email_Inserita)) > 0) THEN
		SELECT count(*) FROM Azienda WHERE(IndirizzoEmail = Email_Inserita);
    END IF;
END
$
DELIMITER ;

DELIMITER $
CREATE PROCEDURE CheckFiscalCode (IN CodiceFiscale_Inserito VARCHAR(30))
BEGIN
    SELECT count(*) AS Counter FROM Azienda WHERE(CodiceFiscale = CodiceFiscale_Inserito);
END
$
DELIMITER ;

DELIMITER $
CREATE PROCEDURE RegistrazioneAzienda (IN CodiceFiscale_Inserito VARCHAR(30), Pass CHAR(64), Nome_Inserito VARCHAR(30), Sede_Inserita VARCHAR(30), IndirizzoEmail_Inserita VARCHAR(30), UrlFoto TEXT)
BEGIN
    INSERT INTO Azienda VALUES (CodiceFiscale_Inserito, sha2(Pass, 256), Nome_Inserito, Sede_Inserita, IndirizzoEmail_Inserita);
    INSERT INTO FotoAzienda VALUES (IndirizzoEmail_Inserita, UrlFoto);
END
$
DELIMITER ;

DELIMITER $
CREATE PROCEDURE CheckCredentials (IN Email_Inserita VARCHAR(30), Pass_Inserita VARCHAR(100))
BEGIN
	IF((SELECT count(*) AS Authorized FROM Utente WHERE(sha2(Pass_Inserita, 256) = (SELECT Pass FROM Utente WHERE(Email = Email_Inserita)))) > 0) THEN
		SELECT count(*) AS Authorized FROM Utente WHERE(sha2(Pass_Inserita, 256) = (SELECT Pass FROM Utente WHERE(Email = Email_Inserita)));
    END IF;
    IF((SELECT count(*) AS Authorized FROM Azienda WHERE(sha2(Pass_Inserita, 256) = (SELECT Pass FROM Azienda WHERE(IndirizzoEmail = Email_Inserita)))) > 0) THEN
		SELECT count(*) AS Authorized FROM Azienda WHERE(sha2(Pass_Inserita, 256) = (SELECT Pass FROM Azienda WHERE(IndirizzoEmail = Email_Inserita)));
    END IF;
END 
$
DELIMITER ;

DELIMITER $
CREATE PROCEDURE SearchDominio (IN Argomento_Inserito VARCHAR(30))
BEGIN
	SELECT Argomento FROM Dominio WHERE Argomento LIKE CONCAT('%', Argomento_Inserito,'%');
END 
$
DELIMITER ;

DELIMITER $
CREATE PROCEDURE AddInteressamento (IN Argomento_Inserito VARCHAR(30), Email_Inserita VARCHAR(30))
BEGIN
	INSERT INTO Interessamento VALUES (Argomento_Inserito, Email_Inserita);
END 
$
DELIMITER ;

DELIMITER $
CREATE PROCEDURE RemoveInteressamento (IN Argomento_Inserito VARCHAR(30), Email_Inserita VARCHAR(30))
BEGIN
	DELETE FROM Interessamento WHERE(EmailUtente=Email_Inserita AND Argomento=Argomento_Inserito);
END 
$
DELIMITER ;

DELIMITER $
CREATE PROCEDURE GetUserInteressamento (IN Email_Inserita VARCHAR(30))
BEGIN
	SELECT Argomento FROM Interessamento WHERE(EmailUtente=Email_Inserita);
END 
$
DELIMITER ;

DELIMITER $
CREATE PROCEDURE GetDominio ()
BEGIN
	SELECT * FROM Dominio;
END 
$
DELIMITER ;

DELIMITER $
CREATE PROCEDURE GetUserNotifica (IN Email_Inserita VARCHAR(30))
BEGIN
	SELECT * FROM Notifica WHERE(EmailUtente = Email_Inserita AND Archiviata = false);
END 
$
DELIMITER ;

DELIMITER $
CREATE PROCEDURE GetInvito (IN Codice_Inserito VARCHAR(30))
BEGIN
	SELECT * FROM Invito WHERE(CodiceNotifica=Codice_Inserito);
END
$
DELIMITER;

DELIMITER $
CREATE PROCEDURE searchUtentePremium(IN email varchar(30))
BEGIN
	SELECT EmailUtente FROM UtentePremium WHERE EmailUtente = email;    
END
$ DELIMITER ;


DELIMITER $
CREATE PROCEDURE searchAzienda(IN email varchar(30))
BEGIN
	SELECT IndirizzoEmail FROM Azienda WHERE IndirizzoEmail = email;
END
$ DELIMITER ;

DELIMITER $
CREATE PROCEDURE returnUtenti(IN codSondaggio INT)
BEGIN
	SELECT Email FROM Utente WHERE Email NOT IN 
    (SELECT EmailUtente FROM Notifica WHERE (SELECT CodiceNotifica FROM Invito) = Codice AND 
    (SELECT CodiceSondaggio FROM Invito) = codSondaggio);
END
$ DELIMITER ;


DELIMITER $
CREATE PROCEDURE returnAccettati(IN codSondaggio INT)
BEGIN
	SELECT count(*) FROM RispostaInvito WHERE CodiceInvito = (SELECT CodiceNotifica FROM Invito WHERE CodiceSondaggio = codSondaggio) 
		AND Esito = 'ACCETTATO';
END
$ DELIMITER ;


DELIMITER $
CREATE PROCEDURE returnCodiceNotifica(IN emailutente varchar(30))
BEGIN
	SELECT Codice FROM Notifica WHERE EmailUtente = emailutente AND Archiviata = 0;
END
$ DELIMITER ;



DELIMITER $
CREATE PROCEDURE returnCodiceSondaggioInvito(IN codice varchar(36))
BEGIN
	SELECT CodiceSondaggio FROM Invito WHERE CodiceNotifica = codice;
END
$ DELIMITER ;


DELIMITER $
CREATE PROCEDURE returnNomeSondaggio(IN codiceS varchar(36))
BEGIN
	SELECT Titolo FROM Sondaggio WHERE Codice = codiceS;
END
$ DELIMITER ;



DELIMITER $
CREATE PROCEDURE returnInvitati()
BEGIN
	SELECT COUNT(*) FROM Utente;
END
$ DELIMITER ;

DELIMITER $
CREATE PROCEDURE creaNotifica(IN email varchar(30))
BEGIN
	INSERT INTO Notifica(EmailUtente, Data, Archiviata) VALUES(email, current_date(), false);
END
$ DELIMITER ;


DELIMITER $
CREATE PROCEDURE prendiCodiceNotifica()
BEGIN
	SELECT CodiceNotifica FROM Notifica;
	INSERT INTO Notifica(EmailUtente, Data, Archiviata) VALUES(email, current_date(), false);
END
$ DELIMITER;

DELIMITER $
CREATE PROCEDURE creaInvito(IN codSondaggio INT, email varchar(30))
BEGIN

	DECLARE codiceDaInserire varchar(36);
	set codiceDaInserire = uuid();

	INSERT INTO Notifica(Codice, EmailUtente, Data, Archiviata) VALUES(codiceDaInserire, email, current_date(), false);
    
    

	INSERT INTO Invito(CodiceNotifica, CodiceSondaggio) VALUES(codiceDaInserire, codSondaggio);


END
$ DELIMITER;


DELIMITER $
CREATE PROCEDURE returnDomini()
BEGIN

	SELECT Argomento FROM Dominio;
    


END
$ DELIMITER ;




DELIMITER $
CREATE PROCEDURE AggiungiAppartenenza (IN codiceSondaggio int, argomentoDominio varchar(30))

BEGIN
	INSERT INTO Appartenenza (CodiceSondaggio, ArgomentoDominio) 
		VALUES (codiceSondaggio, argomentoDominio);
END
$
DELIMITER;

DELIMITER $
CREATE PROCEDURE SearchCodiceSondaggio (IN titoloSondaggio varchar(30))
BEGIN
	SELECT Codice FROM Sondaggio WHERE (Sondaggio.Titolo = titoloSondaggio);
END 
$
DELIMITER ;

DELIMITER $
CREATE PROCEDURE InserisciSondaggio (IN titolo varchar(30),  utentiMax INT, dataChiusura DATE, statoSondaggio varchar(30))
BEGIN
	INSERT INTO Sondaggio (Titolo, MaxUtenti, DataCreazione, DataChiusura, Stato) 
		VALUES (titolo, utentiMax, current_date(), dataChiusura, statoSondaggio);
END
$ DELIMITER ;

DELIMITER $
CREATE PROCEDURE AcceptInvito (IN CodiceNotifica_Inserito VARCHAR(36))
BEGIN
	UPDATE Notifica SET Archiviato = true WHERE(Codice=CodiceNotifica_Inserito);
    INSERT INTO Associazione VALUES((SELECT CodiceSondaggio FROM Invito WHERE(CodiceNotifica=CodiceNotifica_Inserito)), (SELECT EmailUtente FROM Notifica WHERE(Codice=CodiceNotifica_Inserito)));
    INSERT INTO RispostaInvito VALUES(CodiceNotifica_Inserito, (SELECT EmailUtente FROM Notifica WHERE(Codice=CodiceNotifica_Inserito)), 'ACCETTATO');
END 
$
DELIMITER ;

DELIMITER $
CREATE PROCEDURE DenyInvito (IN CodiceNotifica_Inserito VARCHAR(36))
BEGIN
	UPDATE Notifica SET Archiviato = true WHERE(Codice=CodiceNotifica_Inserito);
    INSERT INTO RispostaInvito VALUES(CodiceNotifica_Inserito, (SELECT EmailUtente FROM Notifica WHERE(Codice=CodiceNotifica_Inserito)), 'RIFIUTATO');
END 
$
DELIMITER ;

DELIMITER $
CREATE PROCEDURE GetNotificationType (IN CodiceNotifica_Inserito VARCHAR(36))
BEGIN
	DECLARE Tipo VARCHAR(10);
    
	IF(SELECT count(*) FROM Invito WHERE(CodiceNotifica = CodiceNotifica_Inserito)>0) THEN
		SET Tipo = "Invito";
    END IF;
    
    SELECT Tipo;
END 
$
DELIMITER ;

DELIMITER $
CREATE PROCEDURE returnSondaggio(IN codiceS varchar(36))
BEGIN
	SELECT * FROM Sondaggio WHERE Codice = codiceS;
END
$ DELIMITER ;

DELIMITER $
CREATE PROCEDURE ReturnUtente(IN EmailInserita varchar(36))
BEGIN

	SELECT * FROM Utente WHERE Email = EmailInserita;
    
END
$ DELIMITER ;
]
DELIMITER $
CREATE PROCEDURE RandomInvite(IN CodiceSondaggio_Inserito INT)
BEGIN
	DECLARE MaxUtentiSondaggio INT;
    SET MaxUtentiSondaggio := (SELECT MaxUtenti FROM Sondaggio WHERE Codice = CodiceSondaggio_Inserito);
    DROP TEMPORARY TABLE IF EXISTS UserEligible;
    IF(SELECT count(*) FROM Utente WHERE((Email NOT IN (SELECT EmailUtente FROM Notifica WHERE(Codice IN (SELECT CodiceNotifica FROM Invito) AND Archiviata = false))) AND (SELECT count(*) FROM Interessamento WHERE((EmailUtente=Email) AND (Argomento IN (SELECT ArgomentoDominio FROM Appartenenza WHERE CodiceSondaggio = CodiceSondaggio_Inserito))))) > 0) THEN 
		CREATE TEMPORARY TABLE UserEligible SELECT Email FROM Utente WHERE((Email NOT IN (SELECT EmailUtente FROM Notifica WHERE(Codice IN (SELECT CodiceNotifica FROM Invito) AND Archiviata = false))) AND (SELECT count(*) FROM Interessamento WHERE((EmailUtente=Email) AND (Argomento IN (SELECT ArgomentoDominio FROM Appartenenza WHERE CodiceSondaggio = CodiceSondaggio_Inserito)))));
	ELSE
		CREATE TEMPORARY TABLE UserEligible SELECT Email FROM Utente LIMIT 0;
    END IF;
    IF(MaxUtentiSondaggio < (SELECT count(*) FROM UserEligible)) THEN
		SET @max := MaxUtentiSondaggio;
	ELSE
		SET @max := (SELECT count(*) FROM UserEligible);
    END IF;
    SET @i := 0;
    WHILE @i < @max DO
		SET @CurrentUser = (SELECT Email FROM UserEligible ORDER BY RAND() LIMIT 1);
        IF((@CurrentUser NOT IN (SELECT EmailUtente FROM Notifica WHERE(Codice IN (SELECT CodiceNotifica FROM Invito) AND Archiviata = false)))) THEN
            CALL creaInvito(CodiceSondaggio_Inserito, @CurrentUser);
            SET @i = @i + 1;
        END IF;
    END WHILE;
END
$ DELIMITER ;

DELIMITER $
CREATE PROCEDURE ReturnPollCreator(IN CodiceSondaggio_Inserito INT)
BEGIN
	IF(SELECT count(*) FROM CreazionePremium WHERE(CodiceSondaggio=CodiceSondaggio_Inserito) > 0) THEN
		SELECT EmailUtentePremium FROM CreazionePremium WHERE(CodiceSondaggio=CodiceSondaggio_Inserito);
	END IF;
    
    IF(SELECT count(*) FROM CreazioneAziendale WHERE(CodiceSondaggio=CodiceSondaggio_Inserito) > 0) THEN
		SELECT IndirizzoEmail FROM CreazioneAziendale WHERE(CodiceSondaggio=CodiceSondaggio_Inserito);
	END IF;
END
$ DELIMITER ;

DELIMITER $
CREATE PROCEDURE aggiungiCreazionePremium(IN email varchar(30), codiceSondaggio INT)
BEGIN
	INSERT INTO CreazionePremium(EmailUtentePremium, CodiceSondaggio) VALUES (email, codiceSondaggio);
END
$ DELIMITER ;



DELIMITER $
CREATE PROCEDURE aggiungiCreazioneAziendale(IN CodiceSondaggio_Inserito INT, Email_Inserita varchar(30))
BEGIN
	INSERT INTO CreazioneAziendale(CodiceSondaggio, IndirizzoEmailAzienda) VALUES (CodiceSondaggio_Inserito, Email_Inserita);
END
$ DELIMITER ;


DELIMITER $
CREATE PROCEDURE returnCodiceAzienda(IN email varchar(30))
BEGIN
		SELECT CodiceFiscale FROM Azienda WHERE IndirizzoEmail = email;
END
$ DELIMITER ;

DELIMITER $
CREATE PROCEDURE ReturnAzienda(IN CodiceFiscale_Inserito varchar(30))
BEGIN
		SELECT * FROM Azienda WHERE CodiceFiscale = CodiceFiscale_Inserito;
END
$ DELIMITER ;

DELIMITER $
CREATE PROCEDURE ReturnProPic(IN Email_Inserita varchar(30))
BEGIN
	IF((SELECT count(*) FROM FotoUtente WHERE(EmailUtente = Email_Inserita)) > 0) THEN
		SELECT * FROM FotoUtente WHERE(EmailUtente = Email_Inserita);
    END IF;
    
    IF((SELECT count(*) FROM FotoAzienda WHERE(IndirizzoEmailAzienda = Email_Inserita)) > 0) THEN
		SELECT * FROM FotoAzienda WHERE(IndirizzoEmailAzienda = Email_Inserita);
    END IF;
END
$ DELIMITER ;

DELIMITER $
CREATE PROCEDURE ReturnName(IN Email_Inserita varchar(30))
BEGIN
	IF((SELECT count(*) FROM Utente WHERE(Email = Email_Inserita)) > 0) THEN
		SELECT Nome FROM Utente WHERE(Email = Email_Inserita);
    END IF;
    
    IF((SELECT count(*) FROM Azienda WHERE(IndirizzoEmail = Email_Inserita)) > 0) THEN
		SELECT Nome FROM Azienda WHERE(IndirizzoEmail = Email_Inserita);
    END IF;
END
$ DELIMITER ;

DELIMITER $
CREATE PROCEDURE ReturnUserType(IN Email_Inserita varchar(30))
sp1:BEGIN
		DROP TEMPORARY TABLE IF EXISTS UserType;
		CREATE TEMPORARY TABLE UserType(
			Tipo Varchar(14)
		);
        IF((SELECT count(*) FROM UtenteAmministratore WHERE(EmailUtente = Email_Inserita)) > 0) THEN
			INSERT INTO UserType VALUES("Amministratore");
			SELECT * FROM UserType;
			LEAVE sp1;
		END IF;
		IF((SELECT count(*) FROM UtentePremium WHERE(EmailUtente = Email_Inserita)) > 0) THEN
			INSERT INTO UserType VALUES("Premium");
			SELECT * FROM UserType;
			LEAVE sp1;
		END IF;
		IF((SELECT count(*) FROM Azienda WHERE(IndirizzoEmail = Email_Inserita)) > 0) THEN
			INSERT INTO UserType VALUES("Azienda");
			SELECT * FROM UserType;
			LEAVE sp1;
		END IF;
		IF((SELECT count(*) FROM Utente WHERE(Email = Email_Inserita)) > 0) THEN
			INSERT INTO UserType VALUES("Utente");
			SELECT * FROM UserType;
			LEAVE sp1;
		END IF;
	END
$ DELIMITER ;