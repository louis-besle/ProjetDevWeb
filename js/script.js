/** Boutons filtre pour les offres */

document.getElementById("filterBtn").addEventListener("click", function() {
    //affiche les menus de filtres
    document.getElementById("filterMenu").style.display = "block";
    
    //on délpace les offres vers le bas pour éviter la superposition
    document.body.classList.add("show-filters");
});

document.getElementById("validateFilters").addEventListener("click", function() {
    //on ferme le menu qunad la sélection est finie
    document.getElementById("filterMenu").style.display = "none";
    document.body.classList.remove("show-filters");
});