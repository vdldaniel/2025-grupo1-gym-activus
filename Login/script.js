// script.js

const form = document.getElementById('loginForm');
const loginButton = document.getElementById('loginButton');

form.addEventListener('submit', function(e) {
  e.preventDefault();

  loginButton.disabled = true;
  loginButton.textContent = 'Iniciando...';

  setTimeout(() => {
    loginButton.disabled = false;
    loginButton.textContent = 'Iniciar Sesión';
    alert('Sesión iniciada (demo)');
  }, 1500);
});
