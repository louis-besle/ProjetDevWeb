document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector(".formulaire_connexion");
    const emailInput = document.querySelector("#email");
    const passwordInput = document.querySelector("#password");

    //validation email
    function validateEmail(email) {
        const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        return emailPattern.test(email);
    }

    //valider le mot de passe
    function validatePassword(password) {
        //vérifier si le mot de passe contient au moins 8 caractères, une majuscule, une minuscule et un chiffre
        const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;
        return passwordPattern.test(password);
    }

    //on met un écouteur d'événement pour vérifier l'envoie du formulaire
    form.addEventListener("submit", function(event) {
        event.preventDefault();  //empeche la soumission automatique

        //récupérer la valeur du champs
        const email = emailInput.value.trim();
        const password = passwordInput.value.trim();

        //valide l'email
        if (!validateEmail(email)) {
            alert("L'email n'est pas valide.");
            return;
        }

        //valide le mot de passe
        if (!validatePassword(password)) {
            alert("Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule et un chiffre.");
            return;
        }

        //on envoie si tout est bon
        form.submit();
    });
});