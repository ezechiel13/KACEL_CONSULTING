document.addEventListener('DOMContentLoaded', function () {
    const menuToggle = document.querySelector('.menuToggle');
    const navbar = document.querySelector('.navbar');

    // Gérer le clic sur le bouton de menu
    menuToggle.addEventListener('click', function () {
        navbar.classList.toggle('active'); // Toggle the navbar
        menuToggle.classList.toggle('active'); // Toggle the menu icon
    });

    // Gérer le clic sur un lien dans le menu
    const navbarLinks = document.querySelectorAll('.navbar a');
    navbarLinks.forEach(link => {
        link.addEventListener('click', function () {
            // Fermez le menu si un lien est cliqué
            navbar.classList.remove('active');
            menuToggle.classList.remove('active');
        });
    });

    // Gestion de la barre de navigation sticky
    window.onscroll = function() {
        const header = document.querySelector('header');
        const sticky = header.offsetTop;
        header.classList.toggle('sticky', window.pageYOffset > sticky);
    };

    // Formulaire de demande de formation
    const formationForm = document.getElementById('formationForm');
    if (formationForm) {
        formationForm.addEventListener('submit', function(event) {
            event.preventDefault(); // Empêche le comportement par défaut du formulaire

            const formData = new FormData(formationForm);

            fetch('submit_formation.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json()) // Analyse la réponse comme JSON
            .then(data => {
                // Crée un message de confirmation
                const confirmationMessage = document.createElement('p');
                confirmationMessage.textContent = data.message;
                confirmationMessage.style.color = data.success ? 'green' : 'red'; // Change la couleur en fonction du succès

                // Ajoute le message après le formulaire
                formationForm.parentNode.insertBefore(confirmationMessage, formationForm.nextSibling);

                // Réinitialiser le formulaire si l'envoi est réussi
                if (data.success) {
                    formationForm.reset();
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
            });
        });
    }

    // Fonction pour activer/désactiver le menu déroulant
    function toggleDropdown() {
        const dropdownContent = document.querySelector('.dropdown-content');
        dropdownContent.classList.toggle('active');
    }

    // Ajouter un événement pour fermer le menu déroulant lorsqu'on clique en dehors
    window.onclick = function(event) {
        const dropdown = document.querySelector('.dropdown-content');
        if (!event.target.matches('.dropbtn') && dropdown.classList.contains('active')) {
            dropdown.classList.remove('active');
        }
    };
});

// Fonction pour ouvrir les onglets et faire défiler la page
function openTab(evt, tabName) {
    const contenuOnglet = document.getElementsByClassName("contenu-onglet");
    const onglet = document.getElementsByClassName("onglet");

    // Cacher toutes les sections d'onglets
    Array.from(contenuOnglet).forEach(onglet => onglet.classList.remove("show"));
    Array.from(onglet).forEach(onglet => onglet.classList.remove("active"));

    // Afficher l'onglet sélectionné
    const targetTab = document.getElementById(tabName);
    targetTab.classList.add("show");
    evt.currentTarget.classList.add("active");

    // Faire défiler en douceur vers l'onglet sélectionné
    targetTab.scrollIntoView({ behavior: 'smooth' });
}
