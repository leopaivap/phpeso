document.addEventListener('DOMContentLoaded', () => {
    const toggleIcons = document.querySelectorAll('[data-toggle-password]');
  
    toggleIcons.forEach(icon => {
      const inputId = icon.getAttribute('data-toggle-password');
      const input = document.getElementById(inputId);
  
      icon.addEventListener('click', () => {
        input.type = input.type === 'password' ? 'text' : 'password';
        icon.classList.toggle('fa-eye-slash');
      });
    });
  });
  