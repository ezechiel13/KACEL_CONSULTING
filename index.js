
document.addEventListener('DOMContentLoaded', function () {
    const menuToggle = document.querySelector('.menuToggle');
    const navbar = document.querySelector('.navbar');
    const navbarLinks = document.querySelectorAll('.navbar a');
    const header = document.querySelector('header');
    const sticky = header.offsetTop;

    // Fonction pour activer/désactiver le menu mobile
    function toggleMenu() {
        navbar.classList.toggle('active');
        menuToggle.classList.toggle('active');
    }

    menuToggle.addEventListener('click', toggleMenu);

    // Gérer le clic sur un lien dans le menu
    navbarLinks.forEach(link => {
        link.addEventListener('click', function () {
            // Fermez le menu si un lien est cliqué
            navbar.classList.remove('active');
            menuToggle.classList.remove('active');
        });
    });

    // Gestion de la barre de navigation sticky
    window.onscroll = function() {
        if (window.pageYOffset > sticky) {
            header.classList.add('sticky');
        } else {
            header.classList.remove('sticky');
        }
    };

    // Fonction pour activer/désactiver le menu déroulant
    function toggleDropdown() {
        const dropdownContent = document.querySelector('.dropdown-content');
        dropdownContent.classList.toggle('active');
    }

    // Ajouter un événement pour fermer le menu déroulant lorsqu'on clique en dehors
    window.onclick = function(event) {
        const dropdown = document.querySelector('.dropdown-content');
        if (!event.target.matches('.dropbtn')) {
            if (dropdown.classList.contains('active')) {
                dropdown.classList.remove('active');
            }
        }
    };

    // Fonction pour soumettre le formulaire de contact via AJAX
    const contactForm = document.querySelector('form[action="submit_contact.php"]');
    const confirmationMessage = document.createElement('p');
    const preloader = document.createElement('div');
    preloader.className = 'preloader'; // Assurez-vous d'avoir les styles pour .preloader

    contactForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Empêche le comportement par défaut du formulaire

        // Ajout du préloader
        contactForm.parentNode.appendChild(preloader);

        const formData = new FormData(contactForm);

        fetch('submit_contact.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json()) // Analyse la réponse comme JSON
        .then(data => {
            // Supprimer le préloader
            preloader.remove();

            // Afficher le message de confirmation
            confirmationMessage.textContent = data.message;
            confirmationMessage.style.color = data.success ? 'green' : 'red'; // Couleur en fonction du succès

            // Ajoute le message après le formulaire
            contactForm.parentNode.insertBefore(confirmationMessage, contactForm.nextSibling);
            
            // Réinitialiser le formulaire
            contactForm.reset();
        })
        .catch(error => {
            // Supprimer le préloader
            preloader.remove();

            console.error('Erreur:', error);
            confirmationMessage.textContent = "Une erreur s'est produite. Veuillez réessayer.";
            confirmationMessage.style.color = 'red';
            contactForm.parentNode.insertBefore(confirmationMessage, contactForm.nextSibling);
        });
    });
});
