// Control del Splash Screen Oracle
document.addEventListener('DOMContentLoaded', () => {
    const splash = document.getElementById('oracle-splash');
    const mainContent = document.getElementById('main-content');
    
    // Siempre mostrar el splash al cargar la página
    // Remover el splash del DOM después de la animación
    setTimeout(() => {
        if (splash) {
            splash.remove();
        }
    }, 3500);
});
