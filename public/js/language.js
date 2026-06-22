const translations = {
    en: {
        nav_competitions: "Competitions",
        nav_rankings: "Rankings",
        nav_pairs: "Pairs",
        nav_photos: "Photos",
        nav_more: "More",
        nav_handlers: "Handlers",
        nav_dogs: "Dogs",
        nav_tracks: "Tracks",
        nav_results: "Results",
        nav_organizers: "Organizers",
        nav_sponsors: "Sponsors",
        // nav_user_management: "User management",
        nav_login: "Login",
        nav_register: "Register",
        nav_logout: "Logout"
    },

    lv: {
        nav_competitions: "Sacensības",
        nav_rankings: "Reitings",
        nav_pairs: "Pāri",
        nav_photos: "Fotogrāfijas",
        nav_more: "Vairāk",
        nav_handlers: "Hendleri",
        nav_dogs: "Suņi",
        nav_tracks: "Trases",
        nav_results: "Rezultāti",
        nav_organizers: "Organizatori",
        nav_sponsors: "Sponsori",
        //nav_user_management: "Lietotāju pārvaldība",
        nav_login: "Pieslēgties",
        nav_register: "Reģistrēties",
        nav_logout: "Iziet"
    }
};

function setLanguage(language) {
    localStorage.setItem("siteLanguage", language);     //lai saglabātu izvēlēto valodu

    const elements = document.querySelectorAll("[data-translate]"); //lai sameklētu visus elementus, kurus vajag tulkot

    elements.forEach(function (element) {  //eju cauri visiem atrastiem elementiem
        const key = element.getAttribute("data-translate"); //ņemu elementa vērtību

        if (translations[language][key]) {  //pārbaudu, vai ir tāds tulkojums
            element.textContent = translations[language][key]; //maina vajadzīgo tekstu HTMLā
        }
    });

    const languageButtons = document.querySelectorAll(".language-btn");

    languageButtons.forEach(function (button) {
        button.classList.remove("active");

        if (button.getAttribute("data-lang") === language) {  //ja poga atbilst izvēlētai valodai,
            button.classList.add("active");                   //tad to pogu taisa active
        }
    });
}

document.addEventListener("DOMContentLoaded", function () {
    const savedLanguage = localStorage.getItem("siteLanguage") || "en";  //paņemu saglabāto valodu
    setLanguage(savedLanguage);   //liekam saglabāto valodu saitē
    const languageButtons = document.querySelectorAll(".language-btn");

    languageButtons.forEach(function (button) {
        button.addEventListener("click", function () {   //kad lietotājs uzspied uz pogas
            const selectedLanguage = button.getAttribute("data-lang");  //paņemam valodu, uz kuras uzspieda
            setLanguage(selectedLanguage);  //izsaucu funkciju priekš valodas maiņas
        });
    });
});