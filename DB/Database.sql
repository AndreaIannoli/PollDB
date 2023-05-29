DROP DATABASE IF EXISTS PollDB;
CREATE DATABASE PollDB;

USE PollDB;

CREATE TABLE Dominio(
    Argomento VARCHAR(30) PRIMARY KEY,
    Descrizione VARCHAR(300)
) ENGINE = "INNODB";

CREATE TABLE Azienda(
    CodiceFiscale VARCHAR(30) NOT NULL,
    Pass CHAR(64) NOT NULL,
    Nome VARCHAR(30),
    Sede VARCHAR(30),
    IndirizzoEmail VARCHAR(30) NOT NULL,
    UrlFoto TEXT, /*DA DECIDERE*/
    
    PRIMARY KEY(IndirizzoEmail)
) ENGINE = "INNODB";

CREATE TABLE Utente(
    Email VARCHAR(30) NOT NULL PRIMARY KEY,
    Pass CHAR(64) NOT NULL,
    Nome VARCHAR(30),
    Cognome VARCHAR(30),
    DataDiNascita DATE,
    LuogoNascita VARCHAR(30),
    TotaleBonus INT,
    UrlFoto TEXT /*DA DECIDERE*/
) ENGINE = "INNODB";

CREATE TABLE UtentePremium(
    Emailutente VARCHAR(30) PRIMARY KEY,
    InizioAbbonamento Date,
    FineAbbonamento Date,
    Costo DOUBLE,
    NumSondaggi INT DEFAULT 0,
    FOREIGN KEY (EmailUtente) REFERENCES Utente(Email)
) ENGINE = "INNODB";

CREATE TABLE Sondaggio(
    Codice INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    MaxUtenti INT NOT NULL,
    Stato ENUM ('APERTO', 'CHIUSO'),
	Titolo VARCHAR(30) NOT NULL,
    DataChiusura Date,
    DataCreazione Date,
    EmailCreatorePremium VARCHAR(30),
    EmailCreatoreAzienda VARCHAR(30),
    
    FOREIGN KEY(EmailCreatorePremium) REFERENCES UtentePremium(EmailUtente),
    FOREIGN KEY(EmailCreatoreAzienda) REFERENCES Azienda(IndirizzoEmail),
    CONSTRAINT chk1 CHECK(
    (EmailCreatorePremium IS NOT NULL AND EmailCreatoreAzienda IS NULL) OR 
    (EmailCreatoreAzienda IS NOT NULL AND EmailCreatorePremium IS NULL))
) ENGINE = "INNODB";

CREATE TABLE Appartenenza(
	CodiceSondaggio INT NOT NULL AUTO_INCREMENT,
	ArgomentoDominio VARCHAR(30),
   
	PRIMARY KEY (CodiceSondaggio, ArgomentoDominio),
	FOREIGN KEY (CodiceSondaggio) references Sondaggio(Codice) ON DELETE CASCADE,
	FOREIGN KEY (ArgomentoDominio) references Dominio(Argomento) ON DELETE CASCADE
) ENGINE = "INNODB";

CREATE TABLE Domanda(
	Id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Testo VARCHAR(200) NOT NULL,
    Punteggio INT,
    Foto TEXT
) ENGINE = "INNODB";

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
    EmailUtente VARCHAR(30),
    
	FOREIGN KEY (IdDomanda) REFERENCES DomandaChiusa(Id),
    FOREIGN KEY (EmailUtente) REFERENCES Utente(Email)
) ENGINE = "INNODB";

CREATE TABLE RispostaAperta(
    Id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Testo VARCHAR(30),
    IdDomanda INT,
    EmailUtente VARCHAR(30),
    
    FOREIGN KEY (IdDomanda) REFERENCES DomandaAperta(Id),
    FOREIGN KEY (EmailUtente) REFERENCES Utente(Email)
) ENGINE = "INNODB";

/*
CREATE TABLE InserimentoAziendale(
    IdDomanda INT,
    IndirizzoEmailAzienda VARCHAR(30),
    PRIMARY KEY (IdDomanda, IndirizzoEmailAzienda),
    FOREIGN KEY (IdDomanda) REFERENCES DomandaChiusa(Id),
    FOREIGN KEY (IdDomanda) REFERENCES DomandaAperta(Id),
    FOREIGN KEY (IndirizzoEmailAzienda) REFERENCES Azienda(IndirizzoEmail)
) ENGINE = "INNODB";
*/

/*
CREATE TABLE InserimentoPremium(
    IdDomanda INT,
    EmailUtentePremium VARCHAR(30),
    PRIMARY KEY (IdDomanda, EmailUtentePremium),
    FOREIGN KEY (IdDomanda) REFERENCES DomandaAperta(Id),
    FOREIGN KEY (IdDomanda) REFERENCES DomandaChiusa(Id),
	FOREIGN KEY (EmailUtentePremium) REFERENCES UtentePremium(EmailUtente)
) ENGINE = "INNODB";
*/

CREATE TABLE UtenteAmministratore(
    EmailUtente VARCHAR(30) PRIMARY KEY,
    FOREIGN KEY (EmailUtente) REFERENCES Utente(Email)
) ENGINE = "INNODB";

CREATE TABLE Premio(
    Nome VARCHAR(30) PRIMARY KEY,
    Descrizione TEXT,
    Foto TEXT,
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

/*Tabella opzionale*/
Create TABLE NotificaPremio(
	CodiceNotifica VARCHAR(36) PRIMARY KEY,
    NomePremio VARCHAR(30),
	EmailUtente VARCHAR(30),
    Data DATE,
    Archiviata BOOLEAN,
    FOREIGN KEY (NomePremio) REFERENCES Premio(Nome),
    FOREIGN KEY (EmailUtente) REFERENCES Utente(Email)
) ENGINE = "INNODB";

CREATE TABLE Invito(
    Codice INT AUTO_INCREMENT PRIMARY KEY,
    CodiceSondaggio INT,
    Esito VARCHAR(10),
    FOREIGN KEY (CodiceSondaggio) REFERENCES Sondaggio(Codice)
) ENGINE = "INNODB";

/*Tabella opzionale*/
CREATE TABLE NotificaInvito(
    CodiceNotifica varchar(36) PRIMARY KEY,
    CodiceInvito INT,
	EmailUtente VARCHAR(30),
    Data DATE,
    Archiviata BOOLEAN,
    FOREIGN KEY (CodiceInvito) REFERENCES Invito(Codice),
	FOREIGN KEY (EmailUtente) REFERENCES Utente(Email)
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
    FOREIGN KEY (Argomento) REFERENCES Dominio(Argomento) ON DELETE CASCADE,
    FOREIGN KEY (EmailUtente) REFERENCES Utente(Email) ON DELETE CASCADE
) ENGINE = "INNODB";

DELIMITER $
CREATE PROCEDURE RandomUtenti ()
BEGIN
	SELECT Email FROM Utente ORDER BY RAND();
END
$ DELIMITER ;

#Insercisci domanda aperta sondaggio
DELIMITER $
CREATE PROCEDURE AddDomandaAperta (IN Testo VARCHAR(200), Punteggio INT, Foto VARCHAR(50), MaxCaratteri INT, CodiceSondaggio INT)
BEGIN
	INSERT INTO Domanda (Testo, Punteggio, Foto)  VALUES (Testo, Punteggio, Foto);
	SET @last_id = LAST_INSERT_ID(); 
	INSERT INTO DomandaAperta (Id, MaxCaratteri) VALUES (@last_id, MaxCaratteri); 
    INSERT INTO Composizione (CodiceSondaggio, IdDomanda) VALUES (CodiceSondaggio, @last_id); 
END
$ DELIMITER ;

#Insercisci domanda chiusa sondaggio
DELIMITER $
CREATE PROCEDURE AddDomandaChiusa (IN Testo VARCHAR(200), Punteggio INT, Foto VARCHAR(50), Opzione1 VARCHAR(50), Opzione2 VARCHAR(50), Opzione3 VARCHAR(50), Opzione4 VARCHAR(50), CodiceSondaggio INT)
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
CREATE PROCEDURE AddRispostaAperta (IN Testo VARCHAR(200), IdDomanda INT, EmailUtente VARCHAR(50))
BEGIN
	INSERT INTO RispostaAperta (Testo, IdDomanda, EmailUtente)  VALUES (Testo, IdDomanda, EmailUtente);
END
$ DELIMITER ;

#Insercisci risposta chiusa domanda 
DELIMITER $
CREATE PROCEDURE AddRispostaChiusa (IN Testo VARCHAR(200), IdDomanda INT, EmailUtente VARCHAR(50))
BEGIN
	INSERT INTO RispostaChiusa (Testo, IdDomanda, EmailUtente)  VALUES (Testo, IdDomanda, EmailUtente);
END
$ DELIMITER ;

#Inserimento nuovo utente
DELIMITER $
CREATE PROCEDURE RegisterUtenteSemplice (IN Email VARCHAR(30), Pass CHAR(64), Nome VARCHAR(30), Cognome VARCHAR(30), DataDiNascita DATE, LuogoDiNascita VARCHAR(30), TotaleBonus INT, UrlFoto_Inserito TEXT)
BEGIN
	INSERT INTO Utente VALUES (Email , sha2(Pass, 256), Nome, Cognome, DataDiNascita, LuogoDiNascita, TotaleBonus, UrlFoto_Inserito);
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
CREATE PROCEDURE RegisterAzienda (IN CodiceFiscale_Inserito VARCHAR(30), Pass CHAR(64), Nome_Inserito VARCHAR(30), Sede_Inserita VARCHAR(30), IndirizzoEmail_Inserita VARCHAR(30), UrlFoto_Inserito TEXT)
BEGIN
    INSERT INTO Azienda VALUES (CodiceFiscale_Inserito, sha2(Pass, 256), Nome_Inserito, Sede_Inserita, IndirizzoEmail_Inserita, UrlFoto_Inserito);
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
CREATE PROCEDURE GetDomains ()
BEGIN
	SELECT * FROM Dominio;
END 
$
DELIMITER ;

DELIMITER $
CREATE PROCEDURE GetUserNotifica (IN Email_Inserita VARCHAR(30))
BEGIN
	SELECT 'Invito' AS Type, CodiceNotifica AS Codice, Data FROM NotificaInvito WHERE(EmailUtente = Email_Inserita AND Archiviata = false) 
    UNION SELECT 'Premio', CodiceNotifica, Data FROM NotificaPremio WHERE(EmailUtente = Email_Inserita AND Archiviata = false) ORDER BY Data;
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
CREATE PROCEDURE SearchUtentePremium(IN email varchar(30))
BEGIN
	SELECT EmailUtente FROM UtentePremium WHERE EmailUtente = email;    
END
$ DELIMITER ;

DELIMITER $
CREATE PROCEDURE SearchPremiums(IN Email_Inserita varchar(30))
BEGIN
	SELECT * FROM UtentePremium WHERE EmailUtente LIKE CONCAT('%', Email_Inserita,'%');  
END
$ DELIMITER ;

DELIMITER $
CREATE PROCEDURE SearchAzienda(IN email varchar(30))
BEGIN
	SELECT IndirizzoEmail FROM Azienda WHERE IndirizzoEmail = email;
END
$ DELIMITER ;

DELIMITER $
CREATE PROCEDURE ReturnUtenti(IN codSondaggio INT)
BEGIN
	SELECT Email FROM Utente WHERE Email NOT IN 
    (SELECT EmailUtente FROM Notifica WHERE (SELECT CodiceNotifica FROM Invito) = Codice AND 
    (SELECT CodiceSondaggio FROM Invito) = codSondaggio);
END
$ DELIMITER ;

DELIMITER $
CREATE PROCEDURE ReturnAccettati(IN codSondaggio INT)
BEGIN
	SELECT count(*) FROM RispostaInvito WHERE CodiceInvito = (SELECT CodiceNotifica FROM Invito WHERE CodiceSondaggio = codSondaggio) 
		AND Esito = 'ACCETTATO';
END
$ DELIMITER ;

DELIMITER $
CREATE PROCEDURE ReturnCodiceNotifica(IN EmailUtente_Inserita varchar(30))
BEGIN
	SELECT CodiceNotifica FROM Notifica WHERE EmailUtente = EmailUtente_Inserita AND Archiviata = false;
END
$ DELIMITER ;

DELIMITER $
CREATE PROCEDURE ReturnCodiceSondaggioInvito(IN CodiceNotifica_Inserito varchar(36))
BEGIN
	SELECT CodiceSondaggio FROM Invito WHERE Codice = (SELECT CodiceInvito WHERE(CodiceNotifica=CodiceNotifica_Inserito));
END
$ DELIMITER ;

DELIMITER $
CREATE PROCEDURE ReturnNomeSondaggio(IN CodiceSondaggio_Inserito varchar(36))
BEGIN
	SELECT Titolo FROM Sondaggio WHERE Codice = CodiceSondaggio_Inserito;
END
$ DELIMITER ;

DELIMITER $
CREATE PROCEDURE ReturnInvitati()
BEGIN
	SELECT COUNT(*) FROM Utente;
END
$ DELIMITER ;

DELIMITER $
CREATE PROCEDURE CreateNotifica(IN email varchar(30))
BEGIN
	INSERT INTO Notifica(EmailUtente, Data, Archiviata) VALUES(email, current_date(), false);
END
$ DELIMITER ;

DELIMITER $
CREATE PROCEDURE GetCodiceNotifica()
BEGIN
	SELECT CodiceNotifica FROM Notifica;
	INSERT INTO Notifica(EmailUtente, Data, Archiviata) VALUES(email, current_date(), false);
END
$ DELIMITER;

DELIMITER $
CREATE PROCEDURE AddInvito(IN codSondaggio INT, email varchar(30))
BEGIN
	DECLARE codiceDaInserire varchar(36);
	set codiceDaInserire = uuid();
	INSERT INTO Notifica(Codice, EmailUtente, Data, Archiviata) VALUES(codiceDaInserire, email, current_date(), false);
	INSERT INTO Invito(CodiceNotifica, CodiceSondaggio) VALUES(codiceDaInserire, codSondaggio);
END
$ DELIMITER;

DELIMITER $
CREATE PROCEDURE ReturnDomains()
BEGIN
	SELECT Argomento FROM Dominio;
END
$ DELIMITER ;

DELIMITER $
CREATE PROCEDURE AddAppartenenza (IN codiceSondaggio int, argomentoDominio varchar(30))

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
CREATE PROCEDURE AddSondaggio (IN Titolo_Inserito varchar(30),  MaxUtenti_Inserito INT, DataChiusura_Inserita DATE, Stato_Inserito varchar(30), EmailCreatore_Inserita VARCHAR(30))
BEGIN
	IF((SELECT count(*) FROM Azienda WHERE(IndirizzoEmail=EmailCreatore_Inserita))>0) THEN
		INSERT INTO Sondaggio (Titolo, MaxUtenti, DataCreazione, DataChiusura, Stato, EmailCreatoreAzienda) 
			VALUES (Titolo_Inserito, MaxUtenti_Inserito, current_date(), DataChiusura_Inserita, Stato_Inserito, EmailCreatore_Inserita);
	ELSE
		INSERT INTO Sondaggio (Titolo, MaxUtenti, DataCreazione, DataChiusura, Stato, EmailCreatorePremium) 
			VALUES (Titolo_Inserito, MaxUtenti_Inserito, current_date(), DataChiusura_Inserita, Stato_Inserito, EmailCreatore_Inserita);
    END IF;
END
$ DELIMITER ;

DELIMITER $
CREATE PROCEDURE AcceptInvito (IN CodiceNotifica_Inserito VARCHAR(36))
BEGIN
	UPDATE NotificaInvito SET Archiviato = true WHERE(CodiceNotifica=CodiceNotifica_Inserito);
    INSERT INTO Associazione VALUES((SELECT CodiceSondaggio FROM Invito WHERE(Codice=(SELECT CodiceInvito FROM NotificaInvito WHERE(CodiceNotifica=CodiceNotifica_Inserito)))), (SELECT EmailUtente FROM NotificaInvito WHERE(CodiceNotifica=CodiceNotifica_Inserito)));
	UPDATE Invito SET Esito = "ACCETTATO" WHERE(Codice = (SELECT CodiceInvito FROM NotificaInvito WHERE(CodiceNotifica=CodiceNotifica_Inserito)));
END 
$
DELIMITER ;

DELIMITER $
CREATE PROCEDURE DenyInvito (IN CodiceNotifica_Inserito VARCHAR(36))
BEGIN
	UPDATE NotificaInvito SET Archiviato = true WHERE(CodiceNotifica=CodiceNotifica_Inserito);
    UPDATE Invito SET Esito = "RIFIUTATO" WHERE(Codice = (SELECT CodiceInvito FROM NotificaInvito WHERE(CodiceNotifica=CodiceNotifica_Inserito)));
END 
$
DELIMITER ;

DELIMITER $
CREATE PROCEDURE GetNotificationType (IN CodiceNotifica_Inserito VARCHAR(36))
sp1:BEGIN
		DECLARE Tipo VARCHAR(6);
		
		IF(SELECT count(*) FROM NotificaInvito WHERE(CodiceNotifica = CodiceNotifica_Inserito)>0) THEN
			SET Tipo = "Invito";
			SELECT Tipo;
			LEAVE sp1;
		END IF;
		IF(SELECT count(*) FROM NotificaInvito WHERE(CodiceNotifica = CodiceNotifica_Inserito)>0) THEN
			SET Tipo = "Premio";
			SELECT Tipo;
		END IF;
	END 
$
DELIMITER ;

DELIMITER $
CREATE PROCEDURE ReturnSondaggio(IN codiceS varchar(36))
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

/*DA RIVEDERE*/
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
    IF(SELECT count(*) FROM Sondaggio WHERE(Codice=CodiceSondaggio_Inserito) > 0) THEN
		IF((SELECT EmailCreatorePremium FROM Sondaggio WHERE(Codice=CodiceSondaggio_Inserito)) IS NULL) THEN
			SELECT EmailCreatoreAzienda FROM Sondaggio WHERE(Codice=CodiceSondaggio_Inserito);
        ELSE
			SELECT EmailCreatorePremium FROM Sondaggio WHERE(Codice=CodiceSondaggio_Inserito);
        END IF;
	END IF;
END
$ DELIMITER ;

DELIMITER $
CREATE PROCEDURE ReturnCodiceAzienda(IN email varchar(30))
BEGIN
	SELECT CodiceFiscale FROM Azienda WHERE IndirizzoEmail = email;
END
$ DELIMITER;

DELIMITER $
CREATE PROCEDURE ReturnAzienda(IN CodiceFiscale_Inserito varchar(30))
BEGIN
	SELECT * FROM Azienda WHERE CodiceFiscale = CodiceFiscale_Inserito;
END
$ DELIMITER;

DELIMITER $
CREATE PROCEDURE ReturnProPic(IN Email_Inserita varchar(30))
BEGIN
	IF((SELECT count(*) FROM Utente WHERE(Email = Email_Inserita)) > 0) THEN
		SELECT * FROM Utente WHERE(Email = Email_Inserita);
    END IF;
    
    IF((SELECT count(*) FROM Azienda WHERE(IndirizzoEmail = Email_Inserita)) > 0) THEN
		SELECT * FROM Azienda WHERE(IndirizzoEmail = Email_Inserita);
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

DELIMITER $
CREATE PROCEDURE PromoteToAdmin(IN Email_Inserita varchar(30))
BEGIN
	INSERT INTO UtenteAmministratore VALUES(Email_Inserita);
END
$ DELIMITER ;

DELIMITER $
CREATE PROCEDURE AddDomain(IN  Argomento_Inserito VARCHAR(30), Descrizione_Inserita VARCHAR(30))
BEGIN
	INSERT INTO Dominio VALUES(Argomento_Inserito, Descrizione_Inserita);
END
$ DELIMITER ;

DELIMITER $
CREATE PROCEDURE RemoveDomain(IN  Argomento_Inserito VARCHAR(30))
BEGIN
	DELETE FROM Dominio WHERE(Argomento = Argomento_Inserito);
END
$ DELIMITER ;

DELIMITER $
CREATE PROCEDURE CheckDomain(IN  Argomento_Inserito VARCHAR(30))
BEGIN
	SELECT count(*) FROM Dominio WHERE(Argomento = Argomento_Inserito);
END
$ DELIMITER ;

DELIMITER $
CREATE PROCEDURE GetSondaggiSimpleUser(IN emailUtente VARCHAR(30))
BEGIN
	SELECT Codice, MaxUtenti, Titolo, DataChiusura, DataCreazione FROM Sondaggio JOIN Associazione ON Sondaggio.Codice = Associazione.CodiceSondaggio WHERE (EmailUtente='$emailUtente');
END
$ DELIMITER ;

DELIMITER $
CREATE PROCEDURE GetSondaggiPremium(IN emailUtente VARCHAR(30))
BEGIN
	SELECT Codice, MaxUtenti, Titolo, DataChiusura, DataCreazione FROM Sondaggio JOIN CreazionePremium ON Sondaggio.Codice = CreazionePremium.CodiceSondaggio WHERE EmailUtentePremium='$emailUtente';
END
$ DELIMITER ;

DELIMITER $
CREATE PROCEDURE AddSubscription(IN EmailUtente_Inserita VARCHAR(30), FineAbbonamento_Inserito Date, Costo_Inserito DOUBLE)
BEGIN
	INSERT INTO UtentePremium(Emailutente, InizioAbbonamento, FineAbbonamento, Costo) VALUES(Emailutente_Inserita, current_date(), FineAbbonamento_Inserito, Costo_Inserito);
END
$ DELIMITER ;

DELIMITER $
CREATE PROCEDURE RemoveSubscription(IN EmailUtente_Inserita VARCHAR(30))
BEGIN
	DELETE FROM UtentePremium WHERE(EmailUtente = EmailUtente_Inserita);
END
$ DELIMITER ;

DELIMITER $
CREATE PROCEDURE IncreaseSubscription(IN EmailUtente_Inserita VARCHAR(30), TipoIncremento INT)
BEGIN
	IF(TipoIncremento = 1) THEN
		UPDATE UtentePremium SET FineAbbonamento=DATE_ADD(FineAbbonamento, INTERVAL 1 DAY) WHERE(EmailUtente=EmailUtente_Inserita);
    ELSEIF(TipoIncremento = 2) THEN
		UPDATE UtentePremium SET FineAbbonamento=DATE_ADD(FineAbbonamento, INTERVAL 1 MONTH) WHERE(EmailUtente=EmailUtente_Inserita);
    ELSEIF(TipoIncremento = 3) THEN
		UPDATE UtentePremium SET FineAbbonamento=DATE_ADD(FineAbbonamento, INTERVAL 1 YEAR) WHERE(EmailUtente=EmailUtente_Inserita);
    END IF;
END
$ DELIMITER ;

DELIMITER $
CREATE PROCEDURE DecreaseSubscription(IN EmailUtente_Inserita VARCHAR(30), TipoDecremento INT)
BEGIN
	IF(TipoDecremento = 1) THEN
		UPDATE UtentePremium SET FineAbbonamento=DATE_SUB(FineAbbonamento, INTERVAL 1 DAY) WHERE(EmailUtente=EmailUtente_Inserita);
    ELSEIF(TipoDecremento = 2) THEN
		UPDATE UtentePremium SET FineAbbonamento=DATE_SUB(FineAbbonamento, INTERVAL 1 MONTH) WHERE(EmailUtente=EmailUtente_Inserita);
    ELSEIF(TipoDecremento = 3) THEN
		UPDATE UtentePremium SET FineAbbonamento=DATE_SUB(FineAbbonamento, INTERVAL 1 YEAR) WHERE(EmailUtente=EmailUtente_Inserita);
    END IF;
END
$ DELIMITER ;
