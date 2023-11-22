<!-- language date civilité mdp photo xpérience -->
<?php
define('POSTAL_CODE','^[0-9]{5}$');
// Nettoyage et verification du Nom
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
// Nettoyage et récupération du pays de naissance
    $tabCountry = ['France', 'Belgique', 'Suisse', 'Luxembourg', 'Allemagne', 'Italie', 'Espagne', 'Portugal'];
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
    // $birthday = filter_input(INPUT_POST, 'birthday',FILTER_SANITIZE_NUMBER_INT);
    // if (empty($birthday)) {
    //     $errors['birthday'] = 'La date n\'est pas renseignée !';
    // } else {
    //     $isOk = filter_var($birthday,);
    //     if (!$isOk) {
    //         $errors['birthday'] = 'la date n\'est pas valide !';
    //     }
    // }
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
// Nettoyage et verification du code postal
    $cp = filter_input(INPUT_POST, 'cp', FILTER_SANITIZE_NUMBER_INT);
    if (!empty($cp)) {
        $isOk = filter_var($cp, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => '/'.POSTAL_CODE.'/')));
    }
    if (!$isOk) {
        $errors['cp'] = 'Le code postal n\'est pas valide!';
    }
}
?>
<span class="regular"><?=var_dump($birthday); ?></span>;

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
                <!-- formulaire méthode POST -->
                <form method="post" enctype="multipart/form-data" novalidate>
                    <div class="form-group">
                        <div class="row">
                            <!-- Formulaire civilité -->
                            <div class="col-md-6">
                                <label for="civil" class="form-label regular mb-0">Civilité</label><br>
                                <select name="civil" id="civil" class="select-style">
                                    <option value="monsieur">Monsieur</option>
                                    <option value="madame">Madame</option>
                                </select>
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
                                <input id="lastname" class="form-control" pattern="^[a-zA-Zéèôàîï \-]{2,50}$" value="<?= $lastname ?? ''; ?>" type="text" name="lastname" placeholder="Entrer votre nom" minlength="2" maxlength="40">
                                <span class="regular"><?=$errors['lastname'] ?? ''; ?></span>
                            </div>
                            <div class="col-md-6">
                                <!-- Formulaire pour la date de naissance -->
                                <div class="mb-3">
                                    <label for="birthday" class="form-label regular mb-0">Date de naissance</label>
                                    <div>
                                        <input type="date" id="birthday" name="birthday" class="select-style">
                                        <span class="regular"><?= $errors['birthdate'] ?? ''; ?></span>
                                        <!-- Formulaire pour le lieu de naissance -->
                                        <label for="country" class="regular">Lieu de naissance</label>
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
                                        <span class="regular"><?=$errors['country'] ?? ''; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Premier champ pour le mot de passe -->
                                <label for="password1" class="form-label regular">Mot de passe</label>
                                <input type="password1" class="form-control" id="password1" name="password1" placeholder="Entrer votre mot de passe" minlength="2" required="required">
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
                                <input id="linkedin" class="form-control" type="url" value="<?= $linkedin ?? ''; ?>" name="linkedin" placeholder="Entrer votre lien vers LinkedIn">
                                <span class="regular"><?= $errors['linkedin'] ?? ''; ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-9 regular">
                                <p class="regular mt-1">Quel langages web connaissez-vous?</p>
                                <div class="m0 checkbox-style"><input type="checkbox" id="html" name="html" value="html">
                                    <label for="html">HTML/CSS</label>
                                    <input type="checkbox" id="php" name="php" value="php">
                                    <label for="php">PHP</label>
                                    <input type="checkbox" id="js" name="js" value="js">
                                    <label for="js">Javascript</label>
                                    <input type="checkbox" id="python" name="python" value="python">
                                    <label for="python">Python</label>
                                    <input type="checkbox" id="other" name="other" value="other">
                                    <label for="other">Autres</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <!-- formulaire pour le code postal -->
                                <label for="cp" class="regular">Code postal</label>
                                <input id="cp" pattern="<?=POSTAL_CODE?>" class="form-control" value="<?= $cp ?? ''; ?>" type="text" name="cp" placeholder="Entrer votre code postal" autocomplete="postal-code" inputmode="numeric">
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