<!-- Toast Notification Container -->
<div id="toast-container" class="fixed top-20 right-4 z-[9999] space-y-3 pointer-events-none">
    <!-- Toasts will be injected here by JavaScript -->
</div>

<style>
    .toast {
        pointer-events: auto;
        animation: slideInRight 0.3s ease-out;
        min-width: 300px;
        max-width: 400px;
    }

    .toast.removing {
        animation: slideOutRight 0.3s ease-in forwards;
    }

    @keyframes slideInRight {
        from {
            transform: translateX(400px);
            opacity: 0;
        }

        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }

        to {
            transform: translateX(400px);
            opacity: 0;
        }
    }

    .toast-progress {
        animation: progress linear forwards;
    }

    @keyframes progress {
        from {
            width: 100%;
        }

        to {
            width: 0%;
        }
    }
</style>

<script>
    window.showToast = function (message, type = 'info', duration = 4000) {
        const container = document.getElementById('toast-container');
        const toastId = 'toast-' + Date.now();

        // Icon dan warna berdasarkan tipe
        const config = {
            success: {
                icon: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                      </svg>`,
                bgColor: 'bg-green-50',
                borderColor: 'border-green-500',
                iconBg: 'bg-green-500',
                textColor: 'text-green-800',
                progressColor: 'bg-green-500'
            },
            error: {
                icon: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                      </svg>`,
                bgColor: 'bg-red-50',
                borderColor: 'border-red-500',
                iconBg: 'bg-red-500',
                textColor: 'text-red-800',
                progressColor: 'bg-red-500'
            },
            warning: {
                icon: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                      </svg>`,
                bgColor: 'bg-yellow-50',
                borderColor: 'border-yellow-500',
                iconBg: 'bg-yellow-500',
                textColor: 'text-yellow-800',
                progressColor: 'bg-yellow-500'
            },
            info: {
                icon: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                      </svg>`,
                bgColor: 'bg-blue-50',
                borderColor: 'border-blue-500',
                iconBg: 'bg-blue-500',
                textColor: 'text-blue-800',
                progressColor: 'bg-blue-500'
            }
        };

        const style = config[type] || config.info;

        const toast = document.createElement('div');
        toast.id = toastId;
        toast.className = `toast ${style.bgColor} ${style.textColor} border-l-4 ${style.borderColor} rounded-lg shadow-lg overflow-hidden`;
        toast.innerHTML = `
            <div class="p-4 flex items-start gap-3">
                <div class="${style.iconBg} rounded-full p-1 text-white flex-shrink-0">
                    ${style.icon}
                </div>
                <div class="flex-1 pt-0.5">
                    <p class="text-sm font-medium">${message}</p>
                </div>
                <button onclick="window.removeToast('${toastId}')" class="flex-shrink-0 text-gray-400 hover:text-gray-600 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="h-1 ${style.bgColor}">
                <div class="h-full ${style.progressColor} toast-progress" style="animation-duration: ${duration}ms"></div>
            </div>
        `;

        container.appendChild(toast);

        // Auto remove setelah duration
        setTimeout(() => {
            window.removeToast(toastId);
        }, duration);
    };

    window.removeToast = function (toastId) {
        const toast = document.getElementById(toastId);
        if (toast) {
            toast.classList.add('removing');
            setTimeout(() => {
                toast.remove();
            }, 300);
        }
    };
</script>