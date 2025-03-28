document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector("#registration_form");
    const nomInput = document.querySelector("#nom");
    const prenomInput = document.querySelector("#prenom");
    const courrielInput = document.querySelector("#courriel");

    //fonction valider email
    function validateEmail(email) {
        const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        return emailPattern.test(email);
    }

    //fonction valider nom et prénom
    function validateName(name) {
        const namePattern = /^[A-Za-zéèêëàâäôöùûüç]+$/;
        return namePattern.test(name) && name.length >= 2;
    }

    //on écoute les événements pour verifier la soumission du formulaire
    form.addEventListener("submit", function(event) {
        event.preventDefault();  //on empêche la soumission auto

        //récupération des valeurs des champs
        const nom = nomInput.value.trim();
        const prenom = prenomInput.value.trim();
        const courriel = courrielInput.value.trim();

        //validation du nom
        if (!validateName(nom)) {
            alert("Le nom doit contenir au moins 2 caractères et ne doit contenir que des lettres.");
            return;
        }

        //validation du prénom
        if (!validateName(prenom)) {
            alert("Le prénom doit contenir au moins 2 caractères et ne doit contenir que des lettres.");
            return;
        }

        //validation de l'email
        if (!validateEmail(courriel)) {
            alert("Le courriel n'est pas valide.");
            return;
        }

        //si tout est von on soumet le formulaire
        form.submit();
    });
});