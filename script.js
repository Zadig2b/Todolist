document.addEventListener('DOMContentLoaded', function () {
    if (window.location.pathname === '/index.php') {
        // fetchTasks();
    } else if (window.location.pathname === '/connected.php') {
        fetchTasksById();
        popImg();
        popImgTask();
    }
});


document.addEventListener('click', function (event) {
    let target = event.target;

    if (target.classList.contains('btn-success')) {
        const taskId = target.id.split('-')[1];
        deleteTask(taskId);
    }

    if (target.classList.contains('list-group-item')) {
        document.querySelectorAll('.list-group-item').forEach(item => {
            item.classList.remove('active');
        });

        target.classList.add('active');

        const taskId = target.dataset.taskId;
        viewTaskDetails(taskId);
    }
});

function popImgTask() {
    const imgContainer = document.querySelector('.task-img-container .row');
    
    fetch('public/assets/img/')
        .then(response => response.text())
        .then(data => {
            //Extrait les noms de fichiers image de la liste des répertoires
            const filenames = data.match(/href="([^"]+)/g)
                .map(match => match.replace('href="', ''));

            //Filtre les chemins de répertoire et ne conserve que les noms de fichiers image            
                const imageFilenames = filenames.filter(filename => {
                return /\.(jpg|jpeg|png|gif)$/i.test(filename);
            });

            //Crée des éléments d'image et les ajoute au conteneur
            imageFilenames.forEach(filename => {
                const img = document.createElement('img');
                img.src = 'public/assets/img/' + filename;
                img.alt = filename;
                const id = filename.replace(/\.[^/.]+$/, ''); //Extrait le nom du fichier sans extension comme identifiant
                img.className = 'img0';
                img.id = id;
                img.addEventListener('click', selectImgTask);

                const col = document.createElement('div');
                col.className = 'col-md-2 col-sm-3 col-3 mb-3';
                col.appendChild(img);

                imgContainer.appendChild(col);
            });
        })
        .catch(error => console.error('Error loading images:', error));
}
let selectedImgId;
function selectImgTask(event) {
    const allImages = document.querySelectorAll('.img0');
    allImages.forEach(img => {
        img.style.border = 'none';
        img.style.width = '50px';
        img.removeAttribute('cat-selected');
    });
    //Stocke l'identifiant de l'image sélectionnée
    selectedImgId = event.target.id;

    const selectedImg = event.target;
    selectedImg.style.border = '4px solid rgb(147, 147, 236)';
    selectedImg.style.borderRadius = '10px';
    selectedImg.style.padding = '5px';
    selectedImg.style.margin = '5px';
    selectedImg.style.width = '70px';
    selectedImg.setAttribute('cat-selected', 'true');
}

function popImg() {
    const imgContainer = document.querySelector('.img-container .row');
    
    fetch('public/assets/img/')
        .then(response => response.text())
        .then(data => {
            // Extract image filenames from directory listing
            const filenames = data.match(/href="([^"]+)/g)
                .map(match => match.replace('href="', ''));

            // Filter out directory paths and keep only image filenames
            const imageFilenames = filenames.filter(filename => {
                return /\.(jpg|jpeg|png|gif)$/i.test(filename);
            });

            // Create image elements and append to container
            imageFilenames.forEach(filename => {
                const img = document.createElement('img');
                img.src = 'public/assets/img/' + filename;
                img.alt = filename;
                const id = filename.replace(/\.[^/.]+$/, ''); // Extract filename without extension as id
                img.className = 'img';
                img.id = id;
                img.addEventListener('click', selectImg);

                const col = document.createElement('div');
                col.className = 'col-md-2 col-sm-3 col-3 mb-3';
                col.appendChild(img);

                imgContainer.appendChild(col);
            });
        })
        .catch(error => console.error('Error loading images:', error));
}

function selectImg(event) {
    const allImages = document.querySelectorAll('.img');
    allImages.forEach(img => {
        img.style.border = 'none';
        img.style.width = '50px';
        img.removeAttribute('data-selected');

        

    });
    const selectedImg = event.target;
    selectedImg.style.border = '4px solid rgb(147, 147, 236)';
    selectedImg.style.borderRadius = '10px';
    selectedImg.style.padding = '5px';
    selectedImg.style.margin = '5px';
    selectedImg.style.width = '70px';
    selectedImg.setAttribute('data-selected', 'true');
}

//--------------------------------------------------------------Task Front Management-----------------------

        function fetchTasks() {
            fetch('backend.php?action=fetchTasks')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(tasks => {
                    displayTasks(tasks);
                })
                .catch(error => console.error('Error fetching tasks:', error));
        }

        function fetchTasksById() {
            fetch('backend.php?action=fetchTasksByUserId')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(tasks => {
                    displayTasks(tasks);
                })
                .catch(error => console.error('Error fetching tasks:', error));
        }
        
        function displayTasks(tasks) {
            const taskList = document.getElementById('taskList');
        
            tasks.forEach(task => {
                let listItem = document.createElement('li');
                listItem.classList.add('list-group-item');
                let deleteButton = `<button id="deletebtn-${task.id}" type="button" class="btn btn-success">Validée</button> `;

                listItem.setAttribute('data-task-id', task.id)
                listItem.setAttribute('data-task-title', task.title)
                listItem.setAttribute('data-task-description', task.description)
                listItem.setAttribute('data-task-importance', task.importance)
                listItem.setAttribute('data-task-created-at', task.created_at)
                listItem.setAttribute('data-task-updated-at', task.updated_at)
                listItem.setAttribute('data-task-category', task.cat)



                let importanceBadge = '';
                switch (task.importance) {
                    case 'not_important':
                        importanceBadge = '<span class="badge text-bg-primary">Normal</span>';
                        break;
                    case 'important':
                        importanceBadge = '<span class="badge text-bg-warning">Important</span>';
                        break;
                    case 'urgent':
                        importanceBadge = '<span class="badge text-bg-danger">Urgent</span>';
                        break;
                    default:
                        break;
                }
                
                listItem.innerHTML = `
                
                    ${importanceBadge}
                    ${task.title}
                    ${deleteButton}
                `;
                taskList.appendChild(listItem);
            });
        }
        
        function createTaskFromInput() {
            const title = document.getElementById('taskTitle').value;
            const description = document.getElementById('taskDescription').value;
            let importance;
            let echeance = document.getElementById('taskDate').value;

        
            fetch('backendUser.php?action=createTaskUserId', {
                method: 'GET',
                credentials: 'include' 
            })
            .then(response => response.json())
            .then(data => {
                const userId = data.userId;
                console.log('User ID:', userId);
                console.log('cat Id:', selectedImgId);
        
                const radioButtons = document.getElementsByName('taskImportance');
                radioButtons.forEach(radio => {
                    if (radio.checked) {
                        importance = radio.value;
                    }
                });
        
                createTask(title, description, importance, echeance, userId, selectedImgId);
            })
            .catch(error => console.error('Error fetching user ID:', error));
        }
        
        
        function createTask(title, description, importance, echeance, userId, catId) {
            if (!title.trim()) {
                showToast('le titre d\'une tâche ne peut être vide', 'warning');
                return;
            }
        
            const taskData = {
                title: title,
                description: description,
                importance: importance,
                echeance: echeance,
                user_id: userId,
                cat_id: catId,
            };
        console.log(taskData);
            fetch('backend.php?action=createTask', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(taskData)
            })
            .then(response => response.json())
            .then(result => {
                if (result.message === 'Task created successfully' && result.task) {
                    console.log(result.task); 
                    showToast('Tâche créee avec succès', 'success');
                    displayTasks([result.task]);
                } else {
                    console.error('Error creating task:', result.error);
                    showToast(result.error, 'warning');
                }
            })
            .catch(error => {
                console.error('Error creating task:', error);
                showToast('An unexpected error occurred', 'error');
            });
        }
        
        function showToast(message, type) {
    const toastContainer = document.getElementById('toastContainer');
    const toast = new bootstrap.Toast(toastContainer, {
        autohide: true,
        delay: 3000 
    });

    const toastBody = toastContainer.querySelector('.toast-body');
    toastBody.innerText = message;

    toastContainer.classList.remove('bg-success', 'bg-danger', 'bg-info', 'bg-warning');
    if (type === 'success') {
        toastContainer.classList.add('bg-success');
    } else if (type === 'error') {
        toastContainer.classList.add('bg-danger');
    } else if (type === 'info') {
        toastContainer.classList.add('bg-info');
    } else if (type === 'warning') {
        toastContainer.classList.add('bg-warning');
    }

    toast.show();
        }

        function viewTaskDetails(taskId) {
    const taskModal = new bootstrap.Modal(document.getElementById('taskModal'));

    taskModal._element.addEventListener('hidden.bs.modal', function () {
        const modalBackdrop = document.querySelector('.modal-backdrop');
        if (modalBackdrop) {
            modalBackdrop.remove();
        }
    });

    taskModal.show();

    fetch(`backend.php?action=getTaskDetails&taskId=${taskId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(taskDetails => {
            let importanceBadge = '';
                switch (taskDetails.importance) {
                    case 'not_important':
                        importanceBadge = '<span class="badge text-bg-primary">Normal</span>';
                        break;
                    case 'important':
                        importanceBadge = '<span class="badge text-bg-warning">Important</span>';
                        break;
                    case 'urgent':
                        importanceBadge = '<span class="badge text-bg-danger">Urgent</span>';
                        break;
                    default:
                        break;
                }

            const taskModalBody = document.getElementById('taskModalBody');
            const taskModalTitle = document.getElementById('taskModalLabel');
            taskModalBody.innerHTML = `
                <p> <strong>${importanceBadge}</strong></p>
                <p><strong>Description:</strong> ${taskDetails.description}</p>
                <p><strong>échéance:</strong> ${taskDetails.echeance}</p>
            `;
            taskModalTitle.innerHTML = `
                <p><strong>Titre:</strong> ${taskDetails.title}</p>
            `;
        })
        .catch(error => console.error('Error fetching task details:', error));
        }

        function deleteTask(taskId) {
    // Mettre en œuvre la requête AJAX pour supprimer une tâche et mettre à jour la liste des tâches
    fetch(`backend.php?action=deleteTask&taskId=${taskId}`, {
        method: 'DELETE', 
        headers: {
            'Content-Type': 'application/json',
        },
    })
        .then(response => response.json())
        .then(result => {
            if (result) {
                // Afficher un message de toast Bootstrap pour le succès
                showToast('Tâche supprimée avec succès', 'success');
                console.log(result);
            } else {
                // Afficher un message de toast Bootstrap en cas d'échec
                showToast('Échec de la suppression de la tâche', 'danger');
                            console.error('Failed to delete task:', result.message);

            }
        })
        .catch(error => {
            console.error('Erreur lors de la suppression de la tâche :', error);
            // Afficher un message de toast Bootstrap en cas d'erreur
            showToast('Erreur lors de la suppression de la tâche', 'danger');
        });

    // Retirer la tâche de la liste affichée
    const taskList = document.getElementById('taskList');
    const taskItem = taskList.querySelector(`[data-task-id="${taskId}"]`);
    taskItem.remove();
    console.log("Tâche supprimée");
        }

        function updateTask(taskId, newData) {
        fetch('backend.php?action=updateTask', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ taskId: taskId, newData: newData }),
    })
    .then(response => response.json())
    .then(result => {
        if (result.message === 'Task updated successfully') {
            showToast('Task updated successfully', 'success');
        } else {
            showToast('Failed to update task', 'danger');
        }
    })
    .catch(error => {
        console.error('Error updating task:', error);
        showToast('Error updating task', 'danger');
    });
        }

        function showToast(message, type) {
    const toastContainer = document.getElementById('toastContainer');
    const toast = new bootstrap.Toast(toastContainer, {
        autohide: true,
        delay: 3000, 
    });
    
    toastContainer.innerHTML = `<div class="toast-body bg-${type}">${message}</div>`;
    
    toast.show();
        }

