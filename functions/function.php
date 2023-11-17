<?php
require_once "config/config.php";

// Fonction pour nettoyer les données du formulaire
function cleanInput($data, $type = 'string') {
    switch ($type) {
        case 'email':
            return filter_var(trim($data), FILTER_SANITIZE_EMAIL);
        case 'string':
        default:
            return htmlspecialchars(stripslashes(trim($data)));
    }
}

// Cette fonction permet de valider les données du formulaire et de les insérer dans la base de données
function addUser($db): array {
    // Récupération des données du formulaire
    $nom = cleanInput($_POST['nom'] ?? '');
    $prenom = cleanInput($_POST['prenom'] ?? '');
    $email = cleanInput($_POST['email'] ?? '', 'email');
    $mdp = $_POST['mdp'] ?? '';
    $mdpConfirm = $_POST['mdpConfirm'] ?? '';

    // Tableau pour collecter les erreurs
    $errors = [];

    // Validation des champs
    if (empty($nom)) {
        $errors['nom'] = 'Le nom est requis. ';
    } elseif (strlen($nom) < 2) {
        $errors['nom'] = "Le nom doit contenir au moins 2 caractères. ";
    }

    if (empty($prenom)) {
        $errors['prenom'] = 'Le prénom est requis. ';
    } elseif (strlen($prenom) < 2) {
        $errors['prenom'] = "Le prénom doit contenir au moins 2 caractères. ";
    }

    if (empty($email)) {
        $errors['email'] = 'L\'email est requis. ';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "L'email n'est pas valide. ";
    }

    if (empty($mdp)) {
        $errors['mdp'] = 'Le mot de passe est requis. ';
    } elseif (strlen($mdp) < 8) {
        $errors['mdp'] = "Le mot de passe doit contenir au moins 8 caractères. ";
    }

    if (empty($mdpConfirm)) {
        $errors['mdpConfirm'] = "Veuillez retaper votre mot de passe. ";
    } elseif ($mdp !== $mdpConfirm) {
        $errors['mdpConfirm'] = 'Les mots de passe ne correspondent pas. ';
    }

    // Vérification de l'unicité de l'email
    $stmt = $db->prepare("SELECT COUNT(*) FROM utilisateurs WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->fetchColumn() > 0) {
        $errors['email'] = 'L\'adresse e-mail est déjà utilisée. ';
    }

    // Si aucune erreur, procéder à l'insertion
    if (empty($errors)) {
        // Hashage du mot de passe
        $hashed_password = password_hash($mdp, PASSWORD_DEFAULT);

        // Insertion dans la base de données
        try {
            // On utilise la requête préparée pour éviter les injections SQL
            $stmt = $db->prepare("INSERT INTO utilisateurs (nom, prenom, email, password) VALUES (:nom, :prenom, :email, :mdp)");

            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':prenom', $prenom);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':mdp', $hashed_password);

            $stmt->execute();

            // Retour d'un message de succès
            return ['success' => 'Utilisateur créé avec succès.'];
        } catch (PDOException $e) {
            // Gestion des erreurs liées à la base de données
            $errors['db'] = "Erreur de base de données : " . $e->getMessage();
            return ['errors' => $errors];
        }
    } else {
        // Retour des erreurs si le tableau n'est pas vide
        return ['errors' => $errors];
    }
}


function login($db) {
    $email = cleanInput($_POST["email"] ?? "", "email");
    $mdp = $_POST["mdp"] ?? "";

    $errorsConnexion = [];

    if (empty($email) || empty($mdp)) {
        $errorsConnexion[] = "Veuillez remplir tous les champs";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($mdp) < 8) {
        $errorsConnexion['email'] = "Adresse mail ou mot de passe invalide";
    }

    if (empty($errorsConnexion)) {
        try {
            $stmt = $db->prepare("SELECT id, prenom, nom, password FROM utilisateurs WHERE email = :email");
            $stmt->execute([':email' => $email]);

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                if (password_verify($mdp, $user["password"])) {
                    session_start();

                    $_SESSION["user_nom"] = $user["nom"];
                    $_SESSION["user_prenom"] = $user["prenom"];
                    $_SESSION["user_id"] = $user["id"];
                    $_SESSION["user_email"] = $email;


                    header("Location: index.php");
                    exit;
                } else {
                    $errorsConnexion["mdp"] = "Le mot de passe est incorrect.";
                }
            } else {
                $errorsConnexion["email"] = "Aucun utilisateur trouvé avec cet email.";
            }
        } catch (PDOException $e) {
            $errorsConnexion[] = "Erreur de base de données: " . $e->getMessage();
        }
    }

    return["errorsConnexion" => $errorsConnexion];
}

function ajoutEtudiant(PDO $db): array {
    $listeEtudiant = [];
    $errorsEtudiant = [];

    $nomEtudiant = cleanInput($_POST["nomEtudiant"] ?? "");
    $prenomEtudiant = cleanInput($_POST["prenomEtudiant"] ?? "");
    $emailEtudiant = cleanInput($_POST["emailEtudiant"] ?? "");


    $stmtSelect = $db->prepare("SELECT id,prenom,nom,email FROM etudiants WHERE email = :email");
    $stmtSelect->bindParam(':email', $emailEtudiant);
    $stmtSelect->execute();
    

    if(empty($nomEtudiant)){
        $errorsEtudiant["nomEtudiant"] = "Le nom est requis. ";
    }elseif(strlen($nomEtudiant) < 2 ){
        $errorsEtudiant["nomEtudiant"] = "Le nom doit contenir au moins 2 carractères.";
    }

    if(empty($prenomEtudiant)){
        $errorsEtudiant["prenomEtudiant"] = "Le prénom est requis. ";
    }elseif(strlen($prenomEtudiant) < 2 ){
        $errorsEtudiant["prenomEtudiant"] = "Le nom doit contenir au moins 2 carractères. ";
    }

    if (empty($emailEtudiant)) {
        $errorsEtudiant['emailEtudiant'] = 'L\'email est requis. ';
    } elseif (!filter_var($emailEtudiant, FILTER_VALIDATE_EMAIL)) {
        $errorsEtudiant['emailEtudiant'] = "L'email n'est pas valide. ";
    }

    if ($stmtSelect->fetchColumn() > 0) {
        $errorsEtudiant['emailEtudiant'] = "Un étudiant est déjà créé avec cette adresse e-mail";
    }

    if (empty($errorsEtudiant)) {
        try {
            $stmtInsert = $db->prepare("INSERT INTO etudiants (nom, prenom, email) VALUES (:nom, :prenom, :email)");
            

            $stmtInsert->bindValue(':nom', $nomEtudiant);
            $stmtInsert->bindValue(':prenom', $prenomEtudiant);
            $stmtInsert->bindValue(':email', $emailEtudiant);
    
            $stmtInsert->execute();
    
            header("location: etudiant.php");
            exit;
    
            return ["success" => "Nouvel étudiant ajouté"];
        } catch (PDOException $e) {
            $errorsEtudiant["db"] = "Erreur de base de données : " . $e->getMessage();
            return ["errorsEtudiant" => $errorsEtudiant];
        }
    } else {
        return ["errorsEtudiant" => $errorsEtudiant];
    }

    return $listeEtudiant;
}

function listEtudiant(PDO $db, $page = 1, $etudiantsParPage = 8):array {
    $etudiants = [];
    $debut = ($page - 1) * $etudiantsParPage;

    try {
        $query = "SELECT * FROM etudiants LIMIT :debut, :etudiantsParPage";
        $stmtList = $db->prepare($query);
        $stmtList->bindParam(":debut",$debut,PDO::PARAM_INT);
        $stmtList->bindParam("etudiantsParPage",$etudiantsParPage,PDO::PARAM_INT);
        $stmtList->execute();
        $etudiants = $stmtList->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Erreur de base de données - listEtudiants: " . $e->getMessage());
    }

    return $etudiants;
}

function pagination($db) {
    // Définir la page par défaut si non définie dans l'URL
    $page = isset($_GET["page"]) ? intval($_GET["page"]) : 1;

    $etudiantsParPage = 8;
    $stmtPage = $db->query("SELECT COUNT(*) FROM etudiants");
    $totEtudiants = $stmtPage->fetchColumn();
    $nbPages = ceil($totEtudiants / $etudiantsParPage);

    $liens = "";
    for ($i = 1; $i <= $nbPages; $i++) {
        $activeClass = ($i === $page) ? "active" : "";
        $liens .= "<li class='page-item $activeClass'><a class='page-link' href='?page=$i'>$i</a></li>";
    }

    return $liens;
}


function totEtudiants($db){
    $stmtTot = $db->query("SELECT COUNT(*) FROM etudiants");
    return $stmtTot->fetchColumn();
}


function modifEtudiant($db){
    $idEtudiant = $_POST["id"] ?? "";
    $nomEtudiant = cleanInput($_POST["nomEtudiant"] ?? "");
    $prenomEtudiant = cleanInput($_POST["prenomEtudiant"] ?? "");
    $emailEtudiant = cleanInput($_POST["emailEtudiant"] ?? "");

    $errorsModifEtudiant = [];

    if(empty($nomEtudiant)){
        $errorsModifEtudiant = "Veuillez renseigner un nom. ";
    }elseif(strlen($nomEtudiant)){
        $errorsModifEtudiant = "Le nom doit contenir au moins 2 carractères. ";
    }
    
    if(empty($prenomEtudiant)){
        $errorsModifEtudiant = "Veuillez renseigner un prénom. ";
    }elseif(strlen($prenomEtudiant)){
        $errorsModifEtudiant = "Le prenom doit contenir au moins 2 carractères. ";
    }

    if(empty($emailEtudiant)){
        $errorsModifEtudiant = "Veuillez renseigner une adresse mail. ";
    }elseif(!filter_var($emailEtudiant, FILTER_VALIDATE_EMAIL)){
        $errorsModifEtudiant = "Vous devez saisir une adresse mail valide. ";
    }

    if(empty($idEtudiant) || !is_numeric($idEtudiant)){
        $errorsModifEtudiant = "L'ID de l'utilisateur n'est pas valide";
    }
    
    if(empty($errorsModifEtudiant)){
        $stmtModifEtudiant = $db->prepare("SELECT id FROM etudiants WHERE email = :email AND id != :id");
        $stmtModifEtudiant->execute([":email" => $emailEtudiant, ":id" => $idEtudiant]);
        if($stmtModifEtudiant->fetch()){
            $errorsModifEtudiant["emailEtudiant"] = "L'email est déjà utilisé par un autre étudiant.";
        }
    }
}
?>

