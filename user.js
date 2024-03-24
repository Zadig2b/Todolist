function setUserInfo() {
    // Envoyer une requête AJAX pour récupérer les informations utilisateur du serveur
    fetch('backendUser.php?action=fetchUserById', {
        method: 'GET',
        credentials: 'include' 
    })
    .then(response => response.json())
    .then(data => {
        const userId = data.id;
        console.log('User ID:', userId);
        
        // Extraire des champs individuels des données utilisateur
        const nom = data.Nom;
        const prenom = data.Prénom;
        const mdp = data.Mot_de_passe;
        const email = data.Email;
        
        // Définir le contenu de chaque champ dans l'élément HTML correspondant
        document.getElementById('nom').value = nom;
        document.getElementById('prenom').value = prenom;
        document.getElementById('email').value = email;
        
        // let returnUser = document.getElementById('returnUser');
        // returnUser.innerHTML = JSON.stringify(data);
    })
    .catch(error => console.error('Error fetching user data:', error));
}

function updateUserInBackend() {
    // Get form data
    const nom = document.getElementById('nom').value;
    const prenom = document.getElementById('prenom').value;
    const email = document.getElementById('email').value;

    // Construct request body
    const requestBody = {
        nom: nom,
        prenom: prenom,
        email: email
    };

    // Send POST request to backend
    fetch('traitementEdition.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(requestBody)
    })
    .then(response => {
        if (response.ok) {
            return response.json();
        }
        throw new Error('Network response was not ok.');
    })
    .then(data => {
        // Gérer la réponse du backend
        //Redirection vers une page de réussite ou affichage d'un message de réussite
        window.location.href = 'connected.php'; 
    })
    .catch(error => {
        console.error('Error updating user information:', error);
        console.log(console.error('Error updating user information:', error));
       
    });
}

document.getElementById('décoBtn').addEventListener('click', function() {
    window.location.href = 'deconnexion.php';
});
