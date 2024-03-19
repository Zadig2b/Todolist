<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">TodoList</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      </ul>

      <button class="btn btn-primary mx-2" data-bs-toggle="modal" data-bs-target="#inscriptionModal">Gestion du compte</button>
      <button class="btn btn-primary"  id="décoBtn">Déconnexion</button>
    </div>
  </div>
</nav>

<!-- Modal Gestion de Compte -->
<div class="modal fade" id="inscriptionModal" tabindex="-1" aria-labelledby="inscriptionModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="inscriptionModalLabel">Formulaire d'édition</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form  method="post" id="EditForm" onsubmit="return updateUserInBackend()">

          <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" class="form-control" id="nom" name="nom" autocomplete="family-name">
          </div>
          <div class="mb-3">
            <label for="prenom" class="form-label">Prénom</label>
            <input type="text" class="form-control" id="prenom" name="prenom" autocomplete="first-name">
          </div>
          <div class="mb-3">
            <label for="motDePasse" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="motDePasseRegistration" name="motDePasse" autocomplete="current-password" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="emailRegistration" name="email" autocomplete="email">
          </div>
          <button type="submit" class="btn btn-primary">Enregistrer</button>
        </form>
      </div>
    </div>
  </div>
</div>
<div id=returnUser></div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
// Function to set user information
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

// Trigger setUserInfo() function when modal is shown
$('#inscriptionModal').on('shown.bs.modal', function () {
    setUserInfo();
});

function updateUserInBackend() {
    // Get form data
    const nom = document.getElementById('nom').value;
    const prenom = document.getElementById('prenom').value;
    const email = document.getElementById('emailRegistration').value;

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

</script>
