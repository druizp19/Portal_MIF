// Dashboard page JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Confirmación antes de cerrar sesión
    const logoutForm = document.querySelector('.logout-form');
    const logoutButton = document.querySelector('.logout-button');
    
    if (logoutButton && logoutForm) {
        logoutButton.addEventListener('click', function(e) {
            e.preventDefault();
            
            if (confirm('¿Estás seguro de que deseas cerrar sesión?')) {
                logoutForm.submit();
            }
        });
    }
});
