DROP DATABASE IF EXISTS EForm;
CREATE DATABASE EForm;

USE EForm;

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
    Email VARCHAR(30) PRIMARY KEY,
    Nome VARCHAR(30),
    Cognome VARCHAR(30),
    Anno INT,
    LuogoNascita VARCHAR(30),
    TotaleBonus INT
) ENGINE = "INNODB";

CREATE TABLE UtentePremium(
    Emailutente VARCHAR(30) PRIMARY KEY,
    InizioAbbonamento date,
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
    EmailPremium VARCHAR(30),
    FOREIGN KEY (ArgomentoDominio) REFERENCES Dominio(Argomento),
    FOREIGN KEY (EmailPremium) REFERENCES UtentePremium(EmailUtente)
) ENGINE = "INNODB";

CREATE TABLE DomandaAperta(
    Id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Testo VARCHAR(30),
    Punteggio INT,
    Foto VARCHAR(50),
    MaxCaratteri INT,
    CodiceSondaggio INT,
    CodiceAzienda VARCHAR(30),
    EmailPremium VARCHAR(30),
	FOREIGN KEY (CodiceSondaggio) REFERENCES Sondaggio(Codice),
    FOREIGN KEY (CodiceAzienda) REFERENCES Azienda(CodiceFiscale),
    FOREIGN KEY (EmailPremium) REFERENCES UtentePremium(EmailUtente)
) ENGINE = "INNODB";

CREATE TABLE DomandaChiusa(
    Id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Testo VARCHAR(30),
    Punteggio INT,
    Foto VARCHAR(50),
    CodiceSondaggio INT,
    CodiceAzienda VARCHAR(30) NOT NULL,
    EmailPremium VARCHAR(30),
	FOREIGN KEY (CodiceSondaggio) REFERENCES Sondaggio(Codice),
    FOREIGN KEY (CodiceAzienda) REFERENCES Azienda(CodiceFiscale),
    FOREIGN KEY (EmailPremium) REFERENCES UtentePremium(EmailUtente)
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
    NumeroOpzione INT,
    IdDomanda INT,
    EmailUtente VARCHAR(30),
	FOREIGN KEY (NumeroOpzione) REFERENCES Opzione(Numero),
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

CREATE TABLE Invito(
    Codice INT PRIMARY KEY,
    CodiceSondaggio INT,
    Esito ENUM ('ACCETTATO', 'RIFIUTATO'),
    FOREIGN KEY (CodiceSondaggio) REFERENCES Sondaggio(Codice)
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
    EmailAdmin VARCHAR(30),
    FOREIGN KEY (EmailAdmin) REFERENCES UtenteAmministratore(EmailUtente)
) ENGINE = "INNODB";

CREATE TABLE Vincita(
    EmailUtente VARCHAR(30),
    NomePremio VARCHAR(30),
    DataVincita Date,
    PRIMARY KEY(EmailUtente, NomePremio, DataVincita),
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
    CodiceInvito INT,
    EmailUtente VARCHAR(30),
    Esito ENUM ('ACCETTATO', 'RIFIUTATO'),
    PRIMARY KEY(EmailUtente, CodiceInvito),
    FOREIGN KEY (CodiceInvito) REFERENCES Invito(Codice),
    FOREIGN KEY (EmailUtente) REFERENCES Utente(Email)
) ENGINE = "INNODB";