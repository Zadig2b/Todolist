function validateInscriptionForm() {
    var nom = document.getElementById('nom').value.trim();
    var prenom = document.getElementById('prenom').value.trim();
    var motDePasse = document.getElementById('motDePasseRegistration').value.trim();
    var email = document.getElementById('emailRegistration').value.trim();

    var errors = [];

    if (nom === '') {
        errors.push("Le champ Nom est requis.");
    } else if (nom.length < 3 || nom.length > 50) {
        errors.push("Le champ Nom doit contenir entre 3 et 50 caractères.");
    }

    if (prenom.length > 0 && (prenom.length < 3 || prenom.length > 50)) {
        errors.push("Le champ Prénom doit contenir entre 3 et 50 caractères.");
    }

    if (motDePasse.length < 7) {
        errors.push("Le mot de passe doit contenir au moins 7 caractères.");
    }

    if (email === '') {
        errors.push("Le champ Email est requis.");
    } else if (email.length < 3 || email.length > 80 || !isValidEmail(email)) {
        errors.push("L'adresse e-mail n'est pas valide.");
    }

    if (errors.length > 0) {
        // Affiche les erreurs dans la page HTML
        var errorContainer = document.getElementById('errorContainer');
        errorContainer.innerHTML = '';
        errors.forEach(function(error) {
            var errorDiv = document.createElement('div');
            errorDiv.className = 'alert alert-danger';
            errorDiv.textContent = error;
            errorContainer.appendChild(errorDiv);
        });

        // empêche la soumission du formulaire
        return false;
    }

    return true;
}

function isValidEmail(email) {
    // Vérifie si l'adresse e-mail est valide en utilisant une expression régulière.
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function createUserFromForm() {
    const nom = document.getElementById('nom').value;
    const prenom = document.getElementById('prenom').value;
    const motDePasse = document.getElementById('motDePasse').value;
    const email = document.getElementById('email').value;

    createUser(nom, prenom, motDePasse, email);
}

function createUser(nom, prenom, motDePasse, email) {
    if (!nom.trim() || !prenom.trim() || !motDePasse.trim() || !email.trim()) {
        showToast('Tous les champs sont requis', 'warning');
        return;
    }

    const userData = {
        nom: nom,
        prenom: prenom,
        motDePasse: motDePasse,
        email: email
    };

    fetch('backend.php?action=createUser', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(userData)
    })
    .then(response => response.json())
    .then(result => {
        if (result.message === 'User created successfully' && result.user) {
            console.log(result.user); 
            showToast('Utilisateur créé avec succès', 'success');
            // Redirige l'utilisateur vers la page d'accueil après la création du compte
        } else {
            console.error('Error creating user:', result.error);
            showToast(result.error, 'error');
        }
    })
    .catch(error => {
        console.error('Error creating user:', error);
        showToast('An unexpected error occurred', 'error');
    });
}
