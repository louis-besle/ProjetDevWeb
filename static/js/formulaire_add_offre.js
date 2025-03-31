function validateForm(event) {
    const offerTitle = document.getElementById('offer_title');
    const entrepriseRadio = document.querySelectorAll('input[name="entreprise"]');
    const villeSelect = document.getElementById('borne-select_ville');
    const duration = document.getElementById('duration');
    const sectorSelect = document.getElementById('sector_select');
    const niveauSelect = document.getElementById('borne-select_niveau');
    const jobDescription = document.getElementById('job_description');
    const profile = document.getElementById('profile');

    //validation des champs requis
    if (offerTitle.value.trim() === '') {
        alert('Le titre de l\'offre est obligatoire.');
        offerTitle.focus();
        event.preventDefault(); //on empeche l'envoie du formulaire
        return false;
    }

    //vérification de l'entreprise sélectionner
    if (villeSelect.value === '') {
        alert('Veuillez sélectionner une ville.');
        villeSelect.focus();
        event.preventDefault();
        return false;
    }


    //vérification de la ville sélectionnée
    if (villeSelect.value === '') {
        alert('Veuillez sélectionner une ville.');
        villeSelect.focus();
        event.preventDefault();
        return false;
    }

    //vérification de la durée du stage
    if (duration.value.trim() === '') {
        alert('La durée du stage est obligatoire.');
        duration.focus();
        event.preventDefault();
        return false;
    }


    //vérification du niveau d'étude
    if (niveauSelect.value === '') {
        alert('Veuillez sélectionner un niveau d\'étude.');
        niveauSelect.focus();
        event.preventDefault();
        return false;
    }

    //vérification de la présentation du poste
    if (jobDescription.value.trim() === '') {
        alert('La présentation du poste est obligatoire.');
        jobDescription.focus();
        event.preventDefault();
        return false;
    }

    //vérification du profil requis
    if (profile.value.trim() === '') {
        alert('Le profil requis est obligatoire.');
        profile.focus();
        event.preventDefault();
        return false;
    }

    return true;
}

//on écoute les événements de soumission
document.querySelector('.add_offer').addEventListener('submit', function (event) {
    if (!validateForm(event)) {
        event.preventDefault(); //empêche la soumission
    }
});
