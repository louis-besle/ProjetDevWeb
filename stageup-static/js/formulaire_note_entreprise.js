function validateForm(event) {
    //récupère les notes
    const rating = document.querySelector('input[name="rating"]:checked');
    if (!rating) {
        alert("Veuillez sélectionner une note.");
        event.preventDefault(); //empeche l'envoie du formulaire
        return false;
    }

    //récupération du commentaire
    const comments = document.querySelector('textarea[name="comments"]');
    const commentValue = comments.value.trim();
    if (!commentValue) {
        alert("Le champ des commentaires ne peut pas être vide.");
        event.preventDefault();
        return false;
    }

    //limitation de la longueur du commentaire
    if (commentValue.length > 500) {
        alert("Les commentaires ne peuvent pas dépasser 500 caractères.");
        event.preventDefault();
        return false;
    }

    //on échappe les balises html pour éviter les XSS
    comments.value = commentValue.replace(/</g, "&lt;").replace(/>/g, "&gt;");

    return true;
}

//on écoute les événements de soumission
document.querySelector('form').addEventListener('submit', function (event) {
    if (!validateForm(event)) {
        event.preventDefault(); //empêche la soumission
    }
});
