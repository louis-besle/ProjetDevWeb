/** Boutons filtre pour les offres */

document.getElementById("bouton_filtre").addEventListener("click", function() {
    //affiche les menus de filtres
    document.getElementById("filtres").style.display = "block";
    
    //on délpace les offres vers le bas pour éviter la superposition
    document.body.classList.add("show-filters");
});

document.getElementById("valider").addEventListener("click", function() {
    //on ferme le menu qunad la sélection est finie
    document.getElementById("filtres").style.display = "none";
    document.body.classList.remove("show-filters");
});

function toggleFavoris(element) {
    element.classList.toggle("active");
    element.textContent = element.classList.contains("active") ? "❤️" : "💜";
}
