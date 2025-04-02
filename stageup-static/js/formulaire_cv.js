function validateFile(event) {
    const fileInput = document.querySelector('input[type="file"][name="cv"]');
    const file = fileInput.files[0];
    const allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document','application/odt'];
    const maxSize = 2 * 1024 * 1024; //taille de 2MO

    //vérification de la sélection du fichier
    if (!file) {
        alert('Veuillez sélectionner un fichier.');
        event.preventDefault();
        return false;
    }

    //vérification du type de fichier
    if (!allowedTypes.includes(file.type)) {
        alert('Seuls les fichiers PDF, DOC, DOCX et ODT sont autorisés.');
        event.preventDefault();
        return false;
    }

    //vérification de la taille du fichier
    if (file.size > maxSize) {
        alert('Le fichier est trop volumineux. La taille maximale autorisée est de 2 Mo.');
        event.preventDefault();
        return false;
    }

    //on envoie si tout est valide
    return true;
}
//on écoute les événements de soumission
document.querySelector('form').addEventListener('submit', function (event) {
    if (!validateFile(event)) {
        event.preventDefault();//on empêche la soumission
    }
});