<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TP Formulaire</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Font Playfair Display class="font-title"  pour les titres -->
    <!-- font Lato class="regular" pour l'écriture réguilère -->
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
                <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="civil" class="form-label regular mb-0">Civilité</label><br>
                                <select name="civil" id="civil" class="select-style">
                                    <option value="monsieur">Monsieur</option>
                                    <option value="madame">Madame</option>
                                </select>
                            </div>
                            <div class="col-md-6 mt-1">
                                <span class="regular">Photo de profil</span><br>
                                <label for="image" class="custom-file-upload">Choisir un fichier</label><br>
                                <input id="image" class="regular custom-file-upload" type="file" accept="image/png, image/jpeg" name="profile_photo" placeholder="Photo" required="" capture style="display: none;">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="nom" class="regular">Nom</label>
                                <input id="nom" class="form-control" type="text" name="" placeholder="Entrer votre nom">
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="username" class="form-label regular mb-0">Date de naissance</label>
                                    <div>
                                        <select name="day" id="day" class="select-style">
                                            <option value="day">jour</option>
                                        </select>
                                        <select name="month" id="month" class="select-style">
                                            <option value="month">mois</option>
                                        </select>
                                        <select name="year" id="year" class="select-style">
                                            <option value="year">année</option>
                                        </select>
                                        <span class="regular">&nbsp;Lieu de naissance</span>
                                        <select name="country" id="country" class="select-style">
                                            <option selected value="France">France</option>
                                            <option value="Belgique">Belgique</option>
                                            <option value="Suisse">Suisse</option>
                                            <option value="Luxembourg">Luxembourg</option>
                                            <option value="Allemagne">Allemagne</option>
                                            <option value="Italie">Italie</option>
                                            <option value="Espagne">Espagne</option>
                                            <option value="Portugal">Portugal</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="password1" class="form-label regular">Mot de passe</label>
                                <input type="password" class="form-control" id="password1" placeholder="Entrer votre mot de passe">
                                <div id="nudge">
                                    <span class="badge  regular d-none">Faible</span>
                                    <span class="badge  regular d-none">Moyen</span>
                                    <span class="badge regular d-none">Fort</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="password2" class="form-label regular">Confirmation du mot de passe</label>
                                <input type="password" class="form-control" id="password2" placeholder="Confirmer votre mot de passe">
                                <div id="password2Help" class="form-text regular d-none">Les mots de passe doivent correspondre</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="email" class="form-label regular">Email</label>
                                <input type="email" class="form-control border" id="email" aria-describedby="emailHelp" placeholder="Entrer votre adresse email">
                                <div id="emailHelp" class="form-text error d-none">Cet email n'est pas valide</div>
                            </div>
                            <div class="col-md-6">
                                <label for="link" class="regular mt-2">Lien vers LinkedIn</label>
                                <input id="link" class="form-control" type="url" name="" placeholder="Entrer votre lien vers LinkedIn">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-9">
                                <label for="langage" class="regular">Quel langages web connaissez-vous?</label>
                                <input id="langage" class="form-control" type="text" name="langage" placeholder="HTML/CSS, PHP, Javascript, Python, Autres">
                            </div>
                            <div class="col-md-3">
                                <label for="cp" class="regular">Code postal</label>
                                <input id="cp" pattern="[0-9]{5}" class="form-control" type="text" name="cp" placeholder="Entrer votre code postal">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12">
                                <label for="xp" class="regular">Racontez une expérience avec la programmation et/ou l'informatique que vous auriez pu avoir.</label>
                                <textarea id="xp" class="form-control" type="text-area" name="xp" placeholder="Racontez votre expérience (100 caractères minimum)" minlength="100"></textarea>
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
    <script src="./public/assets/js/script.js"></script>
    <script src="./public/assets/js/reg.js"></script>
</body>

</html>