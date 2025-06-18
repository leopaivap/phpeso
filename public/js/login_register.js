document.addEventListener("DOMContentLoaded", () => {
  const individualToggleSpans = document.querySelectorAll(
    "span[data-toggle-password]"
  );

  individualToggleSpans.forEach((span) => {
    if (!span.classList.contains("toggle-password-register")) {
      span.addEventListener("click", () => {
        const inputId = span.getAttribute("data-toggle-password");
        const input = document.getElementById(inputId);
        const icon = span.querySelector("i");

        if (input.type === "password") {
          input.type = "text";
          icon.classList.remove("fa-eye");
          icon.classList.add("fa-eye-slash");
        } else {
          input.type = "password";
          icon.classList.remove("fa-eye-slash");
          icon.classList.add("fa-eye");
        }
      });
    }
  });

  const registerToggleSpans = document.querySelectorAll(
    ".toggle-password-register"
  );

  if (registerToggleSpans.length > 0) {
    const registerPasswordInputs = document.querySelectorAll(
      ".password-input-register"
    );
    const registerPasswordIcons = document.querySelectorAll(
      ".password-icon-register"
    );

    registerToggleSpans.forEach((span) => {
      span.addEventListener("click", () => {
        const isPassword = registerPasswordInputs[0].type === "password";

        registerPasswordInputs.forEach((input) => {
          input.type = isPassword ? "text" : "password";
        });

        registerPasswordIcons.forEach((icon) => {
          if (isPassword) {
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
          } else {
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
          }
        });
      });
    });
  }
});
