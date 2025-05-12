document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("exerciseForm");

  form.addEventListener("submit", function (event) {
    let valid = true;
    const errors = [];

    const nameField = document.getElementById("exercise_name");
    const typeField = document.getElementById("exercise_type");
    const descriptionField = document.getElementById("description");
    const muscleGroupField = document.getElementById("muscle_group");
    const difficultyField = document.getElementById("difficulty");

    const nameValue = nameField.value.trim();
    const typeValue = typeField.value.trim();
    const descriptionValue = descriptionField.value.trim();

    if (nameValue.length < 5 || nameValue.length > 30) {
      errors.push(
        'O campo "Nome do Exercício" deve ter entre 5 e 30 caracteres.'
      );
      valid = false;
    }

    if (typeValue.length < 5 || typeValue.length > 30) {
      errors.push(
        'O campo "Tipo de Exercício" deve ter entre 5 e 30 caracteres.'
      );
      valid = false;
    }

    if (descriptionValue.length < 5 || descriptionValue.length > 55) {
      errors.push('O campo "Descrição" deve ter entre 5 e 55 caracteres.');
      valid = false;
    }

    if (muscleGroupField.value === "") {
      errors.push("Você precisa selecionar um grupo muscular.");
      valid = false;
    }

    if (difficultyField.value === "") {
      errors.push("Você precisa selecionar a dificuldade.");
      valid = false;
    }

    const existingAlert = document.querySelector(".alert.alert-danger");
    if (existingAlert) {
      existingAlert.remove();
    }

    if (!valid) {
      event.preventDefault();

      const alertDiv = document.createElement("div");
      alertDiv.className = "alert alert-danger";
      alertDiv.setAttribute("role", "alert");

      const ul = document.createElement("ul");
      errors.forEach(function (error) {
        const li = document.createElement("li");
        li.textContent = error;
        ul.appendChild(li);
      });

      alertDiv.appendChild(ul);
      form.parentNode.insertBefore(alertDiv, form);
    }
  });
});
