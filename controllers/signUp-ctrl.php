<?php
// constantes
require_once __DIR__.'/../config/constants.php';
// Variables
// Tableau des options de langages de programmation
$langages = [
    'html' => 'HTML/CSS',
    'php' => 'PHP',
    'js' => 'Javascript',
    'python' => 'Python',
    'other' => 'Autres'
];
//tableau des genres
$tabGenre = ['monsieur', 'madame'];
$tabCountry = ['France', 'Belgique', 'Suisse', 'Luxembourg', 'Allemagne', 'Italie', 'Espagne', 'Portugal'];
$SelectedMonth = ['Janvier', 'fevrier', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'Septembre', 'Octobre', 'novembre', 'décembre'];
// Variables pour les sélecteurs de date - (essayer de les mettres en dynamique +10 -10)
$startYear = 1913;
$endYear = 2023;
// Condition pour récupérer la méthode POST - à ne faire qu'une seule fois
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Nettoyage et verification du Nom
    $errors = array();
    $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_SPECIAL_CHARS);
    if (empty($lastname)) {
        $errors['lastname'] = 'La donnée n\'est pas renseignée !';
    } else {
        $isOk = filter_var($lastname, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Zéèôàîï \-]{2,50}$/")));
        if (!$isOk) {
            $errors['lastname'] = 'La donnée n\'est pas valide!';
        }
    }
    // XP minimum char
    $xp = filter_input(INPUT_POST, 'xp', FILTER_SANITIZE_SPECIAL_CHARS);
    if (strlen($xp) < 100) {
        $errors['xp'] = 'Votre expérience doit contenir au moins 100 caractères.';
    }
    // Traitement de l'upload de la photo
    if (isset($_FILES["picture"]) && $_FILES["picture"]["error"] == 0) {
        // Dossier créer dans le rep du site en manuel
        $target_dir = __DIR__."/../public/uploads/";
        $target_file = $target_dir . basename($_FILES["picture"]["name"]);
        $uploadOk = 1;
        // strtolower = minuscule - pathinfo = chemin systeme - nom du ficher et recherche de l'extension dans la super globale $_FILES
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        // Utilisation de finfo pour vérifier le type MIME du fichier
        // finfo classe intégrée en PHP qui est utilisée pour obtenir des informations sur un fichier. Elle fait partie de l'extension FileInfo
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        // méthode de l'objet FileInfo qui lit le contenu du fichier spécifié et détermine son type MIME.
        $fileMimeType = $finfo->file($_FILES["picture"]["tmp_name"]);
        if (in_array($fileMimeType, ['image/jpeg', 'image/png', 'image/gif'])) {
            // Fichier est une image valide
        } else {
            $errors['picture'] = 'Le fichier n\'est pas une image valide.';
            $uploadOk = 0;
        }
        // Autres vérifications et tentative d'upload
        if ($uploadOk == 1) {
            if (!move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
                $errors['picture'] = 'Erreur lors du téléchargement de votre fichier.';
            }
        }
    } else {
        if (isset($_FILES["picture"]) && $_FILES["picture"]["error"] != 0) {
            $errors['picture'] = 'Erreur lors du téléchargement du fichier.';
        }
    }
    // Mot de passe et hash
    // Récupération des mots de passe
    $password1 = filter_input(INPUT_POST, 'password1', FILTER_SANITIZE_SPECIAL_CHARS);
    $password2 = filter_input(INPUT_POST, 'password2', FILTER_SANITIZE_SPECIAL_CHARS);
    // Validation des mots de passe
    if (empty($password1) || empty($password2)) {
        $errors['password'] = 'Le mot de passe n\'est pas renseigné !';
    } elseif ($password1 !== $password2) {
        $errors['password'] = 'Les mots de passe ne correspondent pas !';
    } else {
        // Vérification de la complexité du mot de passe
        $pattern = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/";
        // preg_match — Effectue une recherche de correspondance avec une expression rationnelle standard
        if (!preg_match($pattern, $password1)) {
            $errors['password'] = 'Le mot de passe n\'est pas valide!';
        } else {
            // Le mot de passe est valide, procéder au hachage
            $hashedPassword = password_hash($password1, PASSWORD_BCRYPT);
        }
    }
    // verification checkbox
    $selectedLangages = [];
    // Parcourez le tableau des langages et vérifiez chaque case à cocher
    foreach ($langages as $key => $value) {
        if (!empty($_POST[$key])) {
            // Ajoutez le langage au tableau s'il est coché
            $selectedLangages[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
        }
    }
    foreach ($selectedLangages as $key => $value) {
        // Vérifie si une clé existe dans un tableau
        if (!array_key_exists($key, $langages)) {
            // Ajouter une erreur si la clé n'existe pas dans le tableau des langages prédéfinis
            $errors['langages'] = 'La sélection n\'est pas valide!';
        }
    }
    if (!in_array($langages, $selectedLangages)) {
        $errors['langages'] = 'La sélection n\'est pas valide!';
    }
    // Nettoyage et récupération du pays de naissance
    $country = filter_input(INPUT_POST, 'country', FILTER_SANITIZE_SPECIAL_CHARS);
    if (empty($country)) {
        $errors['country'] = 'Le pays n\'est pas renseignée !';
    } else {
        if (!in_array($country, $tabCountry)) {
            $errors['country'] = 'Le pays n\'est pas valide!';
        }
    }
    // Nettoyage et verification de l'email
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    if (empty($email)) {
        $errors['email'] = 'Le mail n\'est pas renseignée !';
    } else {
        $isOk = filter_var($email, FILTER_VALIDATE_EMAIL);
        if (!$isOk) {
            $errors['email'] = 'Le mail n\'est pas valide !';
        }
    }
    // Nettoyage et vérification de la date dans le format "Y-m-d"
    $birthdate = filter_input(INPUT_POST, 'birthdate', FILTER_SANITIZE_SPECIAL_CHARS);
    $isOk = true;
    if (!empty($birthdate)) {
        $isOk = filter_var($birthdate, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => '/' . BIRTH_DATE . '/')));
    }
    if (!$isOk) {
        $errors['birthdate'] = 'La date n\'est pas valide!';
    }
    // Après avoir validé le format de la date
    if ($isOk) {
        $currentYear = date('Y');
        $minYear = $currentYear - 120;
        // Extraire l'année de la date de naissance
        $birthYear = substr($birthdate, 0, 4);
        if ($birthYear < $minYear || $birthYear > $currentYear) {
            $errors['birthdate'] = 'La date de naissance n\'est pas valide. L\'âge doit être inférieur à 120 ans.';
            $isOk = false;
        }
    }
    if (!$isOk) {
        $errors['birthdate'] = 'La date n\'est pas valide!';
    }
    // Nettoyage et vérification du lien
    $linkedin = filter_input(INPUT_POST, 'linkedin', FILTER_SANITIZE_URL);
    if (empty($linkedin)) {
        $errors['linkedin'] = 'Le lien n\'est pas renseignée !';
    } else {
        $isOk = filter_var($linkedin, FILTER_VALIDATE_URL);
        if (!$isOk) {
            $errors['linkedin'] = 'Le lien n\'est pas valide !';
        } else {
            // Extraction du domaine de l'URL avec le shéma
            $domain = parse_url($linkedin, PHP_URL_HOST);
            // Vérification si le domaine est linkedin.com
            if ($domain != 'www.linkedin.com' && $domain != 'linkedin.com') {
                $errors['linkedin'] = 'Le lien doit être un lien LinkedIn valide !';
            }
        }
    }
    // 
    // Nettoyage et verification du code postal
    $cp = filter_input(INPUT_POST, 'cp', FILTER_SANITIZE_NUMBER_INT);
    if (!empty($cp)) {
        $isOk = filter_var($cp, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => '/' . POSTAL_CODE . '/')));
    }
    if (!$isOk) {
        $errors['cp'] = 'Le code postal n\'est pas valide!';
    }
    // Nettoyage et vérification des civilités
    $civil = filter_input(INPUT_POST, 'civil', FILTER_SANITIZE_SPECIAL_CHARS);
    if (empty($civil)) {
        $errors['civil'] = 'Le genre n\'est pas renseignée !';
    } else {
        if (!in_array($civil, $tabGenre)) {
            $errors['civil'] = 'Le genre n\'est pas valide!';
        }
    }
    // Nettoyage du message d'expérience
    $xp = filter_input(INPUT_POST, 'xp', FILTER_SANITIZE_SPECIAL_CHARS);
    if (empty($xp)) {
        $errors['xp'] = 'Le champ expérience est requis.';
    } elseif (strlen($xp) < 100) {
        // Vérifie la longueur de la chaîne si elle n'est pas vide
        $errors['xp'] = 'Votre expérience doit contenir au moins 100 caractères.';
    }
}
include __DIR__.'/../views/templates/header.php';
include __DIR__.'/../views/signUp.php';
include __DIR__.'/../views/templates/footer.php';