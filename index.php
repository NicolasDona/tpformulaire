<!-- language date civilité mdp photo xpérience -->
<?php
// constantes
define('POSTAL_CODE', '^[0-9]{5}$');
define('BIRTH_DATE', '^\d{4}-\d{2}-\d{2}$'); // Format YYYY-MM-DD
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
$tabGenre =['monsieur', 'madame'];
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
    }else {
        if (!in_array($civil, $tabGenre)) {
            $errors['civil'] = 'Le genre n\'est pas valide!';
        }
    }
}

?>
<span class="regular"><?= var_dump($civil); ?></span>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TP Formulaire</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Font Playfair Display class="font-title"  pour les titres -->
    <!-- font Lato class="regular" pour l'écriture régulière -->
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- style CSS perso -->
    <link rel="stylesheet" href="./public/assets/css/style.css">
    <link rel="stylesheet" href="./public/assets/css/reg.css">
</head>

<body>
    <header>
    </header>
    <main>
        <h1 class="font-title text-center fw-bold mt-5">Inscription</h1>
        <div class="row pt-3 mb-5">
            <div class="col-lg-8 offset-lg-2 col-12 pt-5">
                <!-- formulaire méthode POST - "novalidate" pour supprimer les contrôles front-->
                <form method="post" enctype="multipart/form-data" novalidate>
                    <div class="form-group">
                        <div class="row">
                            <!-- Formulaire civilité -->
                            <div class="col-md-6">
                                <label for="civil" class="form-label regular mb-0">Civilité</label><br>
                                <select name="civil" id="civil" class="select-style" selected="<?=$civil;?>">
                                    <option value="monsieur">Monsieur</option>
                                    <option value="madame">Madame</option>
                                </select>
                                <span class="regular"><?=$errors['civil'] ??'';?></span>
                            </div>
                            <!-- Formulaire photo de profil -->
                            <div class="col-md-6 mt-1">
                                <span class="regular">Photo de profil</span><br>
                                <label for="picture" class="custom-file-upload">Choisir un fichier</label><br>
                                <input id="picture" class="regular custom-file-upload" type="file" accept="image/png, image/jpeg" name="picture" required="required" capture="user" style="display: none;">
                            </div>
                        </div>
                    </div>
                    <!-- Formulaire pour le nom -->
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="lastname" class="regular">Nom</label>
                                <input id="lastname" class="form-control" pattern="^[a-zA-Zéèôàîï \-]{2,50}$" value="<?=$lastname?? ''; ?>" type="text" name="lastname" placeholder="Entrer votre nom" minlength="2" maxlength="40">
                                <span class="regular"><?=$errors['lastname'] ??'';?></span>
                            </div>
                            <div class="col-md-6">
                                <!-- Date de naissance -->
                                <div class="mb-3">
                                    <label for="day" class="form-label regular mb-0">Date de naissance</label>
                                    <div>
                                        <input type="date" id="birthdate" name="birthdate" pattern="<?=BIRTH_DATE?>">
                                        <label for="birthdate"></label>
                                        <span class="regular"><?= $errors['birthdate']??''; ?></span>
                                        <!-- Select pour le lieu de naissance -->
                                        <span class="regular">&nbsp;Lieu de naissance</span>
                                        <select name="country" id="country" class="select-style">
                                            <option value="France">France</option>
                                            <option value="Belgique">Belgique</option>
                                            <option value="Suisse">Suisse</option>
                                            <option value="Luxembourg">Luxembourg</option>
                                            <option value="Allemagne">Allemagne</option>
                                            <option value="Italie">Italie</option>
                                            <option value="Espagne">Espagne</option>
                                            <option value="Portugal">Portugal</option>
                                        </select>
                                        <span class="regular"><?= $errors['country'] ?? ''; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <!-- Premier champ pour le mot de passe -->
                                    <label for="password1" class="form-label regular">Mot de passe</label>
                                    <input type="password" class="form-control" id="password1" name="password1" placeholder="Entrer votre mot de passe" minlength="2" required="required">
                                    <div id="nudge">
                                        <span class="badge  regular d-none">Faible</span>
                                        <span class="badge  regular d-none">Moyen</span>
                                        <span class="badge regular d-none">Fort</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <!-- Deuxième champ pour le mot de passe -->
                                    <label for="password2" class="form-label regular">Confirmation du mot de passe</label>
                                    <input type="password" class="form-control" id="password2" name="password2" placeholder="Confirmer votre mot de passe" minlength="2" required="required">
                                    <div id="password2Help" class="form-text regular d-none">Les mots de passe doivent correspondre</div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <!-- Champ pour l'email -->
                                    <label for="email" class="form-label regular">Email</label>
                                    <input type="email" class="form-control border" name="email" value="<?= $email ?? ''; ?>" id="email" aria-describedby="emailHelp" placeholder="Entrer votre adresse email" minlength="2" required="required">
                                    <span class="regular"><?= $errors['email'] ?? ''; ?></span>
                                    <div id="emailHelp" class="form-text error d-none">Cet email n'est pas valide</div>
                                </div>
                                <!-- Champ pour l'url LinkedIn -->
                                <div class="col-md-6">
                                    <label for="linkedin" class="regular mt-2">Lien vers LinkedIn</label>
                                    <input id="linkedin" class="form-control" type="url" <?= $linkedin ?? ''; ?>" name="linkedin" placeholder="Entrer votre lien vers LinkedIn">
                                    <span class="regular"><?= $errors['linkedin'] ?? ''; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <!-- Checkbox langages de programmation -->
                                <div class="col-md-9 regular">
                                    <p class="regular mt-1">Quel langages web connaissez-vous?</p>
                                    <div class="m0 checkbox-style">
                                        <?php foreach ($langages as $key => $value) : ?>
                                            <input type="checkbox" id="<?= $key ?>" name="<?= $key ?>" value="<?= $key ?>">
                                            <label for="<?= $key ?>"><?= $value ?></label>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <!-- formulaire pour le code postal -->
                                    <label for="cp" class="regular">Code postal</label>
                                    <input id="cp" pattern="<?= POSTAL_CODE ?>" class="form-control" value="<?= $cp ?? ''; ?>" type="text" name="cp" placeholder="Entrer votre code postal" autocomplete="postal-code" inputmode="numeric">
                                    <span class="regular"><?= $errors['cp'] ?? ''; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-12">
                                    <label for="xp" class="regular">Racontez une expérience avec la programmation et/ou l'informatique que vous auriez pu avoir.</label>
                                    <textarea id="xp" class="form-control" name="xp" placeholder="Racontez votre expérience (100 caractères minimum)" minlength="100" required="required"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <button class="btn btn-form">S'inscrire</button>
                        </div>
                </form>
            </div>
        </div>
    </main>
    <footer>
    </footer>
    <script src="https://kit.fontawesome.com/a1eac4c766.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <!-- JS PERSO -->
    <!-- <script src="./public/assets/js/script.js"></script>
    <script src="./public/assets/js/reg.js"></script> -->
</body>

</html>