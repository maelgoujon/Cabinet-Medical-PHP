CREATE TABLE Medecin(
   idMedecin VARCHAR(50),
   Civilite VARCHAR(50),
   Prenom VARCHAR(50),
   Nom VARCHAR(50),
   PRIMARY KEY(idMedecin)
);

CREATE TABLE Patient(
   idPatient INT AUTO_INCREMENT,
   Civilite VARCHAR(50),
   Prenom VARCHAR(50),
   Nom VARCHAR(50),
   Adresse VARCHAR(50),
   Date_de_naissance VARCHAR(50),
   Lieu_de_naissance VARCHAR(50),
   Numero_Securite_Sociale VARCHAR(50),
   idMedecin VARCHAR(50) NOT NULL,
   PRIMARY KEY(idPatient),
   FOREIGN KEY(idMedecin) REFERENCES Medecin(idMedecin)
);

CREATE TABLE Consultations(
   idConsultation VARCHAR(50),
   Date_Consultation VARCHAR(50),
   Heure_ VARCHAR(50),
   Duree INT DEFAULT 30,
   idMedecin VARCHAR(50) NOT NULL,
   idPatient INT NOT NULL,
   PRIMARY KEY(idConsultation),
   FOREIGN KEY(idMedecin) REFERENCES Medecin(idMedecin),
   FOREIGN KEY(idPatient) REFERENCES Patient(idPatient)
);


insert into `medecin` (`Civilite`, `Nom`, `Prenom`, `idMedecin`) values ('Monsieur', 'NomMichel', 'PrenomMichel', '1');
insert into `medecin` (`Civilite`, `Nom`, `Prenom`, `idMedecin`) values ('Madame', 'NomMichelle', 'PrenomMichelle', '2');

insert into `patient` (`Adresse`, `Civilite`, `Date_de_naissance`, `Lieu_de_naissance`, `Nom`, `Numero_Securite_Sociale`, `Prenom`, `idMedecin`, `idPatient`) values ('chezmoi', '1', '121212', 'lieunaissance', 'michel', '454545', 'michel', '1', 1);
insert into `patient` (`Adresse`, `Civilite`, `Date_de_naissance`, `Lieu_de_naissance`, `Nom`, `Numero_Securite_Sociale`, `Prenom`, `idMedecin`, `idPatient`) values ('chezelle', '2', '111111', 'lieunaissance', 'michelle', '444444', 'michelle', '2', 3);
