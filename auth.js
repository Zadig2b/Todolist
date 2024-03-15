 function validateInscriptionForm() {
    // Get form elements
    var nom = document.getElementById("nom").value.trim();
    var prenom = document.getElementById("prenom").value.trim();
    var motDePasse = document.getElementById("motDePasseRegistration").value.trim();
    var email = document.getElementById("emailRegistration").value.trim();

    // Check Nom
    if (nom.length < 3 || nom.length > 50) {
      alert("Nom doit être entre 3 et 50 caractères");
      return false;
    }

    // Check Mot de passe
    if (motDePasse.length < 7) {
      alert("Mot de passe doit être au moins 7 caractères");
      return false;
    }

    // Check Email
    if (email.length < 3 || email.length > 80) {
      alert("Email doit être entre 3 et 80 caractères");
      return false;
    }

    // Form is valid
    return true;
  }
  
  function ValidateConnexion(){
    let mail = document.getElementById('email').value;
    let password = document.getElementById('motDePasse').value;
    let message = document.getElementById('form-check');
  
    if (mail.length === 0 || password.length === 2) {
      message.textContent = "Tous les champs doivent être remplis.";
      message.classList.remove('succes');
      message.classList.add('echec');
      return false;
    } else {
      return true;
    }
  }