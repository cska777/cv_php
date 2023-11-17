<?php session_start() ?>

<nav class="navbar bg-dark w-100">
    <div class="container-fluid">
        <a class="navbar-brand text-light" href="index.php">Accueil</a>
        <?php
        if(isset($_SESSION["user_email"])){
            ?>
            <a class="navbar-brand text-light"><h3>Bonjour <?= $_SESSION["user_prenom"]." ".$_SESSION["user_nom"]?> </h3></a>
            <?php
        ?>
        <div class="btn-group dropstart">
            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa-solid fa-bars"></i>
            </button>
            <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="etudiant.php">Étudiants</a></li>
                    <li><a class="dropdown-item" href="competences.php">Compétences</a></li>
                    <li><a class="dropdown-item" href="formation.php">Formation</a></li>
                    <li><a class="dropdown-item" href="experiences.php">Expériences</a></li>
                    <li><a class="dropdown-item" href="deconnexion.php">Deconnexion</a></li>
                <?php
                }
                ?>
            </ul>
        </div>
    </div>

</nav>