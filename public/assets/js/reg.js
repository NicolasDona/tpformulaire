// On cible le bouton, ainsi que les 2 input 'email', et 'username'
// let username = document.getElementById('username');
// let usernameHelp = document.getElementById('usernameHelp');
let email = document.getElementById('email');
let btn = document.querySelector('button[type="submit"]');
let password1 = document.getElementById('password1');
let password2 = document.getElementById('password2');
let password2Help = document.getElementById('password2Help');
// Selection des badges pour la force du mot de passe
let nudge = document.querySelector('#nudge')
let light = nudge.querySelector('span:nth-child(1)')
let medium = nudge.querySelector('span:nth-child(2)')
let strong = nudge.querySelector('span:nth-child(3)')

// const regexUsername = /^[a-zA-Z0-3]{2,30}$/;
const regexEmail = /^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9_\-]+\.[a-zA-Z]{2,5}$/

const regexPwdMedium = /^(?=.*[A-Z])(?=.*[0-9]).{8,}$/
const regexPwdStrong = /^(?=.*[A-Z])(?=.*[0-9])(?=.*[&é"'-]).{8,}$/

// Création d'une fonction de vérification de l'email
const checkEmail = () => {
    email.classList.remove('border-danger', 'border-success', 'border-3')
    emailHelp.classList.add('d-none');
    if(email.value == ''){
        return
    }

    let regexInstance = new RegExp(regexEmail)
    let isValid = regexInstance.test(email.value)


    if (isValid == false) { // if (!isValid)
        // bordure rouge
        email.classList.add('regular', 'border-3')
        emailHelp.classList.remove('d-none');
    } else {
        // bordure verte
        email.classList.add('border-success', 'border-3')
        emailHelp.classList.add('d-none');
    }
}

// Création d'une fonction de vérification du password
const checkPassword = () => {

    // Dès qu'une touche est tapée, on reset tous les styles
    password1.classList.remove('regular', 'border-success', 'border-3')
    password2.classList.remove('regular', 'border-success', 'border-3')
    
    light.classList.add('d-none')
    medium.classList.add('d-none')
    strong.classList.add('d-none')
    password2Help.classList.add('d-none');

    if (password1.value == '' && password2.value == '') {
        return;
    }

    if (password1.value !== password2.value) {
        password1.classList.add('regular', 'border-3')
        password2.classList.add('regular', 'border-3')
        password2Help.classList.remove('d-none');
    } else {
        password1.classList.add('regular', 'border-3')
        password2.classList.add('regular', 'border-3')
        password2Help.classList.add('d-none');
    }

    // Mise à jour de la force du password
    // On commence par masquer la force dans le html
    light.classList.remove('d-none')

    let nudgeMedium = regexPwdMedium.test(password1.value)
    if (nudgeMedium) {
        light.classList.add('d-none')
        medium.classList.remove('d-none')
        strong.classList.add('d-none')
    }j

    let nudgeStrong = regexPwdStrong.test(password1.value)
    if (nudgeStrong) {
        light.classList.add('d-none')
        medium.classList.add('d-none')
        strong.classList.remove('d-none')
    }
}

// // Création de 2 écouteurs d'évènement à l'appui sur une touche
email.addEventListener("keyup", checkEmail);
password1.addEventListener("keyup", checkPassword);
password2.addEventListener("keyup", checkPassword);