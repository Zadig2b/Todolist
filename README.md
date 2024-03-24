
# Todolist
# Todolist réalisée avec MySQL, PHP, Fetch, Ajax et Json.

# Brief Todolist
# Mars 2024

# Backend.php

# Script.js
Contient les méthodes fetch permettant de faire le lien entre notre page web , le repository content le C.R.U.D, et en bout de chaîne, la base de donnée.





# Implémentation de la Connexion Utilisateur
# Back-end:
# Mise à jour de la Base de Données:
Créer la table todolist_user avec les spécifications suivantes :
id auto-incrément (clé primaire)
Nom Texte requis, 3 caractères minimum - 50 caractères maximum
Prénom Texte non requis, 3 caractères minimum - 50 caractères maximum
Mot de passe Mot de passe requis, minimum 7 caractères
Email Email requis, 3 caractères minimum - 80 caractères maximum

# Front-end:
Mise à Jour de la Navbar:
Ajout du bouton "Inscription":

Au clic, ouverture d'une modal formulaire_inscription avec les champs :
Nom (requis)
Prénom (optionnel)
Mot de passe (requis)
Email (requis)
Réutilisation des contraintes définies précédemment dans la base de données.
Ajout du bouton "Connexion":
Au clic, ouverture d'une modal formulaire_connexion avec les champs :
Email : L'utilisateur entre son adresse email
Mot de passe : L'utilisateur entre son mot de passe


# Back-end (2ème Étape):

# Inscription:
Création du fichier traitementInscription.php.
Ce fichier gère le traitement des données reçues lors de l'envoi du formulaire d'inscription (sanitization).
Une fois les données traitées, elles sont envoyées à UserRepository qui crée le nouvel utilisateur dans la base de données avec les données récupérées.
# UserRepository:
classe User
Contient les méthodes pour :
- Créer un utilisateur
- Mettre à jour un utilisateur
- Supprimer un utilisateur
- Lire un utilisateur

# TaskRepository:
classe Task
Contient les méthodes pour :
- Créer une tâche
- Mettre à jour une tâche
- Supprimer une tâche
- Lire une tâche


# Validation du Formulaire:

La validation des champs est effectuée lors de la soumission du formulaire. 
Chaque champ d'entrée affiche un message d'erreur adapté à l'erreur rencontrée. 
Les messages d'erreur disparaissent lorsque le formulaire est soumis à nouveau avec des champs valides.
Lors de la soumission du formulaire, une requête fetch contenant les données de l'utilisateur est envoyée au fichier backendUser. 
Ce dernier vérifie et traite les données. 
Une fois traitées, en cas de succès, elles sont envoyées à la base de données via la méthode create de UserRepository. 
Une session est démarrée et l'ID utilisateur est stocké. 
L'utilisateur est alors automatiquement connecté (changement de page : de index.php à connected.php). 
Il peut désormais créer ou supprimer des tâches, automatiquement liées à son compte.
Celles-ci sont récupérées et affichées sans rechargement de la page.
On appelle pour cela fetchTasksByUserId à l'ouverture de la page, et après chaque création d'une nouvelle tâche
Il a la possibilité de créer des catégories.


# Voies d'Améliorations:

-> Refactoriser tous les fichiers en classe

-> renommer les fichiers et les ré organiser dans les dossier pour une meilleure portabilité du code et faciliter le travail de correction.

-> l'initialisation de la DB est dans config.php, on aurait pu faire une classe DB

-> les fichiers Backend ne sont pas en classe

-> On aurait pu ajouter une Hydratation

-> le lien entre catégories et tâches n'est pas correctement implémenté: 
on aurait dû récupérer l'id de la catégorie assignée à une tâche via une Foreign Key plutôt qu'ajouter une string en dur

-> l'affichage des catégories crées n'est pas fait: on ne peut constater leur création uniquement via PhpMyAdmin.

-> le traitement des données reçues aurait pu être amélioré. L'aspect sécurité a été un peu négligé.

Toutes ces choses n'ont pas été implémentées par manque de temps.


