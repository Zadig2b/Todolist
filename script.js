document.addEventListener('DOMContentLoaded', function () {
    fetchTasks();
});

// Use event delegation at the document level for dynamically added elements
document.addEventListener('click', function (event) {
    let target = event.target;

    if (target.classList.contains('btn-success')) {
        // Get the task ID from the button's ID
        const taskId = target.id.split('-')[1];
        deleteTask(taskId);
    }

    if (target.classList.contains('list-group-item')) {
        // Remove 'active' class from all items
        document.querySelectorAll('.list-group-item').forEach(item => {
            item.classList.remove('active');
        });

        // Add 'active' class to the clicked item
        target.classList.add('active');

        const taskId = target.dataset.taskId;
        viewTaskDetails(taskId);
    }
});





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
        



        function displayTasks(tasks) {
            const taskList = document.getElementById('taskList');
        
            tasks.forEach(task => {
                let listItem = document.createElement('li');
                listItem.classList.add('list-group-item');
                let editButton = '<button type="button" class="btn btn-secondary">Edit</button>'    
                editButton.style = 'position:absolute; right:0px'           
                let deleteButton = `<button id="deletebtn-${task.id}" type="button" class="btn btn-success">Validée</button> `;

                listItem.setAttribute('data-task-id', task.id)
                listItem.setAttribute('data-task-title', task.title)
                listItem.setAttribute('data-task-description', task.description)
                listItem.setAttribute('data-task-importance', task.importance)
                listItem.setAttribute('data-task-status', task.status)
                listItem.setAttribute('data-task-created-at', task.created_at)
                listItem.setAttribute('data-task-updated-at', task.updated_at)
                listItem.setAttribute('data-task-completed-at', task.completed_at)
                listItem.setAttribute('data-task-complete-on', task.completed_at)


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
                    <strong>${task.title}</strong>
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
    console.log(echeance);
    const radioButtons = document.getElementsByName('taskImportance');
    radioButtons.forEach(radio => {
        if (radio.checked) {
            importance = radio.value;
        }
    });
    createTask(title, description, importance, echeance);
}

function createTask(title, description, importance, echeance) {
    if (!title.trim()) {
        showToast('le titre d\'une tâche ne peut être vide', 'warning');
        return;
    }

    const taskData = {
        title: title,
        description: description,
        importance: importance,
        echeance: echeance
    };

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
            showToast(result.error, 'error');
        }
    })
    .catch(error => {
        console.error('Error creating task:', error);
        showToast('An unexpected error occurred', 'error');
    });
}

function showToast(message, type) {
    // Display Bootstrap toast message
    const toastContainer = document.getElementById('toastContainer');
    const toast = new bootstrap.Toast(toastContainer, {
        autohide: true,
        delay: 3000 // Adjust the duration of the toast message
    });

    const toastBody = toastContainer.querySelector('.toast-body');
    toastBody.innerText = message;

    // Apply Bootstrap toast color based on type (success, error, etc.)
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
    // Open the Bootstrap modal
    const taskModal = new bootstrap.Modal(document.getElementById('taskModal'));

    // Add an event listener for the modal hidden event
    taskModal._element.addEventListener('hidden.bs.modal', function () {
        // Remove the modal backdrop when the modal is hidden
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
            const taskModalBody = document.getElementById('taskModalBody');
            const taskModalTitle = document.getElementById('taskModalLabel');
            taskModalBody.innerHTML = `
                <p><strong>Description:</strong> ${taskDetails.description}</p>
                <p><strong>Importance:</strong> ${taskDetails.importance}</p>
                <p><strong>échéance:</strong> ${taskDetails.echeance}</p>
            `;
            taskModalTitle.innerHTML = `
                <p><strong>Title:</strong> ${taskDetails.title}</p>
            `;
        })
        .catch(error => console.error('Error fetching task details:', error));
}




// Fonction pour supprimer une tâche
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
            if (result.message === 'Tâche supprimée avec succès') {
                // Afficher un message de toast Bootstrap pour le succès
                showToast('Tâche supprimée avec succès', 'success');
            } else {
                // Afficher un message de toast Bootstrap en cas d'échec
                showToast('Échec de la suppression de la tâche', 'danger');
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



// Function to update a task
function updateTask(taskId, newData) {
    // Implement AJAX request to send updated task data to the backend
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
            // Display a Bootstrap Toast message for success
            showToast('Task updated successfully', 'success');
        } else {
            // Display a Bootstrap Toast message for failure
            showToast('Failed to update task', 'danger');
        }
    })
    .catch(error => {
        console.error('Error updating task:', error);
        // Display a Bootstrap Toast message for error
        showToast('Error updating task', 'danger');
    });
}

// Function to display Bootstrap Toast message
function showToast(message, type) {
    const toastContainer = document.getElementById('toastContainer');
    const toast = new bootstrap.Toast(toastContainer, {
        autohide: true,
        delay: 3000, // Adjust the delay as needed
    });
    
    // Update toast content and class based on the message type
    toastContainer.innerHTML = `<div class="toast-body bg-${type}">${message}</div>`;
    
    // Show the toast
    toast.show();
}

