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

// Validación de imágenes
const ImageValidator = {
    allowedTypes: ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'],
    maxSize: 5242880, // 5MB
    
    validate: function(file) {
        const errors = [];
        
        // Validar tipo de archivo
        if (!this.allowedTypes.includes(file.type)) {
            errors.push('Tipo de imagen no soportado. Los formatos permitidos son: JPEG, PNG, GIF y WEBP.');
        }
        
        // Validar tamaño
        if (file.size > this.maxSize) {
            const sizeMB = (this.maxSize / 1024 / 1024).toFixed(0);
            errors.push(`La imagen es demasiado grande. El tamaño máximo permitido es ${sizeMB}MB.`);
        }
        
        return {
            valid: errors.length === 0,
            errors: errors
        };
    },
    
    showError: function(message) {
        // Crear alerta Bootstrap
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-danger alert-dismissible fade show m-3';
        alertDiv.innerHTML = `
            <i class="bi bi-exclamation-triangle"></i> ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        // Insertar al inicio del main
        const main = document.querySelector('main');
        if (main) {
            main.insertBefore(alertDiv, main.firstChild);
            
            // Auto-cerrar después de 5 segundos
            setTimeout(() => {
                alertDiv.remove();
            }, 5000);
        }
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
    
    // Validación de imágenes en inputs de tipo file
    document.querySelectorAll('input[type="file"][accept*="image"]').forEach(input => {
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const validation = ImageValidator.validate(file);
                if (!validation.valid) {
                    // Mostrar errores
                    validation.errors.forEach(error => {
                        ImageValidator.showError(error);
                    });
                    // Limpiar el input
                    e.target.value = '';
                }
            }
        });
    });
});

// Exportar para uso global
window.Utils = Utils;
window.APP_CONFIG = APP_CONFIG;
window.ImageValidator = ImageValidator;

