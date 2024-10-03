function openTab(evt, tabName) {
    // Cacher tous les onglets
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("contenu-onglet");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    
    // Enlever la classe 'active' de tous les onglets
    tablinks = document.getElementsByClassName("onglet");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Afficher l'onglet sélectionné et ajouter la classe 'active' au bouton correspondant
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
}



document.addEventListener('DOMContentLoaded', function () {
    const menuToggle = document.querySelector('.menuToggle');
    const navbar = document.querySelector('.navbar');
    const header = document.querySelector('header');
    const sticky = header.offsetTop;

    // Fonction pour activer/désactiver le menu mobile
    function toggleMenu() {
        navbar.classList.toggle('active');
        menuToggle.classList.toggle('active');
    }

    menuToggle.addEventListener('click', toggleMenu);

    // Gérer le clic sur un lien dans le menu
    const navbarLinks = document.querySelectorAll('.navbar a');
    navbarLinks.forEach(link => {
        link.addEventListener('click', function () {
            navbar.classList.remove('active');
            menuToggle.classList.remove('active');
        });
    });

    // Gestion de la barre de navigation sticky
    window.onscroll = function () {
        if (window.pageYOffset > sticky) {
            header.classList.add('sticky');
        } else {
            header.classList.remove('sticky');
        }
    };

    // Fonction pour ouvrir les onglets et faire défiler la page
    function openTab(evt, tabName) {
        const contenuOnglet = document.getElementsByClassName("contenu-onglet");
        for (let i = 0; i < contenuOnglet.length; i++) {
            contenuOnglet[i].classList.remove("show");
        }

        const onglet = document.getElementsByClassName("onglet");
        for (let i = 0; i < onglet.length; i++) {
            onglet[i].classList.remove("active");
        }

        const targetTab = document.getElementById(tabName);
        targetTab.classList.add("show");
        evt.currentTarget.classList.add("active");

        // Faire défiler en douceur vers l'onglet sélectionné
        targetTab.scrollIntoView({ behavior: 'smooth' });
    }

    // Fonction générique pour traiter les formulaires
    function handleFormSubmission(form, url, messageElement) {
        form.addEventListener('submit', function (event) {
            event.preventDefault(); // Empêche le comportement par défaut du formulaire

            const formData = new FormData(form);

            fetch(url, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json()) // Analyse la réponse comme JSON
            .then(data => {
                // Crée un message de confirmation
                messageElement.textContent = data.message;
                messageElement.style.color = data.success ? 'green' : 'red'; // Change la couleur en fonction du succès

                // Réinitialiser le formulaire si l'envoi est réussi
                if (data.success) {
                    form.reset();
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                messageElement.textContent = "Une erreur s'est produite. Veuillez réessayer.";
                messageElement.style.color = 'red';
            });
        });
    }

    // Formulaire d'inscription
    const inscriptionForm = document.getElementById('inscriptionForm');
    const inscriptionFormMessage = document.getElementById('formMessage');
    if (inscriptionForm) {
        handleFormSubmission(inscriptionForm, 'process_inscription.php', inscriptionFormMessage);
    }

    // Formulaire de partenaires et sponsors
    const partenairesForm = document.getElementById('partenairesForm');
    const partenairesFormMessage = document.getElementById('formMessagePartenaires');
    if (partenairesForm) {
        handleFormSubmission(partenairesForm, 'process_partenaires.php', partenairesFormMessage);
    }

    // Fonction pour activer/désactiver le menu déroulant
    function toggleDropdown() {
        const dropdownContent = document.querySelector('.dropdown-content');
        dropdownContent.classList.toggle('active');
    }

    // Ajouter un événement pour fermer le menu déroulant lorsqu'on clique en dehors
    window.onclick = function (event) {
        const dropdown = document.querySelector('.dropdown-content');
        if (!event.target.matches('.dropbtn') && dropdown.classList.contains('active')) {
            dropdown.classList.remove('active');
        }
    };
});
