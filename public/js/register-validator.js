document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector(".register-form");

  form.addEventListener("submit", function (event) {
    const errors = [];
    let valid = true;

    const firstName = document.getElementById("firstName").value.trim();
    const lastName = document.getElementById("lastName").value.trim();
    const phoneNumber = document.getElementById("phoneNumber").value.trim();
    const gender = document.getElementById("gender").value;
    const birthDate = document.getElementById("birth_date").value;
    const username = document.getElementById("username").value.trim();
    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value;
    const confirmPassword = document.getElementById("confirmPassword").value;

    // Validações

    if (firstName.length < 2 || firstName.length > 50) {
      errors.push('O campo "Nome" deve ter entre 2 e 50 caracteres.');
      valid = false;
    }

    if (lastName.length < 2 || lastName.length > 50) {
      errors.push('O campo "Sobrenome" deve ter entre 2 e 50 caracteres.');
      valid = false;
    }

    if (!/^\d{10,15}$/.test(phoneNumber)) {
      errors.push(
        'O campo "Telefone" deve conter entre 10 e 15 dígitos numéricos.'
      );
      valid = false;
    }

    if (!gender) {
      errors.push('O campo "Gênero" é obrigatório.');
      valid = false;
    }

    if (!birthDate) {
      errors.push('O campo "Data de Nascimento" é obrigatório.');
      valid = false;
    }

    if (username.length < 5 || username.length > 30) {
      errors.push('O campo "Usuário" deve ter entre 5 e 30 caracteres.');
      valid = false;
    }

    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email) || email.length > 255) {
      errors.push("Informe um email válido com no máximo 255 caracteres.");
      valid = false;
    }

    if (password.length < 6 || password.length > 50) {
      errors.push("A senha deve ter entre 6 e 50 caracteres.");
      valid = false;
    }

    if (password !== confirmPassword) {
      errors.push("As senhas não coincidem.");
      valid = false;
    }

    // Remove alertas anteriores
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
      errors.forEach((error) => {
        const li = document.createElement("li");
        li.textContent = error;
        ul.appendChild(li);
      });

      alertDiv.appendChild(ul);
      form.parentNode.insertBefore(alertDiv, form);
    }
  });
});
