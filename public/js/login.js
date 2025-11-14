// Login page JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Animación suave para el botón de Microsoft
    const microsoftButton = document.querySelector('.microsoft-button');
    
    if (microsoftButton) {
        microsoftButton.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        
        microsoftButton.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    }
    
    // Auto-hide error message después de 5 segundos
    const errorMessage = document.querySelector('.error-message');
    if (errorMessage) {
        setTimeout(function() {
            errorMessage.style.transition = 'opacity 0.5s ease';
            errorMessage.style.opacity = '0';
            setTimeout(function() {
                errorMessage.style.display = 'none';
            }, 500);
        }, 5000);
    }
});
