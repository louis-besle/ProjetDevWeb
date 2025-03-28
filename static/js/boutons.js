/* Gestion du bouton pour les filtres */
document.getElementById("bouton_filtre").addEventListener("click", function() {
    //affiche les menus de filtres
    document.getElementById("filtres").style.display = "block";
    
    //on déplace les offres vers le bas pour éviter la superposition
    document.body.classList.add("show-filters");
});

document.getElementById("valider").addEventListener("click", function() {
    //on ferme le menu qunad la sélection est finie
    document.getElementById("filtres").style.display = "none";
    document.body.classList.remove("show-filters");
});

/* Ajouer en wishlist */
function toggleFavoris(element) {
    element.classList.toggle("active");
    element.textContent = element.classList.contains("active") ? "❤️" : "💜";
}