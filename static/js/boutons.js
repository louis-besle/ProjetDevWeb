/* Gestion du bouton pour les filtres */
if(window.location.href.includes("?uri=recherche")) {
    document.getElementById("bouton_filtre").addEventListener("click", function() {
        //affiche les menus de filtres
        document.getElementById("filtres").style.display = "block";
        
        //on déplace les offres vers le bas pour éviter la superposition
        document.body.classList.add("show-filters");
    });
}

if(window.location.href.includes("?uri=recherche")) {
    document.getElementById("valider").addEventListener("click", function() {
        //on ferme le menu qunad la sélection est finie
        document.getElementById("filtres").style.display = "none";
        document.body.classList.remove("show-filters");
    });
}

/* Ajouter en wishlist */
function toggleFavoris(element) {
    element.classList.toggle("active");
    const idOffre = element.value; // Récupérer l'ID de l'offre à partir de la valeur du bouton
    if (element.classList.contains("active")) {
        element.textContent = "❤️";
    }
    else {
        element.textContent = "💜";
    }
}