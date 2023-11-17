<?php

include "includes/header.php";
include "config/config.php";
include "functions/function.php";

session_start();


?>
<form method="post" id="connexionForm">

    <?php

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $connexion = login($db);

        if (isset($connexion["errorsConnexion"])) {
            foreach ($connexion["errorsConnexion"] as $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
        }
    }

    ?>

    <div class="container" id="containerConnexion">
        <h1 class="text-center mt-4 mb-4">Connexion </h1>
        <hr>

        <div class="mb-4 w-50 m-auto">
            <input type="email" class="form-control" id="email" placeholder="Entrez votre adresse email" name="email">
            <div class="error" id="errorMail"></div>
        </div>
        <div class="mb-3 w-50 m-auto">
            <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Entrez votre mot de passe">
            <div class="error" id="errorMdp"></div>
        </div>
        <div>
            <button type="submit" class="btn btn-primary m-auto " name="connexion" id="connexion">Connexion</button>
        </div>

        <p>Si vous n'avez pas de compte vous pouvez en créer un en <a href="inscription.php">cliquant ici.</a></p>
    </div>
</form>
<?php
include "includes/footer.php";

?>