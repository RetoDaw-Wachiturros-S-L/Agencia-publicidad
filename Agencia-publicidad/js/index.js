document.getElementById('btnLogin')?.addEventListener('click', () => {
    // ejemplo: redirigir a la pantalla de login (ajusta la URL si hace falta)
    window.location.href = '../index.php?controller=OutController&accion=iniciarSesion';
});