<?php

include "includes/header.php";


?>
<div class="container">
    <h1 class="text-center mt-4 mb-4">Inscription</h1>

    <form method="$_POST" class="mb-3">
        <div class="mb-3">
            <label for="" class="form-label">Adresse mail</label>
            <input type="email" class="form-control">
            <div id="emailHelp" class="form-text"></div>
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="exampleInputPassword1">
        </div>
        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-primary w-25">Valider</button>
        </div>
    </form>
</div>
<?php
include "includes/footer.php";

?>