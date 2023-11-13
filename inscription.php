
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "includes/header.php";
require_once "config/config.php";
include  "functions/function.php";

global $db;

?>

<div class="container ">
    <h1 class="text-center mt-4 mb-4">Inscription</h1>
    <hr>
    <form id="inscriptionForm" method="post" action="">

        
    <?php
    // Initialisation des messages
    $errors = [];
    $success = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $result = addUser($db);

        // Vérifier si des erreurs existent
        if (isset($result['errors'])) {
            $errors = $result['errors'];
        }

        // Vérifier si le message de succès existe
        if (isset($result['success'])) {
            $success = $result['success'];
        }
    }

    // Plus tard, dans votre HTML :
    if (!empty($errors)) {
        echo "<div class='alert alert-danger'>";
        foreach ($errors as $error) {
            echo $error;
        }
        echo "</div>";
    }


    // Afficher le message de succès si l'utilisateur a été créé
    if ($success !== '') {
        echo "<div class='alert alert-success'>$success</div>";
    }

    ?>
     
        <div class="mb-3">
            <input type="text" class="form-control" id="prenom" placeholder="Entrez votre prénom" name="prenom">
            <div class="error" id="errorPrenom"></div>
        </div>
        <div class="mb-3">
            <input type="text" class="form-control" id="nom" placeholder="Entrez votre nom" name="nom">
            <div class="error" id="errorNom"></div>
        </div>
        <div class="mb-3">
            <input type="email" class="form-control" id="mail" placeholder="Entrez votre adresse email" name="email">
            <div class="error" id="errorMail"></div>
        </div>
        <div class="mb-3">
            <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Créez un mot de passe">
            <div class="error" id="errorMdp"></div>
        </div>
        <div class="mb-3">
            <input type="password" class="form-control" id="mdpConfirm" name="mdpConfirm" placeholder="Confirmer votre mot de passe">
            <div class="error" id="errorMdpConfirm"></div>
        </div>
        <button type="submit" class="btn btn-primary w-50 m-auto " name="valider" id="valider">Valider</button>
    </form>
</div>

<script src="assets/js/script.js"></script>

<?php
include "includes/footer.php";

?>