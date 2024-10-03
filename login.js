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

    // Gestion du formulaire de connexion
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function(event) {
            event.preventDefault();

            const email = document.getElementById('email').value;
            const password = document.getElementById('mot_de_passe').value;

            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'login_process.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    const errorMessageDiv = document.getElementById('error-message');
                    if (xhr.status === 200) {
                        const response = JSON.parse(xhr.responseText);
                        if (response.redirect) {
                            window.location.href = response.redirect; // Redirection si un nouvel emplacement est spécifié
                        } else {
                            errorMessageDiv.textContent = response.message;
                            errorMessageDiv.style.color = 'red'; // Message d'erreur
                        }
                    } else {
                        errorMessageDiv.textContent = 'Erreur lors de la requête AJAX.'; // Erreur de requête
                        errorMessageDiv.style.color = 'red';
                    }
                }
            };

            // Envoi des paramètres du formulaire
            const params = `email=${encodeURIComponent(email)}&mot_de_passe=${encodeURIComponent(password)}`;
            xhr.send(params);
        });
    }

    // Fonction pour activer/désactiver le menu mobile
    function toggleMenu() {
        const menu = document.querySelector('.navbar');
        menu.classList.toggle('show');
    }

    // Fonction pour activer/désactiver le menu déroulant
    function toggleDropdown() {
        const dropdown = document.querySelector('.dropdown-content');
        dropdown.classList.toggle('show');
    }
});
