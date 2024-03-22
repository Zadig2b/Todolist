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