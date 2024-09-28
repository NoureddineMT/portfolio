import '../node_modules/bootstrap/dist/js/bootstrap.bundle.js';             // Importe le fichier de configuration bootstrap.js
import './styles/app.scss';          // Importe les styles SCSS de l'application

// Import Font Awesome
import '@fortawesome/fontawesome-free/css/all.min.css';
import '@fortawesome/fontawesome-free/js/all.js';


/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.scss';

let moon = document.getElementById("moon")
let sun = document.getElementById("sun")
let bgDark = document.querySelectorAll(".bg-darkgrey");
let bgLight = document.querySelectorAll(".bg-white");
let progressBar = document.querySelectorAll(".progress")
let darkgreyText = document.querySelectorAll(".text-darkgrey")
let colorChange2 = document.querySelectorAll(".color-change2")
let colorChange3 = document.querySelectorAll(".color-change3")

$(window).scroll(function () {
    var height = $(window).scrollTop();
    if (height > 5) {
        $("nav").addClass("bg-darkgrey shadow-sm").removeClass("bg-invisible");
    } else {
        $("nav").addClass("bg-invisible").removeClass("bg-darkgrey shadow-sm");
    }
});

function themeChange(list, firstClass, secondClass) {
    for (let i = 0; i < list.length; i++) {
        list[i].classList.add(firstClass);
        list[i].classList.remove(secondClass);
    }
}
moon.addEventListener("click", function () {
    this.classList.add("d-none");
    sun.classList.remove("d-none");
    themeChange(bgLight, "bg-darkgrey", "bg-white")
    themeChange(progressBar, "bg-white", "bg-darkgrey")
    themeChange(darkgreyText, "text-white", "text-darkgrey")
    themeChange(colorChange3, "color-change5", "color-change3")
    themeChange(colorChange2, "color-change4", "color-change2")

})

sun.addEventListener("click", function () {
    this.classList.add("d-none")
    moon.classList.remove("d-none")
    themeChange(bgLight, "bg-white", "bg-darkgrey")
    themeChange(progressBar, "bg-darkgrey", "bg-white")
    themeChange(darkgreyText, "text-darkgrey", "text-white")
    themeChange(colorChange3, "color-change3", "color-change5")
    themeChange(colorChange2, "color-change2", "color-change4")

})
// Inizializza Email.js con le tue credenziali API
emailjs.init("user_L4nfiowxPEOb4DM8LyTtv");

function sendEmail() {
    // Raccogli i dati dal modulo
    var data = {
        name: document.getElementById("name").value,
        email: document.getElementById("email").value,
        subject: document.getElementById("subject").value,
        message: document.getElementById("message").value
    };

    // Invia l'email utilizzando Email.js
    emailjs.send("service_lqfv46f", "template_dnxwwsr", data)
        .then(function (response) {
            console.log("Email inviata con successo:", response);
            // Puoi aggiungere qui una logica per informare l'utente che l'email è stata inviata con successo
        }, function (error) {
            console.error("Errore durante l'invio dell'email:", error);
            // Gestisci gli errori qui
        });
}
