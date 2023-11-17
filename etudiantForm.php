<?php

include "includes/header.php";
include "config/config.php";
include "functions/function.php";


?>

<form class="etudiantForm" method="post" id="etudiantForm">

<?php

$errorsEtudiant = [];
$successEtudiant = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $ajoutEtudiant = ajoutEtudiant($db);

    if (isset($ajoutEtudiant["errorsEtudiant"])) {
        $errorsEtudiant = $ajoutEtudiant["errorsEtudiant"];
    }

    if (isset($ajoutEtudiant['success'])) {
        $successEtudiant = $ajoutEtudiant['success'];
    }

    if (!empty($errorsEtudiant)) {
        echo "<div class='alert alert-danger'>";
        foreach ($errorsEtudiant as $error) {
            echo $error;
        }
        echo "</div>";
    }

    if ($successEtudiant !== '') {
        echo "<div class='alert alert-success'>$successEtudiant</div>";
    }
}
?>

    <h2>Ajouter un étudiant</h2><br>
  <div class="mb-3">
            <input type="text" class="form-control" id="prenom" placeholder="Entrez votre prénom" name="prenomEtudiant">
            <div class="error" id="errorPrenom"></div>
        </div>
        <div class="mb-3">
            <input type="text" class="form-control" id="nom" placeholder="Entrez votre nom" name="nomEtudiant">
            <div class="error" id="errorNom"></div>
        </div>
  <div class="mb-3">
            <input type="email" class="form-control" id="mail" placeholder="Entrez votre adresse email" name="emailEtudiant">
            <div class="error" id="errorMail"></div>
        </div>


  <div class="d-flex justify-content-end">
    <button type="submit" class="btn btn-outline-success nouvelEtudiant" id="nouvelEtudiant">Ajouter un étudiant</button>
  </div>
</div>
</form>
<?php 

include "includes/footer.php";

?>