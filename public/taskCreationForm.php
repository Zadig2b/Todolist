<form id="taskForm">
<h1>Création de tâche</h1>

  <div class="mb-3">
    <label for="taskTitle" class="form-label">Titre de la tâche</label>
    <input type="text" class="form-control" id="taskTitle" required>
  </div>
  <div class="mb-3">
    <label for="taskDescription" class="form-label">Description de la tâche</label>
    <textarea class="form-control" id="taskDescription" rows="3" required></textarea>
  </div>
  <div class="mb-3">
    <label for="taskDate" class="form-label">Date de la tâche</label>
    <input type="date" class="form-control" id="taskDate" required>
  </div>
  <div class="mb-3">
  <label class="form-label">Importance de la tâche:
    <div class="form-check">
      <input type="radio" class="form-check-input" name="taskImportance" id="notImportant" value="not_important" checked>
      <label class="form-check-label" for="notImportant">Normal</label>
    </div>
    <div class="form-check">
      <input type="radio" class="form-check-input" name="taskImportance" id="important" value="important">
      <label class="form-check-label" for="important">Important</label>
    </div>
    <div class="form-check">
      <input type="radio" class="form-check-input" name="taskImportance" id="urgent" value="urgent">
      <label class="form-check-label" for="urgent">Urgent</label>
  </div>
  </div>
    <div class="mb-3">
  <div class="task-img-container">
    <div class="row">
    </div>
  </div>
  </label>
  <button type="button" class="btn btn-primary" onclick="createTaskFromInput()">Create Task</button>
</form>
