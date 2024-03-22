function setUserInfo() {
    // Send an AJAX request to fetch the user information from the server
    fetch('backendUser.php?action=fetchUserById', {
        method: 'GET',
        credentials: 'include' // Include cookies in the request
    })
    .then(response => response.json())
    .then(data => {
        const userId = data.id;
        console.log('User ID:', userId);
        
        // Extract individual fields from the user data
        const nom = data.Nom;
        const prenom = data.Prénom;
        const mdp = data.Mot_de_passe;
        const email = data.Email;
        
        // Set the content of each field in the corresponding HTML element
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
        // Handle response from backend
        // Redirect to a success page or display a success message
        window.location.href = 'connected.php'; // Redirect to success page
    })
    .catch(error => {
        // Handle errors
        console.error('Error updating user information:', error);
        console.log(console.error('Error updating user information:', error));
        // Display error message to the user
    });
}

document.getElementById('décoBtn').addEventListener('click', function() {
    window.location.href = 'deconnexion.php';
});
