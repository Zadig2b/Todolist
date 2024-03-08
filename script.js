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

        const taskId = target.dataset.taskId; // Assuming you have a data-taskId attribute
        // Now you can perform additional actions related to the selected task, if needed
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
                let deleteButton = document.createElement('button')
                deleteButton.innerHTML = 'Delete'
                deleteButton.setAttribute('data-bs-toggle', 'modal')
                deleteButton.setAttribute('data-bs-target', '#deleteModal')
                deleteButton.setAttribute('data-task-id', task.id)
                listItem.appendChild(deleteButton)
                listItem.setAttribute('data-task-id', task.id)
                listItem.setAttribute('data-task-title', task.title)
                listItem.setAttribute('data-task-description', task.description)
                listItem.setAttribute('data-task-importance', task.importance)
                listItem.setAttribute('data-task-status', task.status)
                listItem.setAttribute('data-task-created-at', task.created_at)
                listItem.setAttribute('data-task-updated-at', task.updated_at)
                listItem.setAttribute('data-task-completed-at', task.completed_at)

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
                    ${editButton}</div>
                    <p>${task.description}</p>
                    <p>Importance: ${task.importance}</p>
                `;
                taskList.appendChild(listItem);
            });
        }
        
        

function createTaskFromInput() {
    const title = document.getElementById('taskTitle').value;
    const description = document.getElementById('taskDescription').value;
    let importance;
    const radioButtons = document.getElementsByName('taskImportance');
    radioButtons.forEach(radio => {
        if (radio.checked) {
            importance = radio.value;
        }
    });
    createTask(title, description, importance);
}

function createTask(title, description, importance) {
    const taskData = {
        title: title,
        description: description,
        importance: importance
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
}

// Function to validate a task
function validateTask(taskId) {
    // Implement AJAX request to validate a task and update the task list
}

// Function to update a task
function updateTask(taskId, newData) {
    // Implement AJAX request to send updated task data to the backend and update the task list
}
