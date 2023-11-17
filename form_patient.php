<label for="civilite">Civilite :</label>
<select id="idPatient" name="civilite">
    <option value="1" <?php echo (isset($patient['Civilite']) && $patient['Civilite'] == '1') ? 'selected' : ''; ?>>Monsieur</option>
    <option value="2" <?php echo (isset($patient['Civilite']) && $patient['Civilite'] == '2') ? 'selected' : ''; ?>>Madame</option>
    <!-- Ajoutez d'autres options si nécessaire -->
</select>
<br>
<label for="nom">Nom :</label>
<input type="text" id="nom" name="nom" value="<?php echo isset($patient['Nom']) ? $patient['Nom'] : ''; ?>" required>
<br>
<label for="prenom">Prenom :</label>
<input type="text" id="prenom" name="prenom" value="<?php echo isset($patient['Prenom']) ? $patient['Prenom'] : ''; ?>" required>
<br>
<label for="adresse">Adresse :</label>
<input type="text" id="adresse" name="adresse" value="<?php echo isset($patient['Adresse']) ? $patient['Adresse'] : ''; ?>" required>
<br>
<label for="date_de_naissance">Date de naissance :</label>
<input type="text" id="date_de_naissance" name="date_de_naissance" value="<?php echo isset($patient['Date_de_naissance']) ? $patient['Date_de_naissance'] : ''; ?>" required>
<br>
<label for="lieu_de_naissance">Lieu de naissance :</label>
<input type="text" id="lieu_de_naissance" name="lieu_de_naissance" value="<?php echo isset($patient['Lieu_de_naissance']) ? $patient['Lieu_de_naissance'] : ''; ?>" required>
<br>
<label for="numero_securite_sociale">Numero de securite sociale :</label>
<input type="text" id="numero_securite_sociale" name="numero_securite_sociale" value="<?php echo isset($patient['Numero_Securite_Sociale']) ? $patient['Numero_Securite_Sociale'] : ''; ?>" required>
<br>
<!-- Champ de sélection du medecin referent -->
<label for="idMedecin">Medecin Referent :</label>
<select id="idMedecin" name="idMedecin">
    <!-- Remplacez les options ci-dessous par les médecins de votre base de données -->
    <option value="1" <?php echo (isset($patient['idMedecin']) && $patient['idMedecin'] == '1') ? 'selected' : ''; ?>>Medecin 1</option>
    <option value="2" <?php echo (isset($patient['idMedecin']) && $patient['idMedecin'] == '2') ? 'selected' : ''; ?>>Medecin 2</option>
    <!-- Ajoutez d'autres options si nécessaire -->
</select>
<br>
