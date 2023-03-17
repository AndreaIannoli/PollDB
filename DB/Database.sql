DROP DATABASE IF EXISTS PollDB;
CREATE DATABASE PollDB;

USE PollDB;

CREATE TABLE Dominio(
    Argomento VARCHAR(30) PRIMARY KEY,
    Descrizione VARCHAR(30)
) ENGINE = "INNODB";

CREATE TABLE Azienda(
    CodiceFiscale VARCHAR(30) PRIMARY KEY,
    Nome VARCHAR(30),
    Sede VARCHAR(30),
    IndirizzoEmail VARCHAR(30)
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

CREATE TABLE UtentePremium(
    Emailutente VARCHAR(30) PRIMARY KEY,
    InizioAbbonamento Date,
    FineAbbonamento Date,
    Costo DOUBLE(10,6),
    NumSondaggi INT,
    FOREIGN KEY (EmailUtente) REFERENCES Utente(Email)
) ENGINE = "INNODB";

CREATE TABLE Sondaggio(
    Codice INT NOT NULL PRIMARY KEY,
    MaxUtenti INT NOT NULL,
    Stato ENUM ('APERTO', 'CHIUSO'),
	Titolo VARCHAR(30) NOT NULL,
    DataChiusura Date,
    DataCreazione Date,
    ArgomentoDominio VARCHAR(30),
    EmailPremium VARCHAR(30)
) ENGINE = "INNODB";

CREATE TABLE Domanda(
	Id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Testo VARCHAR(200) NOT NULL
    
) ENGINE = "INNODB";

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

CREATE TABLE DomandaAperta(
    Id INT NOT NULL PRIMARY KEY,
    Testo VARCHAR(200) NOT NULL,
    MaxCaratteri INT,
    
    FOREIGN KEY(Id) REFERENCES Domanda(Id)
) ENGINE = "INNODB";

CREATE TABLE DomandaChiusa(
    Id INT NOT NULL PRIMARY KEY,
    Testo VARCHAR(200) NOT NULL,
    
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
    CodiceAzienda VARCHAR(30),
    PRIMARY KEY (IdDomanda, CodiceAzienda),
    FOREIGN KEY (IdDomanda) REFERENCES DomandaChiusa(Id),
    FOREIGN KEY (IdDomanda) REFERENCES DomandaAperta(Id),
    FOREIGN KEY (CodiceAzienda) REFERENCES Azienda(CodiceFiscale)
) ENGINE = "INNODB";

CREATE TABLE CreazioneAziendale(
    CodiceSondaggio INT,
    CodiceAzienda VARCHAR(30),
    PRIMARY KEY (CodiceSondaggio, CodiceAzienda),
    FOREIGN KEY (CodiceSondaggio) REFERENCES Sondaggio(Codice),
    FOREIGN KEY (CodiceAzienda) REFERENCES Azienda(CodiceFiscale)
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

CREATE TABLE Invito(
    Codice INT PRIMARY KEY,
    CodiceSondaggio INT,
    Esito ENUM ('ACCETTATO', 'RIFIUTATO'),
    EmailUtente VARCHAR(30)
) ENGINE = "INNODB";

CREATE TABLE UtenteAmministratore(
    Emailutente VARCHAR(30) PRIMARY KEY,
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

CREATE TABLE Ricezione(
    CodiceInvito INT,
    EmailUtente VARCHAR(30),
    PRIMARY KEY(EmailUtente, CodiceInvito),
    FOREIGN KEY (CodiceInvito) REFERENCES Invito(Codice),
    FOREIGN KEY (EmailUtente) REFERENCES Utente(Email)
) ENGINE = "INNODB";

CREATE TABLE RispostaInvito(
    CodiceInvito INT PRIMARY KEY,
    EmailUtente VARCHAR(30),
    Esito ENUM ('ACCETTATO', 'RIFIUTATO'),
    FOREIGN KEY (CodiceInvito) REFERENCES Invito(Codice)
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
    FOREIGN KEY (IdDomanda) REFERENCES DomandaChiusa(Id),
	FOREIGN KEY (IdDomanda) REFERENCES DomandaAperta(Id)
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

#Insercisci risposta sondaggio
DELIMITER $
CREATE PROCEDURE InserisciRispostaAperta (IN Testo VARCHAR(30), IdDomanda INT, EmailUtente VARCHAR(30))
BEGIN
	INSERT INTO RispostaAperta VALUES (Testo,IdDomanda,EmailUtente);
END
$
DELIMITER ;

#Inserimento nuovo utente
DELIMITER $
CREATE PROCEDURE RegistrazioneUtenteSemplice (IN Email VARCHAR(30), Pass CHAR(64), Nome VARCHAR(30), Cognome VARCHAR(30), DataDiNascita DATE, LuogoDiNascita VARCHAR(30), TotaleBonus INT)
BEGIN
	INSERT INTO Utente VALUES (Email , sha2(Pass, 256), Nome, Cognome, DataDiNascita, LuogoDiNascita, TotaleBonus);
END
$
DELIMITER ;

DELIMITER $
CREATE PROCEDURE CheckEmail (IN Email_Inserita VARCHAR(30))
BEGIN
	SELECT count(*) AS Counter FROM Utente WHERE(Email = Email_Inserita);
END
$
DELIMITER ;

DELIMITER $
CREATE PROCEDURE CheckCredentials (IN Email_Inserita VARCHAR(30), Pass_Inserita VARCHAR(100))
BEGIN
	SELECT count(*) AS Authorized FROM Utente WHERE(Email = Email_Inserita  AND Pass_Inserita = (SELECT Pass FROM Utente WHERE(Email = Email_Inserita)));
END 
$
DELIMITER ;