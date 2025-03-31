document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector(".formulaire_connexion");
    const emailInput = document.querySelector("#email");
    const passwordInput = document.querySelector("#password");

    //validation email
    function validateEmail(email) {
        const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        return emailPattern.test(email);
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

        //on envoie si tout est bon
        form.submit();
    });
});