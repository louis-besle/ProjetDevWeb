document.addEventListener("DOMContentLoaded", () => {
    const burgerMenu = document.querySelector(".burger-menu");
    const menu = document.querySelector(".menu_interact");
    
    if (!burgerMenu || !menu) {
        console.error("Menu burger ou menu interactif introuvable dans le DOM.");
        return;
    }

    const toggleMenu = (event) => {
        event.stopPropagation(); // Empêche la propagation du clic
        menu.classList.toggle("show");
        burgerMenu.classList.toggle("active");
    };

    burgerMenu.addEventListener("click", toggleMenu);
    
    // Ferme le menu quand on clique sur un lien
    document.querySelectorAll(".menu_interact a").forEach(link => {
        link.addEventListener("click", () => {
            menu.classList.remove("show");
            burgerMenu.classList.remove("active");
        });
    });

    // Ferme le menu quand on clique en dehors
    document.addEventListener("click", (event) => {
        if (!menu.contains(event.target) && !burgerMenu.contains(event.target)) {
            menu.classList.remove("show");
            burgerMenu.classList.remove("active");
        }
    });
});
