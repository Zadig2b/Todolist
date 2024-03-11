document.addEventListener('DOMContentLoaded', function () {
    fetchTasks();
});

// Use event delegation at the document level for dynamically added elements
document.addEventListener('click', function (event) {
    let target = event.target;
    if (target.classList.contains('list-group-item')) {
        // Remove 'active' class from all items
        document.querySelectorAll('.list-group-item').forEach(item => {
            item.classList.remove('active');
        });
        // Add 'active' class to the clicked item
        target.classList.add('active');
        console.log("class active added");

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
                let deleteButton = '<button type="button" class="btn btn-danger">x</button>'

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
                <div class=liheader>
                    ${importanceBadge}
                    <strong>${task.title}</strong>
                    ${editButton}${deleteButton}</div>
                    <p class=description>${task.description}</p>
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
            displayTasks([result.task]);
        } else {
            console.error('Error creating task:', result.error);
        }
    })
    .catch(error => console.error('Error creating task:', error));
}
 





function viewTaskDetails(taskId) {
    // Open the Bootstrap modal
    const taskModal = new bootstrap.Modal(document.getElementById('taskModal'));
    taskModal.show();

    // Implement AJAX request to fetch task details and display them in the modal
    fetch(`backend.php?action=getTaskDetails&taskId=${taskId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(taskDetails => {
            // Display task details in the modal body
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



// Function to validate a task
function validateTask(taskId) {
    // Implement AJAX request to validate a task and update the task list
    // set a click listener on deleteButton: on click , 
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

