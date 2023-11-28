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
                                <select name="civil" id="civil" class="select-style" selected="<?= $civil; ?>">
                                    <option value="monsieur">Monsieur</option>
                                    <option value="madame">Madame</option>
                                </select>
                                <span class="regular"><?= $errors['civil'] ?? ''; ?></span>
                            </div>
                            <!-- Formulaire photo de profil -->
                            <div class="col-md-6 mt-1">
                                <span class="regular">Photo de profil</span><br>
                                <label for="picture" class="custom-file-upload">Choisir un fichier</label><br>
                                <input id="picture" class="regular custom-file-upload" type="file" accept="image/png, image/jpeg" name="picture" required="required" capture="user" style="display: none;">
                                <span class="regular"><?= $errors['picture'] ?? ''; ?></span>
                            </div>
                        </div>
                    </div>
                    <!-- Formulaire pour le nom -->
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="lastname" class="regular">Nom</label>
                                <input id="lastname" class="form-control" pattern="^[a-zA-Zéèôàîï \-]{2,50}$" value="<?= $lastname ?? ''; ?>" type="text" name="lastname" placeholder="Entrer votre nom" minlength="2" maxlength="40">
                                <span class="regular"><?= $errors['lastname'] ?? ''; ?></span>
                            </div>
                            <div class="col-md-6">
                                <!-- Date de naissance -->
                                <div class="mb-3">
                                    <label for="day" class="form-label regular mb-0">Date de naissance</label>
                                    <div>
                                        <input type="date" id="birthdate" name="birthdate" pattern="<?= BIRTH_DATE ?>">
                                        <label for="birthdate"></label>
                                        <span class="regular"><?= $errors['birthdate'] ?? ''; ?></span>
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
                                    <span class="regular"><?= $errors['password'] ?? ''; ?></span>
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
                                    <span class="regular"><?= $errors['xp'] ?? ''; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <button class="btn btn-form">S'inscrire</button>
                        </div>
                </form>
            </div>
        </div>