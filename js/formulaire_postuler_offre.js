document.getElementById('formulaire_offre').addEventListener('submit', function (event) {
    //récupération des valeurs
    const description = document.getElementById('description').value.trim();
    const fichierInput = document.getElementById('fichier');

    //valider la desscription
    if (description === '') {
        alert("Veuillez écrire un message.");
        event.preventDefault(); //empêche la soumission
        return false;
    }

    //validation de l'importation du fichier
    if (fichierInput.files.length === 0) {
        alert("Veuillez télécharger une lettre de motivation.");
        event.preventDefault(); //empêche la soumission
        return false;
    }

    const file = fichierInput.files[0];

    //vérification de la taille du fichier
    const maxSize = 2 * 1024 * 1024; //2MO
    if (file.size > maxSize) {
        alert("Le fichier dépasse la taille maximale autorisée de 2 Mo.");
        event.preventDefault(); //empêche la soumission
        return false;
    }

    //vérification du type de fichier
    const allowedExtensions = ['pdf', 'doc', 'docx', 'txt'];
    const fileExtension = file.name.split('.').pop().toLowerCase();

    if (!allowedExtensions.includes(fileExtension)) {
        alert("Le fichier doit être au format PDF, DOC, DOCX, TXT ou ODT.");
        event.preventDefault(); //empêche la soumission
        return false;
    }

    //protection contre les injections XSS
    document.getElementById('description').value = description.replace(/</g, "&lt;").replace(/>/g, "&gt;");

    return true; //soumission du formulaire
});