document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('company_form');

    //on écoute les événements du soumission
    form.addEventListener('submit', function(event) {
        let valid = true;

        //validation nom entreprise
        const companyName = document.getElementById('company_name');
        if (!companyName.value.match(/^[A-Za-z0-9\s\-]+$/)) {
            alert("Le nom de l'entreprise peut uniquement contenir des lettres, des chiffres, des espaces et des tirets.");
            valid = false;
        }

        //validation sélection ville
        const citySelect = document.getElementById('borne-select_ville');
        if (citySelect.value === "") {
            alert("Veuillez sélectionner une ville.");
            valid = false;
        }

        //validation description entreprise
        const companyDescription = document.querySelector('textarea[name="company_description"]');
        if (!companyDescription.value.trim()) {
            alert("Veuillez entrer une présentation de l'entreprise.");
            valid = false;
        }

        //validation email
        const email = document.getElementById('email');
        if (!email.value.match(/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/)) {
            alert("Veuillez entrer un email valide.");
            valid = false;
        }

        //validation téléphone
        const phone = document.getElementById('phone');
        if (!phone.value.match(/^\+?[0-9\s\-()]{7,15}$/)) {
            alert("Veuillez entrer un numéro de téléphone valide.");
            valid = false;
        }

        //validation image
        const imageInput = document.querySelector('input[type="file"]');
        if (imageInput.files.length === 0) {
            alert("Veuillez télécharger une image.");
            valid = false;
        } else {
            const file = imageInput.files[0];
            const fileType = file.type.split('/')[0];
            const fileSize = file.size / 1024 / 1024; // Taille en Mo

            //vérification si le fichier est bien une image
            if (fileType !== 'image') {
                alert("Le fichier doit être une image.");
                valid = false;
            }
            //vérification de la taille du fichier
            if (fileSize > 5) {
                alert("L'image ne doit pas dépasser 2 Mo.");
                valid = false;
            }
        }

        //on envoie pas si le formulaire est pas valide
        if (!valid) {
            event.preventDefault();
        }
    });
});