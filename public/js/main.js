/**
 * JavaScript principal para Tennis y Fragancias
 */

// Configuración global
const APP_CONFIG = {
    baseUrl: window.location.origin + '/tennisyfragancias/',
    animationDuration: 300
};

// Utilidades
const Utils = {
    // Formatear precio
    formatPrice: (price) => {
        return new Intl.NumberFormat('es-CO', {
            style: 'currency',
            currency: 'COP',
            minimumFractionDigits: 0
        }).format(price);
    },
    
    // Mostrar loading
    showLoading: () => {
        const overlay = document.createElement('div');
        overlay.className = 'spinner-overlay';
        overlay.id = 'loading-overlay';
        overlay.innerHTML = '<div class="spinner-border text-light" role="status"></div>';
        document.body.appendChild(overlay);
    },
    
    // Ocultar loading
    hideLoading: () => {
        const overlay = document.getElementById('loading-overlay');
        if (overlay) {
            overlay.remove();
        }
    },
    
    // Confirmar acción
    confirm: (message) => {
        return window.confirm(message);
    },
    
    // Toast notification
    toast: (message, type = 'info') => {
        // Usar Bootstrap Toast o crear uno simple
        alert(message);
    }
};

// Inicialización al cargar el documento
document.addEventListener('DOMContentLoaded', function() {
    // Activar tooltips de Bootstrap
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Activar popovers de Bootstrap
    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
    
    // Animación de entrada para cards
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in');
            }
        });
    });
    
    document.querySelectorAll('.producto-card').forEach(card => {
        observer.observe(card);
    });
});

// Exportar para uso global
window.Utils = Utils;
window.APP_CONFIG = APP_CONFIG;

