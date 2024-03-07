
    let listItems = document.querySelectorAll('.list-group-item');
        listItems.forEach(item => {
            item.addEventListener('click', function() {
                listItems.forEach(item => {
                    item.classList.remove('active');
                });
                this.classList.add('active');
            });
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
                const listItem = document.createElement('li');
                listItem.innerHTML = `
                    <strong>${task.title}</strong>
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
            console.log(result.task); // Log the details of the newly created task
            displayTasks([result.task]);
        } else {
            console.error('Error creating task:', result.error);
        }
    })
    .catch(error => console.error('Error creating task:', error));
}
 


document.addEventListener('DOMContentLoaded', function () {
    fetchTasks();
});


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
