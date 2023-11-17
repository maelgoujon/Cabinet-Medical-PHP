CREATE TABLE Medecin(
   idMedecin VARCHAR(50),
   Civilite VARCHAR(50),
   Prenom VARCHAR(50),
   Nom VARCHAR(50),
   PRIMARY KEY(idMedecin)
);

CREATE TABLE Patient(
   idPatient VARCHAR(50),
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
   idPatient VARCHAR(50) NOT NULL,
   PRIMARY KEY(idConsultation),
   FOREIGN KEY(idMedecin) REFERENCES Medecin(idMedecin),
   FOREIGN KEY(idPatient) REFERENCES Patient(idPatient)
);
