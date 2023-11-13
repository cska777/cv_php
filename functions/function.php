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
    $stmt = $db->prepare("SELECT COUNT(*) FROM etudiants WHERE email = :email");
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
            $stmt = $db->prepare("INSERT INTO etudiants (nom, prenom, email, password) VALUES (:nom, :prenom, :email, :mdp)");

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

// Vous pouvez appeler cette fonction plus tard en utilisant votre formulaire
?>
