<?php
include "includes/header.php";
include "config/config.php";
include "functions/function.php";

$page = isset($_GET["page"]) ? intval($_GET["page"]) : 1; // Valeur par défaut pour $page
$etudiantsParPage = 8;
$stmtPage = $db->query("SELECT COUNT(*) FROM etudiants");
$totEtudiants = $stmtPage->fetchColumn();
$nbPages = ceil($totEtudiants / $etudiantsParPage);

$etudiants = listEtudiant($db, $page, $etudiantsParPage);

?>

<div class="container" id="containerIndex">
    <?php
    if (isset($_SESSION["user_email"])) {
    ?>
        <div class="containerCards text-center">
            <h1 class="border-bottom mt-4 mb-4">Cartes des étudiants</h1>
            <div class="d-flex justify-content-between mb-4 mt-4">
                <a href="etudiant.php"><button type="button" class="btn btn-outline-dark rounded-3" id="listEtudiant">Liste des étudiants</button></a>
                <a href="etudiantForm.php"><button type="button" class="btn btn-outline-info rounded-3" id="ajoutEtudiant">Ajouter un étudiant</button></a>
            </div>
            <div class="cards d-flex flex-wrap">
                <?php
                foreach ($etudiants as $etudiant) {
                ?>
                    <div class="card m-3" style="width: 18rem;">
                        <div class="card-header text-center">
                            <h4>Étudiant #<?= $etudiant["id"] ?> </i></h4>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Nom : </strong><?= ucfirst($etudiant["nom"]) ?></li>
                            <li class="list-group-item"><strong>Prénom : </strong><?= ucfirst($etudiant["prenom"]) ?></li>
                            <li class="list-group-item"><strong>Email : </strong><?= $etudiant["email"] ?></li>
                            <li class="list-group-item d-flex justify-content-around p-3">
                                <a href="mailto:<?= $etudiant["email"] ?>"><button class="brilliant-button btnMail rounded-3">Mail</button></a>
                                <button class="brilliant-button btnModif rounded-3">Modifier</button>
                                <button class="brilliant-button btnSupp rounded-3">Supprimer</button>
                            </li>
                        </ul>
                    </div>
                <?php
                }
                ?>
            </div>
        </div> 

        <nav aria-label="Page navigation">
            <ul class="pagination d-flex justify-content-center pagination-sm mb-4 mt-4">
                <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="visually-hidden">Previous</span>
                    </a>
                </li>

                <li class="page-item <?php echo $page === 1 ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=1">1</a>
                </li>

                <?php for ($i = 2; $i <= $nbPages; $i++) : ?>
                    <li class="page-item <?php echo $page === $i ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>

                <li class="page-item <?php echo $page >= $nbPages ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $page + 1; ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="visually-hidden">Next</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div> 

    <?php 
    include "includes/footer.php";
    } else {
    ?>
        <h1 class="text-center mt-4 mb-4">Accueil</h1>
        <div class="btnDiv">
            <a href="connexion.php"><button type="button" class="btn btn-secondary mt-4 mb-5 w-100" id="btnConnexion">Connexion</button></a><br>
            <a href="inscription.php"><button type="button" class="btn btn-secondary w-100" id="btnInscription">Inscription</button></a>
        </div>
    <?php
    }
    ?>


