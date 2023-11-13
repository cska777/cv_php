<?php

include "includes/header.php";


?>
<div class="container">
    <h1 class="text-center mt-4 mb-4">Connexion </h1>
    <hr>

    <div class="mb-3 w-50 m-auto">
        <input type="email" class="form-control" id="mail" placeholder="Entrez votre adresse email" name="email">
        <div class="error" id="errorMail"></div>
    </div>
    <div class="mb-3 w-50 m-auto">
        <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Entrez votre mot de passe">
        <div class="error" id="errorMdp"></div>
    </div>
    <button type="submit" class="btn btn-primary m-auto " name="connexion" id="connexion">Connexion</button>
    </form>
</div>
</div>
<?php
include "includes/footer.php";

?>