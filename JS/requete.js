document.addEventListener("DOMContentLoaded", function() {
    // Récupération des éléments du DOM
    const selectRequete = document.getElementById("typeRequete");
    const sectionReparation = document.getElementById("sectionReparation");
    const sectionLocation = document.getElementById("sectionLocation");
    
    // Récupération des champs spécifiques pour gérer l'attribut 'required'
    const champsReparation = document.querySelectorAll(".req-reparation");
    const champsLocation = document.querySelectorAll(".req-location");

    // Fonction pour mettre à jour l'affichage
    function gererAffichage() {
        const choix = selectRequete.value;

        // Réinitialisation : on cache tout et on enlève les 'required'
        sectionReparation.classList.add("cache");
        sectionLocation.classList.add("cache");
        champsReparation.forEach(champ => champ.required = false);
        champsLocation.forEach(champ => champ.required = false);

        // Affichage conditionnel
        if (choix === "reparation") {
            sectionReparation.classList.remove("cache");
            champsReparation.forEach(champ => champ.required = true);
        } else if (choix === "location") {
            sectionLocation.classList.remove("cache");
            champsLocation.forEach(champ => champ.required = true);
        }
    }

    // Écouteur d'événement sur le changement du select
    selectRequete.addEventListener("change", gererAffichage);
});