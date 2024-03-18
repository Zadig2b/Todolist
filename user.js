function setUserInfo() {
    // Send an AJAX request to fetch the user information from the server
    fetch('backendUser2.php?action=fetchUserById', {
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
        document.getElementById('emailRegistration').value = email;
        
        let returnUser = document.getElementById('returnUser');
        returnUser.innerHTML = JSON.stringify(data);
    })
    .catch(error => console.error('Error fetching user data:', error));
}
