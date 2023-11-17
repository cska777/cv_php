<?php

include "includes/header.php";
include "config/config.php";
include "functions/function.php";

listEtudiant($db);
$etudiants = listEtudiant($db);





?>
<div class="container">
  <h1 class="text-center mt-4 mb-4">Étudiants </h1>
  <hr>
</div>


<div id="etudiantDiv">
  <table class="table table-bordered" id="etudiantTab">
    <thead>
      <tr>
        <th scope="col">N°</th>
        <th scope="col">Prénom</th>
        <th scope="col">Nom</th>
        <th scope="col">Adresse Email</th>
        <th scope="col"></th>
</thead>
<?php
  if(!empty($etudiants)){
    foreach($etudiants as $etudiant){
    ?>
    <tbody>
    <tr>
      <th scope="row"><?=$etudiant["id"]?></th>
      <th scope= "row"><?= ucfirst($etudiant["prenom"]) ?></th>
      <td><?= ucfirst($etudiant["nom"])?></td>
      <td><?= $etudiant["email"]?></td>
      <td class="d-flex justify-content-around">
      <button class="brilliant-button btnModif rounded-3">Modifier</button>
      <button class="brilliant-button btnSupp rounded-3">Supprimer</button>
    </td>
    </tr>

    </tbody>


    <?php
    }
  }

?>

</table>

  <div class="d-flex justify-content-between">
  <a href="index.php"><button type="button" class="btn btn-outline-dark" id="cardsEtudiant">Voir les cartes</button></a>
    <a href="etudiantForm.php"><button type="button" class="btn btn-outline-info" id="ajoutEtudiant">Ajouter un étudiant</button></a>
  </div>
</div>

<script src="assets/js/etudiant.js"></script>
<?php
include "includes/footer.php";

?>