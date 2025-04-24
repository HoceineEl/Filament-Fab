/**
 * Filament FAB - Floating Action Button
 */

document.addEventListener('DOMContentLoaded', function () {
    // Listen for FAB action clicks
    document.querySelectorAll('.fab-action').forEach(action => {
        action.addEventListener('click', function (event) {
            const actionName = event.currentTarget.dataset.action;
            // Dispatch an event that can be listened to
            document.dispatchEvent(new CustomEvent('fab:action', {
                detail: {
                    action: actionName
                }
            }));
        });
    });
});

// Setup Alpine.js component if available
if (window.Alpine) {
    window.Alpine.data('fabActions', () => ({
        init() {
            // Initialize FAB actions if needed
        },

        // Action handlers can be defined here
        handleAction(name) {
            document.dispatchEvent(new CustomEvent('fab:action', {
                detail: {
                    action: name
                }
            }));
        }
    }));
} 