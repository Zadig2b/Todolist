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
        <form action="traitementEdition.php" method="post" id="EditForm" onsubmit="return validateEditForm()">

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
<script>
// Récupérez l'ID de l'utilisateur à partir de la session PHP
var userId = <?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'null'; ?>;

if (userId) {
    // Effectuez une requête AJAX pour récupérer les informations de l'utilisateur
    fetch('backendUser2.php?action=fetchUserById&userId=' + userId)
        .then(response => response.json())
        .then(user => {
            // Pré-remplir les champs de saisie avec les informations de l'utilisateur
            document.getElementById('nom').value = user.nom;
            document.getElementById('prenom').value = user.prenom;
            document.getElementById('emailRegistration').value = user.email;
            let returnUser = document.getElementById('returnUser');
            returnUser.innerHTML = user
            

        })
        .catch(error => console.error('Erreur lors de la récupération des informations de l\'utilisateur:', error));
} else {
    console.error('ID utilisateur non disponible');
}
</script>